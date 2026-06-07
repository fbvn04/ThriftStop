<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product as Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function getToko()
    {
        return Toko::where('user_id', Auth::id())->with('user')->first();
    }

    private function isTokoLengkap($toko): bool
    {
        if (!$toko) return false;

        return !empty($toko->nama_toko)
            && !empty($toko->provinsi_id)
            && !empty($toko->kota_id)
            && !empty($toko->kecamatan_id)
            && !empty($toko->user->hp);
    }

    public function index(Request $request)
    {
        $toko = $this->getToko();
        $tokoLengkap = $this->isTokoLengkap($toko);

        $query = Produk::where('toko_id', $toko->id)->aktif();

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('stok')) {
            match ($request->stok) {
                'Tersedia'     => $query->where('stok', '>', 0),
                'Hampir Habis' => $query->where('stok', '<=', 2)->where('stok', '>', 0),
                'Habis'        => $query->where('stok', 0),
                default        => null,
            };
        }

        match ($request->get('sort', 'Terbaru')) {
            'Termurah' => $query->orderBy('harga', 'asc'),
            'Termahal' => $query->orderBy('harga', 'desc'),
            default    => $query->latest(),
        };

        $produks = $query->get();

        $totalProduk  = Produk::where('toko_id', $toko->id)->aktif()->count();
        $stokTersedia = Produk::where('toko_id', $toko->id)->aktif()->where('stok', '>', 2)->count();
        $hampirHabis  = Produk::where('toko_id', $toko->id)->aktif()->where('stok', '<=', 2)->where('stok', '>', 0)->count();

        return view('seller.kelola-produk', compact(
            'toko',
            'produks',
            'totalProduk',
            'stokTersedia',
            'hampirHabis',
            'tokoLengkap',
        ));
    }

    public function store(Request $request)
    {
        $toko = $this->getToko();

        // Blok kalau profil belum lengkap
        if (!$this->isTokoLengkap($toko)) {
            return redirect()->route('seller.produk')
                ->with('error', 'Lengkapi profil toko terlebih dahulu.');
        }

        $request->validate([
            'nama_produk'    => 'required|string|max:255',
            'harga'          => 'required|integer|min:0',
            'stok'           => 'required|integer|min:0',
            'kategori'       => 'nullable|string|max:100',
            'kondisi'        => 'nullable|string|max:100',
            'ukuran'         => 'nullable|string|max:100',
            'deskripsi'      => 'nullable|string',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('produk/' . $toko->id, 'public');
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
            'foto'         => $foto,
            'is_aktif'     => true,
        ]);

        return redirect()->route('seller.produk')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

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
            'foto'         => $produk->foto
                ? Storage::url($produk->foto)
                : null,
        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori'    => 'nullable|string|max:100',
            'kondisi'     => 'nullable|string|max:100',
            'ukuran'      => 'nullable|string|max:100',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $produk->foto = $request->file('foto')
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
            'foto'        => $produk->foto,
        ]);

        return redirect()->route('seller.produk')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);

        $produk->update(['is_aktif' => false]);

        return redirect()->route('seller.produk')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyPermanent(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);

        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('seller.produk')
            ->with('success', 'Produk berhasil dihapus permanen.');
    }

    public function detail(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);
        return view('seller.detail-produk', compact('toko', 'produk'));
    }

    public function edit(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);
        return view('seller.edit-produk', compact('toko', 'produk'));
    }
}