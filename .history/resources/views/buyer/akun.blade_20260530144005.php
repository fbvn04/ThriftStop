<x-layout-buyer :user="auth()->user()" titlePage="Akun Saya">

    @push('styles')
        <style>
            /* ── Tab Navigation ── */
            .tab-nav {
                display: flex;
                gap: 4px;
                background: #fff;
                border-radius: 16px;
                padding: 6px;
                box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
                margin-bottom: 24px;
                width: fit-content;
            }

            .tab-btn {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 9px 18px;
                border-radius: 11px;
                font-size: 13px;
                font-weight: 600;
                color: #888;
                cursor: pointer;
                border: none;
                background: transparent;
                transition: all .2s ease;
                white-space: nowrap;
            }

            .tab-btn:hover {
                color: #FF5500;
                background: #FFF3EC;
            }

            .tab-btn.active {
                background: #FF5500;
                color: #fff;
            }

            .tab-btn i {
                font-size: 13px;
            }

            /* ── Tab Panels ── */
            .tab-panel {
                display: none;
            }

            .tab-panel.active {
                display: block;
            }

            /* ── Card ── */
            .akun-card {
                background: #fff;
                border-radius: 20px;
                padding: 28px;
                box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
            }

            .akun-card-title {
                font-size: 15px;
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 6px;
            }

            .akun-card-sub {
                font-size: 12px;
                color: #aaa;
                margin-bottom: 24px;
            }

            /* ── Form ── */
            .form-group {
                margin-bottom: 18px;
            }

            .form-label {
                display: block;
                font-size: 12px;
                font-weight: 600;
                color: #555;
                margin-bottom: 6px;
            }

            .form-input {
                width: 100%;
                height: 42px;
                border: 1.5px solid #ede4d4;
                border-radius: 11px;
                padding: 0 14px;
                font-family: 'Poppins', sans-serif;
                font-size: 13px;
                color: #1a1a1a;
                background: #fafafa;
                outline: none;
                transition: border-color .2s, background .2s;
            }

            .form-input:focus {
                border-color: #FF5500;
                background: #fff;
            }

            .form-input:disabled {
                background: #f5f5f5;
                color: #aaa;
                cursor: not-allowed;
            }

            .form-textarea {
                width: 100%;
                border: 1.5px solid #ede4d4;
                border-radius: 11px;
                padding: 12px 14px;
                font-family: 'Poppins', sans-serif;
                font-size: 13px;
                color: #1a1a1a;
                background: #fafafa;
                outline: none;
                resize: vertical;
                min-height: 90px;
                transition: border-color .2s, background .2s;
            }

            .form-textarea:focus {
                border-color: #FF5500;
                background: #fff;
            }

            .form-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            /* ── Foto Profil ── */
            .foto-wrap {
                display: flex;
                align-items: center;
                gap: 20px;
                margin-bottom: 28px;
                padding-bottom: 24px;
                border-bottom: 1px solid #f0e9d8;
            }

            .foto-avatar {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: cover;
                ring: 3px solid #FF5500/20;
                flex-shrink: 0;
            }

            .foto-placeholder {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: #FF5500/10;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                color: #FF5500;
                flex-shrink: 0;
                background: #FFF3EC;
            }

            .foto-upload-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 16px;
                border-radius: 10px;
                border: 1.5px solid #ede4d4;
                font-size: 12px;
                font-weight: 600;
                color: #555;
                cursor: pointer;
                transition: all .2s;
                background: #fff;
            }

            .foto-upload-btn:hover {
                border-color: #FF5500;
                color: #FF5500;
            }

            .foto-note {
                font-size: 11px;
                color: #bbb;
                margin-top: 4px;
            }

            /* ── Button ── */
            .btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 24px;
                border-radius: 12px;
                background: #FF5500;
                color: #fff;
                font-size: 13px;
                font-weight: 600;
                border: none;
                cursor: pointer;
                transition: background .2s;
            }

            .btn-primary:hover {
                background: #e04d00;
            }

            .btn-secondary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                border-radius: 12px;
                background: #fff;
                color: #555;
                font-size: 13px;
                font-weight: 600;
                border: 1.5px solid #ede4d4;
                cursor: pointer;
                transition: all .2s;
            }

            .btn-secondary:hover {
                border-color: #FF5500;
                color: #FF5500;
            }

            .btn-danger {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 9px 16px;
                border-radius: 10px;
                background: #fff;
                color: #ef4444;
                font-size: 12px;
                font-weight: 600;
                border: 1.5px solid #fecaca;
                cursor: pointer;
                transition: all .2s;
            }

            .btn-danger:hover {
                background: #fef2f2;
            }

            /* ── Riwayat Pesanan ── */
            .pesanan-card {
                background: #fff;
                border-radius: 16px;
                border: 1.5px solid #f0e9d8;
                padding: 18px 20px;
                margin-bottom: 12px;
                transition: box-shadow .2s;
            }

            .pesanan-card:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, .07);
            }

            .pesanan-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 14px;
                flex-wrap: wrap;
                gap: 8px;
            }

            .pesanan-id {
                font-size: 12px;
                font-weight: 700;
                color: #1a1a1a;
            }

            .pesanan-tgl {
                font-size: 11px;
                color: #aaa;
                margin-top: 2px;
            }

            .pesanan-status {
                font-size: 11px;
                font-weight: 700;
                padding: 4px 12px;
                border-radius: 999px;
            }

            .status-selesai {
                background: #dcfce7;
                color: #15803d;
            }

            .status-diproses {
                background: #fef9c3;
                color: #a16207;
            }

            .status-dikirim {
                background: #dbeafe;
                color: #1d4ed8;
            }

            .status-dibatalkan {
                background: #fee2e2;
                color: #dc2626;
            }

            .status-menunggu {
                background: #f3f4f6;
                color: #6b7280;
            }

            .pesanan-items {
                display: flex;
                gap: 10px;
                padding: 12px 0;
                border-top: 1px solid #f5f0e8;
                border-bottom: 1px solid #f5f0e8;
                margin-bottom: 12px;
                overflow-x: auto;
            }

            .pesanan-item-img {
                width: 52px;
                height: 64px;
                border-radius: 10px;
                object-fit: cover;
                flex-shrink: 0;
                background: #f5f0e8;
            }

            .pesanan-item-placeholder {
                width: 52px;
                height: 64px;
                border-radius: 10px;
                background: #f5f0e8;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #d4c5a9;
                font-size: 18px;
                flex-shrink: 0;
            }

            .pesanan-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 8px;
            }

            .pesanan-total-label {
                font-size: 11px;
                color: #aaa;
            }

            .pesanan-total {
                font-size: 15px;
                font-weight: 800;
                color: #FF5500;
            }

            .pesanan-detail-btn {
                font-size: 12px;
                font-weight: 600;
                color: #FF5500;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .pesanan-detail-btn:hover {
                text-decoration: underline;
            }

            /* ── Alamat ── */
            .alamat-card {
                background: #fff;
                border-radius: 16px;
                border: 1.5px solid #f0e9d8;
                padding: 18px 20px;
                margin-bottom: 12px;
                position: relative;
                transition: box-shadow .2s;
            }

            .alamat-card:hover {
                box-shadow: 0 6px 20px rgba(0, 0, 0, .07);
            }

            .alamat-card.utama {
                border-color: #FF5500;
            }

            .alamat-utama-badge {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-size: 10px;
                font-weight: 700;
                color: #FF5500;
                background: #FFF3EC;
                padding: 3px 10px;
                border-radius: 999px;
                margin-bottom: 8px;
            }

            .alamat-nama {
                font-size: 13px;
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 2px;
            }

            .alamat-hp {
                font-size: 12px;
                color: #888;
                margin-bottom: 6px;
            }

            .alamat-teks {
                font-size: 12px;
                color: #555;
                line-height: 1.7;
            }

            .alamat-actions {
                display: flex;
                gap: 8px;
                margin-top: 14px;
                flex-wrap: wrap;
            }

            .alamat-tag {
                font-size: 10px;
                font-weight: 600;
                padding: 3px 10px;
                border-radius: 999px;
                background: #f5f0e8;
                color: #888;
                margin-bottom: 6px;
                display: inline-block;
            }

            /* Tambah Alamat Modal */
            .modal-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .4);
                backdrop-filter: blur(4px);
                z-index: 60;
                align-items: center;
                justify-content: center;
            }

            .modal-overlay.show {
                display: flex;
            }

            .modal-box {
                background: #fff;
                border-radius: 20px;
                padding: 28px;
                width: 100%;
                max-width: 500px;
                margin: 16px;
                max-height: 90vh;
                overflow-y: auto;
            }

            .modal-title {
                font-size: 16px;
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 4px;
            }

            .modal-sub {
                font-size: 12px;
                color: #aaa;
                margin-bottom: 22px;
            }

            /* Empty state */
            .empty-state {
                text-align: center;
                padding: 48px 20px;
                color: #bbb;
            }

            .empty-state i {
                font-size: 40px;
                margin-bottom: 12px;
                display: block;
            }

            .empty-state p {
                font-size: 13px;
            }

            @media (max-width: 640px) {
                .tab-nav {
                    width: 100%;
                }

                .tab-btn {
                    flex: 1;
                    justify-content: center;
                    padding: 9px 10px;
                }

                .tab-btn span {
                    display: none;
                }

                .form-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

    {{-- Page Header --}}
    <div class="mb-2">
        <h1 class="text-[20px] font-extrabold text-[#1a1a1a]">Akun Saya</h1>
        <p class="text-[13px] text-[#aaa]">Kelola profil, pesanan, dan alamat pengirimanmu</p>
    </div>

    {{-- Tab Nav --}}
    <div class="tab-nav">
        <button class="tab-btn active" onclick="switchTab('profil', this)">
            <i class="fa-solid fa-user"></i><span>Edit Profil</span>
        </button>
        <button class="tab-btn" onclick="switchTab('pesanan', this)">
            <i class="fa-solid fa-box"></i><span>Riwayat Pesanan</span>
        </button>
        <button class="tab-btn" onclick="switchTab('alamat', this)">
            <i class="fa-solid fa-location-dot"></i><span>Alamat</span>
        </button>
    </div>

    {{-- ═══════════════════════════════════════════
    TAB 1 — Edit Profil
    ═══════════════════════════════════════════ --}}
    <div id="tab-profil" class="tab-panel active">
        <div class="akun-card">
            <div class="akun-card-title">Informasi Profil</div>
            <div class="akun-card-sub">Perbarui foto dan data dirimu</div>

            {{-- Foto Profil --}}
            <div class="foto-wrap">
                @if(!empty(auth()->user()->foto_profil))
                    <img src="{{ Storage::url(auth()->user()->foto_profil) }}" class="foto-avatar ring-4 ring-[#FF5500]/20"
                        alt="Foto Profil">
                @else
                    <div class="foto-placeholder">
                        <i class="fa-solid fa-user"></i>
                    </div>
                @endif
                <div>
                    <label for="fotoInput" class="foto-upload-btn">
                        <i class="fa-solid fa-camera text-[11px]"></i> Ganti Foto
                    </label>
                    <p class="foto-note">JPG, PNG, maks. 2MB</p>
                </div>
            </div>

            <form action="{{ route('buyer.akun.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="file" id="fotoInput" name="foto_profil" class="hidden" accept="image/*"
                    onchange="previewFoto(this)">

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input"
                            value="{{ old('name', auth()->user()->name) }}" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-input"
                            value="{{ old('username', auth()->user()->username ?? '') }}" placeholder="Username">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input"
                        value="{{ old('email', auth()->user()->email) }}" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-input"
                        value="{{ old('no_hp', auth()->user()->no_hp ?? '') }}" placeholder="+62 ...">
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-textarea"
                        placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                </div>

                {{-- Divider --}}
                <div class="border-t border-[#f0e9d8] my-6"></div>
                <div class="akun-card-title text-[14px] mb-1">Ganti Password</div>
                <div class="akun-card-sub">Kosongkan jika tidak ingin mengubah password</div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-input" placeholder="Min. 8 karakter">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-input"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <div class="flex gap-3 mt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk text-[12px]"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
    TAB 2 — Riwayat Pesanan
    ═══════════════════════════════════════════ --}}
    <div id="tab-pesanan" class="tab-panel">

        {{-- Filter status --}}
        <div class="flex gap-2 mb-5 overflow-x-auto pb-1" style="scrollbar-width:none">
            @foreach(['Semua', 'Menunggu', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'] as $status)
                <button onclick="filterPesanan(this, '{{ $status }}')"
                    class="pesanan-filter-btn flex-shrink-0 px-4 py-2 rounded-999 text-[12px] font-600 border border-[#ede4d4] text-[#888] bg-white transition-all {{ $status === 'Semua' ? 'bg-[#FF5500] text-white border-[#FF5500]' : '' }}"
                    style="border-radius:999px; font-weight:600">
                    {{ $status }}
                </button>
            @endforeach
        </div>

        @forelse($pesanan ?? [] as $order)
            @php
                $statusClass = match (strtolower($order->status)) {
                    'selesai' => 'status-selesai',
                    'diproses' => 'status-diproses',
                    'dikirim' => 'status-dikirim',
                    'dibatalkan' => 'status-dibatalkan',
                    default => 'status-menunggu',
                };
            @endphp
            <div class="pesanan-card" data-status="{{ $order->status }}">
                <div class="pesanan-header">
                    <div>
                        <div class="pesanan-id">#{{ $order->kode_pesanan ?? $order->id }}</div>
                        <div class="pesanan-tgl">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                    <span class="pesanan-status {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="pesanan-items">
                    @foreach($order->items ?? [] as $item)
                        @if($item->produk?->foto)
                            <img src="{{ Storage::url($item->produk->foto) }}" class="pesanan-item-img"
                                alt="{{ $item->produk->nama_produk }}">
                        @else
                            <div class="pesanan-item-placeholder"><i class="fa-regular fa-image"></i></div>
                        @endif
                    @endforeach
                </div>
                <div class="pesanan-footer">
                    <div>
                        <div class="pesanan-total-label">Total Pembayaran</div>
                        <div class="pesanan-total">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <a href="{{ route('buyer.pesanan.detail', $order->id) }}" class="pesanan-detail-btn">
                        Lihat Detail <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="akun-card">
                <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <p class="font-semibold text-[#888] mb-1">Belum ada pesanan</p>
                    <p class="text-[12px]">Yuk mulai belanja di ThriftStop!</p>
                    <a href="{{ route('buyer.shop') }}" class="btn-primary mt-4 inline-flex">
                        <i class="fa-solid fa-store text-[12px]"></i> Mulai Belanja
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- ═══════════════════════════════════════════
    TAB 3 — Alamat Pengiriman
    ═══════════════════════════════════════════ --}}
    <div id="tab-alamat" class="tab-panel">
        <div class="flex items-center justify-between mb-5">
            <div>
                <div class="text-[15px] font-bold text-[#1a1a1a]">Alamat Tersimpan</div>
                <div class="text-[12px] text-[#aaa]">Maks. 5 alamat</div>
            </div>
            <button onclick="openModalAlamat()" class="btn-primary">
                <i class="fa-solid fa-plus text-[12px]"></i> Tambah Alamat
            </button>
        </div>

        @forelse($alamat ?? [] as $a)
            <div class="alamat-card {{ $a->is_utama ? 'utama' : '' }}">
                @if($a->is_utama)
                    <span class="alamat-utama-badge"><i class="fa-solid fa-star text-[9px]"></i> Alamat Utama</span>
                @endif
                @if($a->label)
                    <span class="alamat-tag">{{ $a->label }}</span>
                @endif
                <div class="alamat-nama">{{ $a->nama_penerima }}</div>
                <div class="alamat-hp">{{ $a->no_hp }}</div>
                <div class="alamat-teks">{{ $a->alamat_lengkap }}, {{ $a->kecamatan }}, {{ $a->kota }}, {{ $a->provinsi }}
                    {{ $a->kode_pos }}</div>
                <div class="alamat-actions">
                    <button onclick="editAlamat({{ $a->id }})" class="btn-secondary"
                        style="font-size:12px;padding:7px 14px">
                        <i class="fa-solid fa-pen text-[11px]"></i> Ubah
                    </button>
                    @if(!$a->is_utama)
                        <form action="{{ route('buyer.alamat.utama', $a->id) }}" method="POST" style="display:inline">
                            @csrf @method('PUT')
                            <button type="submit" class="btn-secondary" style="font-size:12px;padding:7px 14px">
                                <i class="fa-regular fa-star text-[11px]"></i> Jadikan Utama
                            </button>
                        </form>
                        <form action="{{ route('buyer.alamat.hapus', $a->id) }}" method="POST" style="display:inline"
                            onsubmit="return confirm('Hapus alamat ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">
                                <i class="fa-solid fa-trash text-[11px]"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="akun-card">
                <div class="empty-state">
                    <i class="fa-solid fa-location-dot"></i>
                    <p class="font-semibold text-[#888] mb-1">Belum ada alamat</p>
                    <p class="text-[12px]">Tambahkan alamat pengirimanmu</p>
                    <button onclick="openModalAlamat()" class="btn-primary mt-4">
                        <i class="fa-solid fa-plus text-[12px]"></i> Tambah Alamat
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    {{-- ═══════════════════════════════════════════
    Modal Tambah / Edit Alamat
    ═══════════════════════════════════════════ --}}
    <div id="modalAlamat" class="modal-overlay">
        <div class="modal-box">
            <div class="flex items-center justify-between mb-1">
                <div class="modal-title" id="modalAlamatTitle">Tambah Alamat Baru</div>
                <button onclick="closeModalAlamat()" class="text-[#aaa] hover:text-red-400 text-[18px]">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-sub">Isi data penerima dan alamat lengkap</div>

            <form id="formAlamat" action="{{ route('buyer.alamat.store') }}" method="POST">
                @csrf
                <span id="methodAlamat"></span>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="nama_penerima" id="inp_nama" class="form-input"
                            placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" id="inp_hp" class="form-input" placeholder="+62 ...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Label Alamat</label>
                    <div class="flex gap-2">
                        @foreach(['Rumah', 'Kantor', 'Kos'] as $lbl)
                            <button type="button" onclick="setLabel(this, '{{ $lbl }}')"
                                class="label-chip px-3 py-1.5 rounded-lg text-[11px] font-600 border border-[#ede4d4] text-[#888] bg-white transition-all"
                                style="font-weight:600">{{ $lbl }}</button>
                        @endforeach
                    </div>
                    <input type="hidden" name="label" id="inp_label">
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" id="inp_alamat" class="form-textarea"
                        placeholder="Nama jalan, nomor rumah, RT/RW..." required></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" id="inp_kecamatan" class="form-input"
                            placeholder="Kecamatan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kota / Kabupaten</label>
                        <input type="text" name="kota" id="inp_kota" class="form-input" placeholder="Kota">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" id="inp_provinsi" class="form-input" placeholder="Provinsi">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" id="inp_kodepos" class="form-input" placeholder="12345">
                    </div>
                </div>

                <div class="flex items-center gap-2 mb-4">
                    <input type="checkbox" name="is_utama" id="inp_utama" value="1"
                        class="w-4 h-4 accent-[#FF5500] cursor-pointer">
                    <label for="inp_utama" class="text-[12px] font-600 text-[#555] cursor-pointer"
                        style="font-weight:600">
                        Jadikan alamat utama
                    </label>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk text-[12px]"></i> Simpan Alamat
                    </button>
                    <button type="button" onclick="closeModalAlamat()" class="btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // ── Tab switcher ──
            function switchTab(name, btn) {
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.getElementById('tab-' + name).classList.add('active');
                btn.classList.add('active');
            }

            // ── Foto preview ──
            function previewFoto(input) {
                if (!input.files || !input.files[0]) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const el = document.querySelector('.foto-avatar, .foto-placeholder');
                    if (el.tagName === 'IMG') {
                        el.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'foto-avatar ring-4 ring-[#FF5500]/20';
                        el.replaceWith(img);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }

            // ── Filter pesanan ──
            function filterPesanan(btn, status) {
                document.querySelectorAll('.pesanan-filter-btn').forEach(b => {
                    b.style.background = '#fff';
                    b.style.color = '#888';
                    b.style.borderColor = '#ede4d4';
                });
                btn.style.background = '#FF5500';
                btn.style.color = '#fff';
                btn.style.borderColor = '#FF5500';

                document.querySelectorAll('.pesanan-card').forEach(card => {
                    if (status === 'Semua' || card.dataset.status?.toLowerCase() === status.toLowerCase()) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // ── Modal Alamat ──
            function openModalAlamat() {
                document.getElementById('modalAlamatTitle').textContent = 'Tambah Alamat Baru';
                document.getElementById('formAlamat').action = '{{ route("buyer.alamat.store") }}';
                document.getElementById('methodAlamat').innerHTML = '';
                // reset fields
                ['inp_nama', 'inp_hp', 'inp_alamat', 'inp_kecamatan', 'inp_kota', 'inp_provinsi', 'inp_kodepos'].forEach(id => {
                    document.getElementById(id).value = '';
                });
                document.getElementById('inp_label').value = '';
                document.getElementById('inp_utama').checked = false;
                document.querySelectorAll('.label-chip').forEach(c => {
                    c.style.background = '#fff'; c.style.color = '#888'; c.style.borderColor = '#ede4d4';
                });
                document.getElementById('modalAlamat').classList.add('show');
            }

            function closeModalAlamat() {
                document.getElementById('modalAlamat').classList.remove('show');
            }

            function setLabel(btn, val) {
                document.querySelectorAll('.label-chip').forEach(c => {
                    c.style.background = '#fff'; c.style.color = '#888'; c.style.borderColor = '#ede4d4';
                });
                btn.style.background = '#FF5500'; btn.style.color = '#fff'; btn.style.borderColor = '#FF5500';
                document.getElementById('inp_label').value = val;
            }

            // Klik luar modal → tutup
            document.getElementById('modalAlamat').addEventListener('click', function (e) {
                if (e.target === this) closeModalAlamat();
            });

            // Auto-buka tab dari URL hash
            const hash = window.location.hash;
            if (hash === '#pesanan') switchTab('pesanan', document.querySelectorAll('.tab-btn')[1]);
            if (hash === '#alamat') switchTab('alamat', document.querySelectorAll('.tab-btn')[2]);

            // Flash message alert
            @if(session('success'))
                const flashEl = document.createElement('div');
                flashEl.innerHTML = `<div style="position:fixed;top:20px;right:20px;z-index:9999;background:#22c55e;color:#fff;padding:12px 20px;border-radius:12px;font-size:13px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.15);display:flex;align-items:center;gap:8px"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>`;
                document.body.appendChild(flashEl);
                setTimeout(() => flashEl.remove(), 3500);
            @endif
        </script>
    @endpush

</x-layout-buyer>