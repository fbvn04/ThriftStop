<x-layout-buyer :user="$user" titlePage="Akun Saya">

<div class="space-y-6">

    {{-- PROFILE --}}
    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <div class="flex justify-between items-start">

            <div class="flex items-center gap-6">

                <div class="w-28 h-28 rounded-full bg-gray-200 overflow-hidden">

                    @if($user->photo)
                        <img
                            src="{{ Storage::url($user->photo) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            No Photo
                        </div>
                    @endif

                </div>

                <div>

                    <h1 class="text-4xl font-bold">
                        {{ $user->name }}
                    </h1>

                    <p class="text-gray-500 text-xl">
                        Buyer
                    </p>

                </div>

            </div>

            {{-- BUTTON EDIT PROFILE --}}
            <a
                href="{{ route('buyer.profile.edit') }}"
                class="bg-[#FF5500] hover:bg-orange-600 text-white px-6 py-3 rounded-full font-semibold transition">

                Edit Profile

            </a>

        </div>

    </div>

    {{-- ADDRESS --}}
    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <h2 class="text-2xl font-bold mb-4">
            Address
        </h2>

        <p class="text-gray-600">
            {{ $user->address ?? '-' }}
        </p>

    </div>

    <div class="grid lg:grid-cols-2 gap-6">

        {{-- CONTACT --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm">

            <h2 class="text-2xl font-bold mb-4">
                Contact
            </h2>

            <div class="space-y-4">

                <div>
                    <p class="text-gray-400">
                        Email
                    </p>

                    <p class="font-semibold">
                        {{ $user->email }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">
                        Phone
                    </p>

                    <p class="font-semibold">
                        {{ $user->phone ?? '-' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- ACCOUNT DETAILS --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm">

            <h2 class="text-2xl font-bold mb-4">
                Account Details
            </h2>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <p class="text-gray-400">
                        Name
                    </p>

                    <p class="font-semibold">
                        {{ $user->name }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">
                        Birth Date
                    </p>

                    <p class="font-semibold">
                        {{ $user->birth_date ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">
                        Gender
                    </p>

                    <p class="font-semibold">
                        {{ $user->gender ?? '-' }}
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

</x-layout-buyer>