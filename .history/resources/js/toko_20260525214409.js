const popup = {
    body : document.getElementById('popupMessage'),
    text : document.getElementById('popupText'),
    closeBtn : document.getElementById('closePopup'),
};
const fileInput = {
    uploadBtn : document.getElementById('uploadProfile'),
    fotoInput : document.getElementById('fotoInput'),
    imagePreview : document.getElementById('imagePreview'),
    defaultProfile : document.getElementById('defaultProfile'),
};

fileInput.uploadBtn.addEventListener('click', () => {
    fileInput.fotoInput.click();
});
popup.closeBtn.addEventListener('click', () => {
    popup.body.classList.remove('red-side-popup');
    popup.body.classList.remove('green-side-popup');
    popup.body.classList.add('closed-side-popup');
});


function showPopup(message, condition = true) {
popup.text.innerText = message;
popup.body.classList.remove('closed-side-popup');
if (condition) {
    popup.body.classList.add('green-side-popup');
} else {
    popup.body.classList.add('red-side-popup');
}
setTimeout(() => {
    popup.body.classList.remove('red-side-popup');
    popup.body.classList.remove('green-side-popup');
    popup.body.classList.add('closed-side-popup');
}, 3000);
}
fotoInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) {
        showPopup('File harus berupa gambar!', false);
        fileInput.fotoInput.value = '';
        fileInput.imagePreview.classList.add('hidden');
        return;
    }
    if (file.size > 2 * 1024 * 1024) {
        showPopup('Ukuran gambar maksimal 2MB!', false);
        fileInput.fotoInput.value = '';
        fileinput.imagePreview.classList.add('hidden');
        return;
    }
    fileInput.imagePreview.src = URL.createObjectURL(file);
    fileInput.imagePreview.classList.remove('hidden');
    showPopup('Gambar berhasil dipilih!', true);
    }
);

const provinsi = {
    dropdown: document.getElementById('provinsiDropdown'),
    menu: document.getElementById('provinsiMenu'),
    text: document.getElementById('provinsiText'),
    input: document.getElementById('provinsiInput')
};
const kota = {
    dropdown: document.getElementById('kotaDropdown'),
    menu: document.getElementById('kotaMenu'),
    text: document.getElementById('kotaText'),
    input: document.getElementById('kotaInput')
};
const kecamatan = {
    dropdown: document.getElementById('kecamatanDropdown'),
    menu: document.getElementById('kecamatanMenu'),
    text: document.getElementById('kecamatanText'),
    input: document.getElementById('kecamatanInput')
};
async function loadProvinsi() {
    try {
        const res = await fetch('/api/region-indo/provinsi');
        if (!res.ok) throw new Error('Gagal load provinsi');
        const dataProvinsi = await res.json();
        provinsi.menu.innerHTML = dataProvinsi.map(item => `
            <div class="provinsi-pick px-3 py-2 hover:bg-gray-100 cursor-pointer"
                data-id="${item.id}"
                data-name="${item.nama}">
                ${item.nama}
            </div>
        `).join('');
    } catch (err) {
        console.error(err);
        provinsi.menu.innerHTML = `<div class="p-2 text-red-500">Gagal load data</div>`;
    }
}
async function loadKota(provId) {
    try {
        const res = await fetch(`/api/region-indo/kota/${provId}`);
        if (!res.ok) throw new Error('Gagal load kota');
        const dataKota = await res.json();
        kota.menu.innerHTML = dataKota.map(item => `
            <div class="kota-pick px-3 py-2 hover:bg-gray-100 cursor-pointer"
                data-id="${item.id}"
                data-name="${item.nama}">
                ${item.nama}
            </div>
        `).join('');
    } catch (err) {
        console.error(err);
        kota.menu.innerHTML = `<div class="p-2 text-red-500">Gagal load data</div>`;
    }
}
async function loadKecamatan(kotaId) {
    try {
        const res = await fetch(`/api/region-indo/kecamatan/${kotaId}`);
        if (!res.ok) throw new Error('Gagal load kecamatan');
        const dataKecamatan = await res.json();
        kecamatan.menu.innerHTML = dataKecamatan.map(item => `
            <div class="kecamatan-pick px-3 py-2 hover:bg-gray-100 cursor-pointer"
                data-id="${item.id}"
                data-name="${item.nama}">
                ${item.nama}
            </div>
        `).join('');
    } catch (err) {
        console.error(err);
        kecamatan.menu.innerHTML = `<div class="p-2 text-red-500">Gagal load data</div>`;
    }
}
provinsi.dropdown.addEventListener('click', () => {
    provinsi.menu.classList.toggle('dropdown-tailwind-closed');
    provinsi.menu.classList.toggle('dropdown-tailwind-opened');
});
kota.dropdown.addEventListener('click', () => {
    kota.menu.classList.toggle('dropdown-tailwind-closed');
    kota.menu.classList.toggle('dropdown-tailwind-opened');
});
kecamatan.dropdown.addEventListener('click', () => {
    kecamatan.menu.classList.toggle('dropdown-tailwind-closed');
    kecamatan.menu.classList.toggle('dropdown-tailwind-opened');
});
provinsi.menu.addEventListener('click', (e) => {
    const itemProvinsi = e.target.closest('.provinsi-pick');
    if (!itemProvinsi) return;
    
    provinsi.input.value = itemProvinsi.dataset.id;
    provinsi.text.innerText = itemProvinsi.dataset.name;
    kecamatan.input.value = '';
    kecamatan.text.innerText = 'Pilih Kecamatan';
    kota.input.value = '';
    kota.text.innerText = 'Pilih Kota';
    
    provinsi.menu.classList.toggle('dropdown-tailwind-opened');
    provinsi.menu.classList.toggle('dropdown-tailwind-closed');
    
    loadKota(itemProvinsi.dataset.id);
});
kota.menu.addEventListener('click', (e) => {
    const itemKota = e.target.closest('.kota-pick');
    if (!itemKota) return;
    
    kota.input.value = itemKota.dataset.id;
    kota.text.innerText = itemKota.dataset.name;
    kecamatan.input.value = '';
    kecamatan.text.innerText = 'Pilih Kecamatan';
    
    kota.menu.classList.toggle('dropdown-tailwind-opened');
    kota.menu.classList.toggle('dropdown-tailwind-closed');
    
    loadKecamatan(itemKota.dataset.id);
});
kecamatan.menu.addEventListener('click', (e) => {
    const itemKecamatan = e.target.closest('.kecamatan-pick');
    if (!itemKecamatan) return;
    
    kecamatan.input.value = itemKecamatan.dataset.id;
    kecamatan.text.innerText = itemKecamatan.dataset.name;
    
    kecamatan.menu.classList.toggle('dropdown-tailwind-opened');
    kecamatan.menu.classList.toggle('dropdown-tailwind-closed');
});
loadProvinsi();

