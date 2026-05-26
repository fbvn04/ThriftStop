<x-layout-buyer :user="auth()->user()" titlePage="Beranda">

    @push('styles')
        <style>
            /* Hero Slider */
            .hero-wrap {
                border-radius: 20px;
                overflow: hidden;
                position: relative;
                background: #1a1a1a;
                height: 280px;
                margin-bottom: 24px;
            }

            .hero-slide {
                position: absolute;
                inset: 0;
                opacity: 0;
                transition: opacity .6s ease;
                display: flex;
                align-items: center;
            }

            .hero-slide.active {
                opacity: 1;
            }

            .hero-slide img {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: .55;
            }

            .hero-content {
                position: relative;
                z-index: 2;
                padding: 36px 40px;
                color: #fff;
            }

            .hero-tag {
                display: inline-block;
                background: #FF5500;
                color: #fff;
                font-size: 10px;
                font-weight: 700;
                padding: 4px 10px;
                border-radius: 999px;
                margin-bottom: 10px;
                letter-spacing: .5px;
                text-transform: uppercase;
            }

            .hero-title {
                font-size: 32px;
                font-weight: 800;
                line-height: 1.15;
                margin-bottom: 14px;
            }

            .hero-title span {
                color: #FF5500;
            }

            .hero-btn {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: #FF5500;
                color: #fff;
                padding: 10px 22px;
                border-radius: 12px;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                transition: background .2s;
            }

            .hero-btn:hover {
                background: #e04d00;
            }

            .hero-dots {
                position: absolute;
                bottom: 14px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 6px;
                z-index: 3;
            }

            .hero-dot {
                width: 7px;
                height: 7px;
                border-radius: 999px;
                background: rgba(255, 255, 255, .4);
                cursor: pointer;
                transition: all .3s;
            }

            .hero-dot.active {
                background: #fff;
                width: 20px;
            }

            /* Kategori */
            .kategori-strip {
                display: flex;
                gap: 12px;
                overflow-x: auto;
                padding-bottom: 4px;
                scrollbar-width: none;
                margin-bottom: 24px;
            }

            .kategori-strip::-webkit-scrollbar {
                display: none;
            }

            .kat-btn {
                flex-shrink: 0;
                padding: 10px 20px;
                border-radius: 14px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                transition: all .2s;
                border: 2px solid transparent;
                text-decoration: none;
            }

            .kat-btn.pria {
                background: #dbeafe;
                color: #1d4ed8;
            }

            .kat-btn.wanita {
                background: #fce7f3;
                color: #be185d;
            }

            .kat-btn.anak {
                background: #dcfce7;
                color: #15803d;
            }

            .kat-btn.aksesoris {
                background: #fef9c3;
                color: #a16207;
            }

            .kat-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 18px rgba(0, 0, 0, .1);
            }

            /* Section */
            .section-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 16px;
            }

            .section-head-title {
                font-size: 15px;
                font-weight: 700;
                color: #1a1a1a;
            }

            .view-all {
                font-size: 12px;
                font-weight: 600;
                color: #FF5500;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .view-all:hover {
                text-decoration: underline;
            }

            /* Product Grid */
            .product-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 16px;
                margin-bottom: 28px;
            }

            .product-card {
                background: #fff;
                border-radius: 18px;
                overflow: hidden;
                transition: all .25s ease;
                box-shadow: 0 4px 14px rgba(0, 0, 0, .05);
            }

            .product-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 32px rgba(0, 0, 0, .1);
            }

            .product-img-wrap {
                position: relative;
                aspect-ratio: 3/4;
                background: #f5f0e8;
                overflow: hidden;
            }

            .product-img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .product-img-placeholder {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #d4c5a9;
                font-size: 32px;
            }

            .product-kondisi {
                position: absolute;
                top: 10px;
                left: 10px;
                background: rgba(255, 255, 255, .92);
                backdrop-filter: blur(4px);
                font-size: 10px;
                font-weight: 700;
                padding: 3px 8px;
                border-radius: 999px;
                color: #555;
            }

            .product-info {
                padding: 12px 14px 14px;
            }

            .product-name {
                font-size: 12px;
                font-weight: 600;
                color: #1a1a1a;
                margin-bottom: 4px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .product-toko {
                font-size: 10px;
                color: #aaa;
                margin-bottom: 8px;
            }

            .product-price {
                font-size: 14px;
                font-weight: 800;
                color: #FF5500;
            }

            .product-size {
                display: inline-block;
                font-size: 10px;
                font-weight: 600;
                background: #f5f0e8;
                color: #888;
                padding: 2px 8px;
                border-radius: 999px;
                margin-top: 6px;
            }

            @media (max-width: 640px) {
                .hero-title {
                    font-size: 22px;
                }

                .hero-content {
                    padding: 24px;
                }

                .hero-wrap {
                    height: 220px;
                }

                .product-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 12px;
                }
            }
        </style>
    @endpush

    {{-- Hero Slider --}}
    <div class="hero-wrap" id="heroSlider">
        <div class="hero-slide active">
            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80" alt="Slide 1">
            <div class="hero-content">
                <span class="hero-tag">Koleksi Terbaru</span>
                <div class="hero-title">Temukan Gaya<br>Unik <span>Kamu</span></div>
                <a href="{{ route('buyer.shop') }}" class="hero-btn">
                    Belanja Sekarang <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>
        <div class="hero-slide">
            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=1200&q=80" alt="Slide 2">
            <div class="hero-content">
                <span class="hero-tag">Promo Spesial</span>
                <div class="hero-title">Fashion <span>Thrift</span><br>Berkualitas</div>
                <a href="{{ route('buyer.shop') }}" class="hero-btn">
                    Lihat Promo <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>
        <div class="hero-slide">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1200&q=80" alt="Slide 3">
            <div class="hero-content">
                <span class="hero-tag">Pilihan Editor</span>
                <div class="hero-title">Hemat Lebih<br><span>Tampil Keren</span></div>
                <a href="{{ route('buyer.shop') }}" class="hero-btn">
                    Eksplorasi <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>
        <div class="hero-dots" id="heroDots">
            <div class="hero-dot active" onclick="goSlide(0)"></div>
            <div class="hero-dot" onclick="goSlide(1)"></div>
            <div class="hero-dot" onclick="goSlide(2)"></div>
        </div>
    </div>

    {{-- Kategori --}}
    <div class="kategori-strip">
        <a href="{{ route('buyer.shop', ['kategori' => 'pria']) }}" class="kat-btn pria">
            <i class="fa-solid fa-person mr-2"></i>Pria
        </a>
        <a href="{{ route('buyer.shop', ['kategori' => 'wanita']) }}" class="kat-btn wanita">
            <i class="fa-solid fa-person-dress mr-2"></i>Wanita
        </a>
        <a href="{{ route('buyer.shop', ['kategori' => 'anak']) }}" class="kat-btn anak">
            <i class="fa-solid fa-child mr-2"></i>Anak
        </a>
        <a href="{{ route('buyer.shop', ['kategori' => 'aksesori']) }}" class="kat-btn aksesoris">
            <i class="fa-solid fa-hat-cowboy mr-2"></i>Aksesori
        </a>
    </div>

    {{-- Produk Terbaru --}}
    <div class="section-head">
        <span class="section-head-title"><i class="fa-solid fa-bolt text-[#FF5500] mr-2"></i>Produk Terbaru</span>
        <a href="{{ route('buyer.shop') }}" class="view-all">Lihat Semua <i
                class="fa-solid fa-chevron-right text-[10px]"></i></a>
    </div>
    <div class="product-grid">
        @forelse($produkTerbaru ?? [] as $produk)
            <a href="{{ route('buyer.produk', $produk->id) }}" class="product-card" style="text-decoration:none">
                <div class="product-img-wrap">
                    @if($produk->foto)
                        <img src="{{ Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="product-img-placeholder"><i class="fa-regular fa-image"></i></div>
                    @endif
                    <span class="product-kondisi">{{ $produk->kondisi }}</span>
                </div>
                <div class="product-info">
                    <div class="product-name">{{ $produk->nama_produk }}</div>
                    <div class="product-toko"><i
                            class="fa-solid fa-store text-[9px] mr-1"></i>{{ $produk->toko->nama_toko ?? '—' }}</div>
                    <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                    @if($produk->ukuran)
                        <span class="product-size">{{ $produk->ukuran }}</span>
                    @endif
                </div>
            </a>
        @empty
            {{-- Placeholder semu --}}
            @foreach(range(1, 4) as $i)
                <div class="product-card">
                    <div class="product-img-wrap">
                        <div class="product-img-placeholder"><i class="fa-regular fa-image"></i></div>
                        <span class="product-kondisi">Baru</span>
                    </div>
                    <div class="product-info">
                        <div class="product-name">Nama Produk</div>
                        <div class="product-toko"><i class="fa-solid fa-store text-[9px] mr-1"></i>Nama Toko</div>
                        <div class="product-price">Rp 150.000</div>
                        <span class="product-size">M</span>
                    </div>
                </div>
            @endforeach
        @endforelse
    </div>

    {{-- Rekomendasi --}}
    <div class="section-head">
        <span class="section-head-title"><i class="fa-solid fa-star text-[#FF5500] mr-2"></i>Rekomendasi Untukmu</span>
        <a href="{{ route('buyer.shop') }}" class="view-all">Lihat Semua <i
                class="fa-solid fa-chevron-right text-[10px]"></i></a>
    </div>
    <div class="product-grid">
        @forelse($rekomendasi ?? [] as $produk)
            <a href="{{ route('buyer.produk', $produk->id) }}" class="product-card" style="text-decoration:none">
                <div class="product-img-wrap">
                    @if($produk->foto)
                        <img src="{{ Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="product-img-placeholder"><i class="fa-regular fa-image"></i></div>
                    @endif
                    <span class="product-kondisi">{{ $produk->kondisi }}</span>
                </div>
                <div class="product-info">
                    <div class="product-name">{{ $produk->nama_produk }}</div>
                    <div class="product-toko"><i
                            class="fa-solid fa-store text-[9px] mr-1"></i>{{ $produk->toko->nama_toko ?? '—' }}</div>
                    <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                    @if($produk->ukuran)
                        <span class="product-size">{{ $produk->ukuran }}</span>
                    @endif
                </div>
            </a>
        @empty
            @foreach(range(1, 4) as $i)
                <div class="product-card">
                    <div class="product-img-wrap">
                        <div class="product-img-placeholder"><i class="fa-regular fa-image"></i></div>
                        <span class="product-kondisi">Seperti Baru</span>
                    </div>
                    <div class="product-info">
                        <div class="product-name">Nama Produk</div>
                        <div class="product-toko"><i class="fa-solid fa-store text-[9px] mr-1"></i>Nama Toko</div>
                        <div class="product-price">Rp 200.000</div>
                        <span class="product-size">L</span>
                    </div>
                </div>
            @endforeach
        @endforelse
    </div>

    @push('scripts')
        <script>
            // Hero Slider
            let currentSlide = 0;
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');

            function goSlide(n) {
                slides[currentSlide].classList.remove('active');
                dots[currentSlide].classList.remove('active');
                currentSlide = n;
                slides[currentSlide].classList.add('active');
                dots[currentSlide].classList.add('active');
            }

            setInterval(() => goSlide((currentSlide + 1) % slides.length), 4000);
        </script>
    @endpush

</x-layout-buyer>