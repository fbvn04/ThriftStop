<x-layout-buyer :user="$user" titlePage="Edit Profile">

<div class="bg-white rounded-3xl p-8">

    <h1 class="text-3xl font-bold mb-8">
        Edit Profile
    </h1>

    <form
    action="{{ route('buyer.profile.update') }}"
    method="POST"
    enctype="multipart/form-data">

        @csrf

        <div class="space-y-5">

            <div>
                <label class="font-semibold">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name',$user->name) }}"
                    class="w-full border rounded-xl p-3">
            </div>

            <div>
                <label class="font-semibold">
                    Nomor HP
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone',$user->phone) }}"
                    class="w-full border rounded-xl p-3">
            </div>

            <div>
                <label class="font-semibold">
                    Alamat
                </label>

                <textarea
                    name="address"
                    class="w-full border rounded-xl p-3"
                    rows="4">{{ old('address',$user->address) }}</textarea>
            </div>

            <div>
                <label class="font-semibold">
                    Tanggal Lahir
                </label>

                <input
                    type="date"
                    name="birth_date"
                    value="{{ $user->birth_date }}"
                    class="w-full border rounded-xl p-3">
            </div>

            <div>
                <label class="font-semibold">
                    Gender
                </label>

                <select
                    name="gender"
                    class="w-full border rounded-xl p-3">

                    <option value="">
                        Pilih Gender
                    </option>

                    <option
                        value="Laki-laki"
                        {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki
                    </option>

                    <option
                        value="Perempuan"
                        {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan
                    </option>

                </select>
            </div>

            <div>
                <label class="font-semibold">
                    Foto Profile
                </label>

                <input
                    type="file"
                    name="photo"
                    class="w-full border rounded-xl p-3">
            </div>

            <button
                type="submit"
                class="bg-[#FF5500] text-white px-8 py-3 rounded-xl font-semibold">

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

</x-layout-buyer>