const submitBtn = document.getElementById('submitBtn');
const inputForm = {
    username: {
        input : document.getElementById('usernameInput'),
        borderField : document.getElementById('usernameInput'),
        error : document.getElementById('usernameError'),
        validate: (v) => {
            v = v.replace(/[^a-zA-Z0-9]/g, '');
            document.getElementById('usernameInput').value = v;
            if (!v) return 'Username tidak boleh kosong!';
            if (v.length < 3) return 'Minimal 3 Karakter';
            if (/\s/.test(v)) return 'Username tidak boleh ada spasi';
            return '';
        }
    },
    nama: {
        input : document.getElementById('namaInput'),
        borderField : document.getElementById('namaInput'),
        error : document.getElementById('namaError'),
        validate: (v) => {
            v = v.replace(/[^a-zA-Z0-9\s]/g, '');
            document.getElementById('namaInput').value = v;
            if (!v) return 'Username tidak boleh kosong!';
            if (v.length < 3) return 'Minimal 3 Karakter';
            return '';
        }
    },
    namaToko: {
        input : document.getElementById('namaTokoInput'),
        borderField : document.getElementById('namaTokoInput'),
        error : document.getElementById('namaTokoError'),
        validate: (v) => {
            if (!v) return 'Username tidak boleh kosong!';
            if (v.length < 3) return 'Minimal 3 Karakter';
            if (/\s/.test(v)) return 'Username tidak boleh ada spasi';
            return '';
        }
    },
    phoneNumber: {
        input : document.getElementById('phoneInput'),
        borderField : document.getElementById('phoneField'),
        error : document.getElementById('phoneError'),
        validate: (v) => {
            v = v.replace(/[^\d]/g, '');
            v = v.replace(/^0+/, '');
            document.getElementById('phoneInput').value = v;

            if (!v) return 'Nomor telephone tidak boleh kosong!';
            if (v.length < 10 || v.length > 13) return 'Nomor telephone tidak sesuai';
            if (/\s/.test(v)) return 'Username tidak boleh ada spasi';
            if (!/^\d+$/.test(v)) return 'Nomor telephone hanya boleh angka';
            return '';
        }
    },
    emailAddress: {
        input : document.getElementById('emailInput'),
        borderField : document.getElementById('emailInput'),
        error : document.getElementById('emailError'),
        validate: (v) => {
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return 'Format email tidak valid';
            if (!v) return 'Email tidak boleh kosong!';
            if (/\s/.test(v)) return 'Email tidak boleh ada spasi';
            return '';
        }
    },
}

function validateField(field) {
    const value = field.input.value.trim();
    const message = field.validate(value);

    field.borderField.classList.remove('border-red-400', 'border-green-400');

    if (message) {
        field.borderField.classList.add('border-red-400');
        field.error.textContent = message;
        return false;
    }

    field.borderField.classList.add('border-green-400');
    field.error.textContent = '';
    return true;
}

function validateForm() {
    let valid = true;
    Object.values(inputForm).forEach(field => {
    if (!validateField(field)) {
            valid = false;
        }
    });

    submitBtn.disabled = !valid;
    }
Object.values(inputForm).forEach(field => {
    field.input.addEventListener('input', validateForm);
    field.input.addEventListener('blur', validateForm);
});

validateForm();
