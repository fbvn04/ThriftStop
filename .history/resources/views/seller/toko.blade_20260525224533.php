<x-layout-seller titlePage="ThriftStop - Seller">
    <form action="{{ route('seller.toko.edit') }}" method="POST" enctype="multipart/form-data" class="px-10 py-1.5 scale-x-100 w-full h-fit bg-white rounded-lg
          md:px-14 md:py-10">
        @if($errors->any())
            <div class="bg-red-50 text-red-600 px-4 py-2.5 rounded-lg text-[11px] mb-4 flex items-start gap-2">
                <i class="fa-solid fa-circle-exclamation mt-0.5 shrink-0"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="my-5 px-10 w-full flex flex-col items-center gap-y-8
             md:flex-row md:justify-evenly md:gap-x-5">
            <div class="w-full flex flex-col items-center">
                @if ($dataToko->foto_toko)
                    <div class="relative w-4/6 rounded-full aspect-square border-4 border-[#ffe7db] overflow-hidden">
                        <img src="{{ asset('storage/' . $dataToko->foto_toko) }}"
                            class="w-full h-full aspect-square rounded-full">
                        <img src="" id="imagePreview"
                            class="hidden absolute object-cover w-full h-full aspect-square rounded-full z-40">
                        <i class="text-9xl md:text-7xl lg:text-9xl fa-solid fa-shop"></i>
                    </div>
                @else
                    <div class="relative w-4/6 rounded-full aspect-square border-4 border-[#ffe7db] overflow-hidden">
                        <div class="relative w-full h-full  text-[#ff8141] bg-[#ffeee6] flex items-center justify-center">
                            <img src="" id="imagePreview"
                                class="hidden absolute object-cover w-full h-full aspect-square rounded-full z-40">
                            <i class="text-9xl md:text-7xl lg:text-9xl fa-solid fa-shop"></i>
                        </div>
                    </div>
                @endif
                <input id="fotoInput" name="foto_toko" type="file" class="hidden" accept="image/*">
                <button type="button" id="uploadProfile"
                    class="cursor-pointer mt-5 py-1.5 px-5 rounded-sm bg-[#FF5500]">
                    <span class="text-white text-xs font-medium">Ganti Foto Profil</span>
                </button>
            </div>
            <div class="w-full shrink-0 md:w-1/2">
                <div class="flex flex-col gap-y-3.5">
                    @csrf
                    <div>
                        <label class="block pl-1 text-sm font-semibold text-gray-700 mb-2">
                            Username Pemilik Toko
                        </label>
                        <input id="usernameInput" name="username" type="text" value="{{ $dataToko->user->username }}"
                            placeholder="Masukkan username baru" class="w-full font-light rounded-sm border border-gray-300 px-3 py-2 text-sm outline-none transition
                            md:text-md md:rounded-lg md:font-normalmd:py-1">
                        <span id="usernameError" class="text-xs text-red-500 pl-2"></span>
                    </div>
                    <div>
                        <label class="block pl-1 text-sm font-semibold text-gray-700 mb-2">
                            Nama Pemilik Toko
                        </label>
                        <input id="namaInput" name="nama" type="text" value="{{ $dataToko->user->name }}"
                            placeholder="Masukkan username baru" class="w-full font-light rounded-sm border border-gray-300 px-3 py-2 text-sm outline-none transition
                            md:text-md md:rounded-lg md:font-normalmd:py-1">
                        <span id="namaError" class="text-xs text-red-500 pl-2"></span>
                    </div>
                    <div>
                        <label class="block pl-1 text-sm font-semibold text-gray-700 mb-2">
                            Nama Toko
                        </label>
                        <input id="namaTokoInput" name="nama_toko" type="text" value="{{ $dataToko->nama_toko }}"
                            placeholder="Masukkan nama baru toko anda" class="w-full font-light rounded-sm border border-gray-300 px-3 py-2 text-sm outline-none transition
                            md:text-md md:rounded-lg md:font-normalmd:py-1">
                        <span id="namaTokoError" class="text-xs text-red-500 pl-2"></span>
                    </div>
                    <div>
                        <label class="block pl-1 text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telephone
                        </label>
                        <div id="phoneField"
                            class="w-4/5 flex items-center rounded-lg border border-gray-300 py-1 text-sm transition">
                            <span class="text-sm text-gray-600 px-3 border-r-2 border-gray-400">+62</span>
                            <input id="phoneInput" name="hp" type="text" value="{{ $dataToko->user->hp }}"
                                placeholder="Masukan Nomor telephone Anda"
                                class="font-light py-2 px-3 w-full outline-none md:py-1 md:font-normal">
                        </div>
                        <span id='phoneError' class="text-xs text-red-500 pl-2"></span>
                    </div>
                    <div>
                        <label class="block pl-1 text-sm font-semibold text-gray-700 mb-2">
                            Email Bisnis Toko
                        </label>
                        <input id="emailInput" name="email" type="text" value="{{ $dataToko->user->email }}"
                            placeholder="Contoh : Rahandika@gmail.com" class="w-full font-light rounded-sm border border-gray-300 px-3 py-2 text-sm outline-none transition
                            md:text-md md:rounded-lg md:font-normalmd:py-1">
                        <span id="emailError" class="text-xs text-red-500 pl-2"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class=" flex flex-col gap-y-10">
            <div>
                <label class="block pl-1 text-sm font-semibold text-gray-700 mb-2">
                    Alamat Toko Anda
                </label>
                <div class="flex w-full gap-x-3 rounded-lg border border-gray-300 py-1 text-sm transition px-1
                     md:px-2.5">
                    <div class="relative flex-1">
                        <div id="provinsiDropdown" class="w-full px-1.5 py-2 rounded flex justify-between
                                                    items-center cursor-pointer md:px-3">
                            @if ($dataToko->provinsi)
                                <span id="provinsiText">{{ $dataToko->provinsi->nama }}</span>
                            @else
                                <span id="provinsiText">Pilih Provinsi</span>
                            @endif
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                        <div id="provinsiMenu" class="dropdown-tailwind-closed">
                        </div>
                        <input type="hidden" id="provinsiInput" name="provinsi_id">
                    </div>
                    <div class="relative flex-1">
                        <div id="kotaDropdown" class="w-full border-x-2 border-gray-300 px-1.5 py-2 rounded flex justify-between
                                               items-center cursor-pointer md:px-3">
                            @if ($dataToko->kota)
                                <span id="kotaText" class="">{{ $dataToko->kota->nama }}</span>
                            @else
                                <span id="kotaText" class="">Pilih Kota</span>
                            @endif
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                        <div id="kotaMenu" class="dropdown-tailwind-closed">
                        </div>
                        <input type="hidden" id="kotaInput" name="kota_id">
                    </div>
                    <div class="relative flex-1">
                        <div id="kecamatanDropdown" class="w-full px-1.5 py-2 rounded flex justify-between
                                                    items-center cursor-pointer md:px-3">
                            @if ($dataToko->kecamatan)
                                <span id="kecamatanText">{{ $dataToko->kecamatan->nama }}</span>
                            @else
                                <span id="kecamatanText">Pilih kecamatan</span>
                            @endif
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                        <div id="kecamatanMenu" class="dropdown-tailwind-closed">
                        </div>
                        <input type="hidden" id="kecamatanInput" name="kecamatan_id">
                    </div>
                </div>
            </div>
            <div>
                <label class="block pl-1 text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Toko Anda
                </label>
                <textarea id="deskripsiToko" name="deskripsi_toko" placeholder="Masukkan nama baru toko anda"
                    class="w-full h-40 resize-none overflow-auto rounded-lg border border-gray-300 px-3 py-1 text-sm outline-none transition"></textarea>
            </div>
            <div class="w-full flex justify-center items-center">
                <button id="submitBtn" type="submit" class="w-full mb-9 flex justify-center items-center gap-x-2.5 py-3 border-2 cursor-pointer transition duration-300 ease-in-out
                        border-[#FF5500] text-[#FF5500] font-medium rounded-sm md:rounded-lg md:w-3/5 md:mb-2.5
                        hover:bg-[#FF5500] hover:text-white hover:scale-95">
                    <span>
                        <i class="fa-solid fa-user-pen"></i>
                    </span>
                    <span>Perbarui Toko</span>
                </button>
            </div>
        </div>
    </form>

    <div id="popupMessage" class="closed-side-popup">
        <div class="flex items-center justify-between gap-4">
            <p id="popupText" class="text-sm text-white"></p>
            <button id="closePopup" class="text-white cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <script>

    </script>
</x-layout-seller>