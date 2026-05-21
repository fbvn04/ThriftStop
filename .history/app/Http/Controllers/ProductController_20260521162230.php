<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // ── Ambil toko milik seller yang sedang login
    private function getToko()
    {
        return Toko::where('user_id', Auth::id())->firstOrFail();
    }

    // ────────────────────────────────────────────
    // INDEX — Tampilkan halaman Kelola Produk
    // ────────────────────────────────────────────
    public function index(Request $request)
    {
        $toko = $this->getToko();

        $query = Produk::where('toko_id', $toko->id)->aktif();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        // Filter stok
        if ($request->filled('stok')) {
            match ($request->stok) {
                'Tersedia'     => $query->where('stok', '>', 0),
                'Hampir Habis' => $query->where('stok', '<=', 2)->where('stok', '>', 0),
                'Habis'        => $query->where('stok', 0),
                default        => null,
            };
        }

        // Urutan
        match ($request->get('sort', 'Terbaru')) {
            'Termurah' => $query->orderBy('harga', 'asc'),
            'Termahal' => $query->orderBy('harga', 'desc'),
            default    => $query->latest(),
        };

        $produks = $query->get();

        // Stats
        $totalProduk   = Produk::where('toko_id', $toko->id)->aktif()->count();
        $stokTersedia  = Produk::where('toko_id', $toko->id)->aktif()->where('stok', '>', 2)->count();
        $hampirHabis   = Produk::where('toko_id', $toko->id)->aktif()->where('stok', '<=', 2)->where('stok', '>', 0)->count();

        return view('seller.kelola-produk', compact(
            'toko',
            'produks',
            'totalProduk',
            'stokTersedia',
            'hampirHabis',
        ));
    }

    // ────────────────────────────────────────────
    // STORE — Simpan produk baru
    // ────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'harga'        => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
            'kategori'     => 'nullable|string|max:100',
            'kondisi'      => 'nullable|string|max:100',
            'ukuran'       => 'nullable|string|max:100',
            'deskripsi'    => 'nullable|string',
            'foto_utama'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_lainnya' => 'nullable|array',
            'foto_lainnya.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $toko = $this->getToko();

        // Upload foto utama
        $fotoUtama = null;
        if ($request->hasFile('foto_utama')) {
            $fotoUtama = $request->file('foto_utama')
                ->store('produk/' . $toko->id, 'public');
        }

        // Upload foto lainnya
        $fotoLainnya = [];
        if ($request->hasFile('foto_lainnya')) {
            foreach ($request->file('foto_lainnya') as $foto) {
                $fotoLainnya[] = $foto->store('produk/' . $toko->id, 'public');
            }
        }

        Produk::create([
            'toko_id'      => $toko->id,
            'nama_produk'  => $request->nama_produk,
            'deskripsi'    => $request->deskripsi,
            'harga'        => $request->harga,
            'stok'         => $request->stok,
            'kategori'     => $request->kategori,
            'kondisi'      => $request->kondisi,
            'ukuran'       => $request->ukuran,
            'foto_utama'   => $fotoUtama,
            'foto_lainnya' => $fotoLainnya ?: null,
            'is_aktif'     => true,
        ]);

        return redirect()->route('seller.produk')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // ────────────────────────────────────────────
    // SHOW — Detail produk (JSON untuk modal)
    // ────────────────────────────────────────────
    public function show(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);

        return response()->json([
            'id'           => $produk->id,
            'nama_produk'  => $produk->nama_produk,
            'deskripsi'    => $produk->deskripsi,
            'harga'        => $produk->harga,
            'stok'         => $produk->stok,
            'kategori'     => $produk->kategori,
            'kondisi'      => $produk->kondisi,
            'ukuran'       => $produk->ukuran,
            'foto_utama'   => $produk->foto_utama
                ? Storage::url($produk->foto_utama)
                : null,
            'foto_lainnya' => collect($produk->foto_lainnya ?? [])
                ->map(fn($f) => Storage::url($f))
                ->values(),
        ]);
    }

    // ────────────────────────────────────────────
    // UPDATE — Edit produk
    // ────────────────────────────────────────────
    public function update(Request $request, Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);

        $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'harga'        => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
            'kategori'     => 'nullable|string|max:100',
            'kondisi'      => 'nullable|string|max:100',
            'ukuran'       => 'nullable|string|max:100',
            'deskripsi'    => 'nullable|string',
            'foto_utama'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Ganti foto utama jika ada upload baru
        if ($request->hasFile('foto_utama')) {
            // Hapus foto lama
            if ($produk->foto_utama) {
                Storage::disk('public')->delete($produk->foto_utama);
            }
            $produk->foto_utama = $request->file('foto_utama')
                ->store('produk/' . $toko->id, 'public');
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori'    => $request->kategori,
            'kondisi'     => $request->kondisi,
            'ukuran'      => $request->ukuran,
            'foto_utama'  => $produk->foto_utama,
        ]);

        return redirect()->route('seller.kelola-produk')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // ────────────────────────────────────────────
    // DESTROY — Hapus produk (soft delete via is_aktif)
    // ────────────────────────────────────────────
    public function destroy(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);

        // Soft delete: nonaktifkan saja, tidak benar-benar hapus
        $produk->update(['is_aktif' => false]);

        return redirect()->route('seller.kelola-produk')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // ────────────────────────────────────────────
    // DESTROY PERMANENT — Hapus produk beserta fotonya
    // ────────────────────────────────────────────
    public function destroyPermanent(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);

        // Hapus semua foto dari storage
        if ($produk->foto_utama) {
            Storage::disk('public')->delete($produk->foto_utama);
        }
        foreach ($produk->foto_lainnya ?? [] as $foto) {
            Storage::disk('public')->delete($foto);
        }

        $produk->delete();

        return redirect()->route('seller.kelola-produk')
            ->with('success', 'Produk berhasil dihapus permanen.');
    }
}