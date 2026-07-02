<section>
    <header class="mb-8">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500 font-medium max-w-xl leading-relaxed">
            {{ __("Perbarui informasi profil, alamat email, dan data pengiriman akun Anda untuk memastikan pengalaman berbelanja yang lancar.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Foto Profil Section --}}
        <div class="flex flex-col sm:flex-row items-center gap-6 p-6 bg-slate-50 rounded-3xl border border-slate-100">
            <div class="relative group shrink-0">
                <!-- Image Preview / Initial Circle -->
                <div id="avatar-container" class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md bg-rose-100 flex items-center justify-center text-rose-700 text-3xl font-black relative">
                    @if($user->avatar)
                        <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <span id="avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <img id="avatar-preview" src="" class="w-full h-full object-cover hidden">
                    @endif
                </div>
            </div>
            
            <div class="flex-1 text-center sm:text-left">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-1">Foto Profil</h3>
                <p class="text-xs text-slate-400 font-medium mb-3">Format: JPG, JPEG, PNG, GIF. Maksimal 10MB.</p>
                
                <div class="flex flex-wrap justify-center sm:justify-start items-center gap-3">
                    <!-- File Input wrapped in a button style -->
                    <label class="cursor-pointer bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-md shadow-rose-100 inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Pilih Foto
                        <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                    </label>
                    
                    <!-- Delete Button -->
                    <button type="button" id="btn-delete-avatar" class="{{ $user->avatar ? '' : 'hidden' }} bg-white hover:bg-slate-100 text-rose-600 border border-rose-200 font-bold text-xs px-5 py-3 rounded-xl transition">
                        Hapus Foto
                    </button>
                    
                    <input type="hidden" name="delete_avatar" id="delete_avatar" value="0">
                </div>
                @error('avatar')
                    <p class="mt-2 text-rose-500 text-xs font-bold text-left">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarInitial = document.getElementById('avatar-initial');
            const btnDeleteAvatar = document.getElementById('btn-delete-avatar');
            const deleteAvatarInput = document.getElementById('delete_avatar');
            
            // Simpan data inisial
            const initialText = "{{ strtoupper(substr($user->name, 0, 1)) }}";

            avatarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                        avatarPreview.classList.remove('hidden');
                        if (avatarInitial) {
                            avatarInitial.classList.add('hidden');
                        }
                        btnDeleteAvatar.classList.remove('hidden');
                        deleteAvatarInput.value = '0';
                    }
                    reader.readAsDataURL(file);
                }
            });

            btnDeleteAvatar.addEventListener('click', function() {
                // Reset file input
                avatarInput.value = '';
                // Hide preview
                avatarPreview.src = '';
                avatarPreview.classList.add('hidden');
                // Show initial if container exists
                if (avatarInitial) {
                    avatarInitial.classList.remove('hidden');
                } else {
                    const container = document.getElementById('avatar-container');
                    let initialSpan = document.getElementById('avatar-initial');
                    if (!initialSpan) {
                        initialSpan = document.createElement('span');
                        initialSpan.id = 'avatar-initial';
                        initialSpan.textContent = initialText;
                        container.appendChild(initialSpan);
                    } else {
                        initialSpan.classList.remove('hidden');
                    }
                }
                // Hide delete button
                btnDeleteAvatar.classList.add('hidden');
                // Set hidden input to 1
                deleteAvatarInput.value = '1';
            });
        });
        </script>

        <div>
            <label for="name" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">{{ __('Nama Lengkap') }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                   class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300">
            @error('name')
                <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">{{ __('Alamat Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                   class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white placeholder-slate-300">
            @error('email')
                <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                    <p class="text-sm font-medium text-amber-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="font-bold text-amber-600 hover:text-amber-900 underline transition focus:outline-none">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 font-bold text-xs text-emerald-600 bg-emerald-100 w-fit px-3 py-1.5 rounded-lg">
                            ✓ {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <label for="phone" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">{{ __('Nomor WhatsApp / HP') }}</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890"
                   class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300">
            @error('phone')
                <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
            @enderror
        </div>

        {{-- Alamat Terstruktur: Cascading Dropdown --}}
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                <label class="block text-xs font-black text-slate-700 uppercase tracking-widest">{{ __('Alamat Lengkap Pengiriman') }}</label>
                <span class="text-[10px] text-slate-400 font-bold">*(Semua kolom bertanda * wajib diisi jika ingin menyimpan alamat)</span>
            </div>

            {{-- Hidden inputs untuk menyimpan kode wilayah --}}
            <input type="hidden" id="province_code" name="province_code" value="{{ old('province_code', $user->province_code) }}">
            <input type="hidden" id="city_code"     name="city_code"     value="{{ old('city_code', $user->city_code) }}">
            <input type="hidden" id="district_code" name="district_code" value="{{ old('district_code', $user->district_code) }}">
            <input type="hidden" id="village_code"  name="village_code"  value="{{ old('village_code', $user->village_code) }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Provinsi --}}
                <div>
                    <label for="province" class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase tracking-widest">{{ __('Provinsi') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="sel_province" name="province"
                                class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white appearance-none">
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    @error('province')<p class="mt-1.5 text-rose-500 text-xs font-bold">{{ $message }}</p>@enderror
                </div>

                {{-- Kabupaten/Kota --}}
                <div>
                    <label for="city" class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase tracking-widest">{{ __('Kabupaten / Kota') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="sel_city" name="city" disabled
                                class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white appearance-none disabled:opacity-50">
                            <option value="">-- Pilih Provinsi dulu --</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    @error('city')<p class="mt-1.5 text-rose-500 text-xs font-bold">{{ $message }}</p>@enderror
                </div>

                {{-- Kecamatan --}}
                <div>
                    <label for="district" class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase tracking-widest">{{ __('Kecamatan') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="sel_district" name="district" disabled
                                class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white appearance-none disabled:opacity-50">
                            <option value="">-- Pilih Kab/Kota dulu --</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    @error('district')<p class="mt-1.5 text-rose-500 text-xs font-bold">{{ $message }}</p>@enderror
                </div>

                {{-- Desa/Kelurahan --}}
                <div>
                    <label for="village" class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase tracking-widest">{{ __('Desa / Kelurahan') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="sel_village" name="village" disabled
                                class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white appearance-none disabled:opacity-50">
                            <option value="">-- Pilih Kecamatan dulu --</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    @error('village')<p class="mt-1.5 text-rose-500 text-xs font-bold">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Alamat Detail --}}
            <div>
                <label for="detail_address" class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase tracking-widest">{{ __('Alamat Detail (Jalan, RT/RW, dll)') }} <span class="text-rose-500">*</span></label>
                <textarea id="detail_address" name="detail_address" rows="3"
                          placeholder="Contoh: Jl. Merdeka No. 45, RT 01/RW 02, dekat Masjid Al-Ikhlas..."
                          class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white placeholder-slate-300 resize-none">{{ old('detail_address', $user->detail_address) }}</textarea>
                @error('detail_address')<p class="mt-1.5 text-rose-500 text-xs font-bold">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Spinner loading indicator --}}
        <div id="region_loading" class="hidden text-xs text-slate-400 font-medium flex items-center gap-2">
            <svg class="animate-spin h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
            Memuat data wilayah...
        </div>

        <script>
        (function() {
            const WILAYAH_BASE = '{{ url('') }}';

            const PROV_URL  = `${WILAYAH_BASE}/api/wilayah/provinsi`;
            const KOTA_URL  = (id) => `${WILAYAH_BASE}/api/wilayah/kota/${id}`;
            const KEC_URL   = (id) => `${WILAYAH_BASE}/api/wilayah/kecamatan/${id}`;
            const DESA_URL  = (id) => `${WILAYAH_BASE}/api/wilayah/desa/${id}`;

            const selProvince = document.getElementById('sel_province');
            const selCity     = document.getElementById('sel_city');
            const selDistrict = document.getElementById('sel_district');
            const selVillage  = document.getElementById('sel_village');
            const hProvCode   = document.getElementById('province_code');
            const hCityCode   = document.getElementById('city_code');
            const hDistCode   = document.getElementById('district_code');
            const hVillCode   = document.getElementById('village_code');
            const loading     = document.getElementById('region_loading');

            // Data tersimpan dari profil (untuk pre-fill)
            const savedProvinceCode  = '{{ old('province_code', $user->province_code ?? '') }}';
            const savedProvinceName  = '{{ old('province',      $user->province ?? '') }}';
            const savedCityCode      = '{{ old('city_code',     $user->city_code ?? '') }}';
            const savedCityName      = '{{ old('city',          $user->city ?? '') }}';
            const savedDistrictCode  = '{{ old('district_code', $user->district_code ?? '') }}';
            const savedDistrictName  = '{{ old('district',      $user->district ?? '') }}';
            const savedVillageCode   = '{{ old('village_code',  $user->village_code ?? '') }}';
            const savedVillageName   = '{{ old('village',       $user->village ?? '') }}';

            function showLoading(show) {
                loading.classList.toggle('hidden', !show);
            }

            function populateSelect(sel, items, valueKey, nameKey, placeholder, savedCode, savedName) {
                sel.innerHTML = `<option value="">${placeholder}</option>`;
                let selectedOpt = null;
                items.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item[nameKey];
                    opt.dataset.code = item[valueKey];
                    opt.textContent = item[nameKey];
                    
                    if (savedCode && String(item[valueKey]) === String(savedCode)) {
                        opt.selected = true;
                        selectedOpt = opt;
                    } else if (!savedCode && savedName && item[nameKey].toUpperCase() === savedName.toUpperCase()) {
                        opt.selected = true;
                        selectedOpt = opt;
                    }
                    sel.appendChild(opt);
                });
                sel.disabled = false;
                return selectedOpt ? selectedOpt.dataset.code : '';
            }

            function getSelectedCode(sel) {
                const opt = sel.options[sel.selectedIndex];
                return opt ? (opt.dataset.code || '') : '';
            }

            // ── Load Provinsi ──
            async function loadProvinces() {
                showLoading(true);
                try {
                    const res = await fetch(PROV_URL);
                    const data = await res.json();
                    const activeCode = populateSelect(selProvince, data, 'id', 'name', '-- Pilih Provinsi --', savedProvinceCode, savedProvinceName);
                    const code = activeCode || savedProvinceCode;
                    hProvCode.value = code;
                    if (code) {
                        await loadCities(code, true);
                    }
                } catch(e) { console.error('Gagal load provinsi', e); }
                showLoading(false);
            }

            // ── Load Kabupaten/Kota ──
            async function loadCities(provinceCode, auto = false) {
                showLoading(true);
                selCity.innerHTML = '<option value="">Memuat...</option>';
                selCity.disabled = true;
                resetBelow('city');
                try {
                    const res = await fetch(KOTA_URL(provinceCode));
                    const data = await res.json();
                    const activeCode = populateSelect(selCity, data, 'id', 'name', '-- Pilih Kabupaten/Kota --', auto ? savedCityCode : '', auto ? savedCityName : '');
                    const code = activeCode || (auto ? savedCityCode : '');
                    if (auto) {
                        hCityCode.value = code;
                    }
                    if (code && auto) {
                        await loadDistricts(code, true);
                    }
                } catch(e) { console.error('Gagal load kab/kota', e); }
                showLoading(false);
            }

            // ── Load Kecamatan ──
            async function loadDistricts(cityCode, auto = false) {
                showLoading(true);
                selDistrict.innerHTML = '<option value="">Memuat...</option>';
                selDistrict.disabled = true;
                resetBelow('district');
                try {
                    const res = await fetch(KEC_URL(cityCode));
                    const data = await res.json();
                    const activeCode = populateSelect(selDistrict, data, 'id', 'name', '-- Pilih Kecamatan --', auto ? savedDistrictCode : '', auto ? savedDistrictName : '');
                    const code = activeCode || (auto ? savedDistrictCode : '');
                    if (auto) {
                        hDistCode.value = code;
                    }
                    if (code && auto) {
                        await loadVillages(code, true);
                    }
                } catch(e) { console.error('Gagal load kecamatan', e); }
                showLoading(false);
            }

            // ── Load Desa/Kelurahan ──
            async function loadVillages(districtCode, auto = false) {
                showLoading(true);
                selVillage.innerHTML = '<option value="">Memuat...</option>';
                selVillage.disabled = true;
                try {
                    const res = await fetch(DESA_URL(districtCode));
                    const data = await res.json();
                    const activeCode = populateSelect(selVillage, data, 'id', 'name', '-- Pilih Desa/Kelurahan --', auto ? savedVillageCode : '', auto ? savedVillageName : '');
                    const code = activeCode || (auto ? savedVillageCode : '');
                    if (auto) {
                        hVillCode.value = code;
                    }
                } catch(e) { console.error('Gagal load desa', e); }
                showLoading(false);
            }

            function resetBelow(level) {
                if (level === 'province' || level === 'city') {
                    selDistrict.innerHTML = '<option value="">-- Pilih Kab/Kota dulu --</option>';
                    selDistrict.disabled = true;
                    hDistCode.value = '';
                }
                if (level !== 'village') {
                    selVillage.innerHTML = '<option value="">-- Pilih Kecamatan dulu --</option>';
                    selVillage.disabled = true;
                    hVillCode.value = '';
                }
                if (level === 'province') {
                    selCity.innerHTML = '<option value="">-- Pilih Provinsi dulu --</option>';
                    selCity.disabled = true;
                    hCityCode.value = '';
                }
            }

            // ── Event Listeners ──
            selProvince.addEventListener('change', function() {
                const code = getSelectedCode(this);
                hProvCode.value = code;
                hCityCode.value = '';
                hDistCode.value = '';
                hVillCode.value = '';
                resetBelow('province');
                if (code) loadCities(code);
            });

            selCity.addEventListener('change', function() {
                const code = getSelectedCode(this);
                hCityCode.value = code;
                hDistCode.value = '';
                hVillCode.value = '';
                resetBelow('city');
                if (code) loadDistricts(code);
            });

            selDistrict.addEventListener('change', function() {
                const code = getSelectedCode(this);
                hDistCode.value = code;
                hVillCode.value = '';
                resetBelow('district');
                if (code) loadVillages(code);
            });

            selVillage.addEventListener('change', function() {
                hVillCode.value = getSelectedCode(this);
            });

            // Jalankan load awal
            loadProvinces();
        })();
        </script>

        <div class="flex items-center gap-4 pt-8 mt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-900 text-white font-bold px-8 py-3.5 rounded-2xl hover:bg-rose-600 transition duration-300 shadow-xl shadow-slate-200">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-emerald-500 font-bold flex items-center gap-2 bg-emerald-50 px-4 py-2 rounded-xl"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ __('Berhasil Disimpan.') }}
                </p>
            @endif
        </div>
    </form>

    {{-- ===== BANK SECTION (Di luar form utama agar tidak nested) ===== --}}
    @if($user->is_admin || $user->role === 'admin')
        <div id="bank-section" class="mt-10 p-6 sm:p-8 bg-slate-900 rounded-[2rem] shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -z-10"></div>

                <header class="relative z-10 border-b border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-extrabold text-white flex items-center gap-2">
                        💳 {{ __('Pengaturan Rekening Bank') }}
                    </h2>
                    <p class="mt-1 text-xs font-medium text-slate-400">
                        {{ __("Khusus Admin. Semua rekening akan ditampilkan sebagai pilihan transfer di halaman pre-order pembeli.") }}
                    </p>
                </header>

                {{-- ===== DAFTAR REKENING YANG ADA ===== --}}
                @if($bankAccounts->count() > 0)
                <div class="relative z-10 space-y-3 mb-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Rekening Terdaftar ({{ $bankAccounts->count() }})</p>

                    @foreach($bankAccounts as $bank)
                    <div class="flex items-center gap-3 p-4 rounded-2xl border transition-all duration-200 group
                        {{ $bank->is_active ? 'bg-slate-800 border-slate-700' : 'bg-slate-800/50 border-slate-700/50 opacity-60' }}">

                        {{-- Logo / Inisial Bank --}}
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center font-black text-sm
                            {{ $bank->is_active ? 'bg-rose-500/20 text-rose-400' : 'bg-slate-700 text-slate-500' }}">
                            {{ strtoupper(substr($bank->bank_name, 0, 3)) }}
                        </div>

                        {{-- Info Rekening --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-white font-black text-sm">{{ $bank->bank_name }}</span>
                                @if($bank->is_active)
                                    <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-black rounded-full uppercase tracking-wider">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 bg-slate-600/50 text-slate-400 text-[10px] font-black rounded-full uppercase tracking-wider">Nonaktif</span>
                                @endif
                            </div>
                            <p class="text-rose-400 font-black tracking-wider text-sm mt-0.5">{{ $bank->bank_account }}</p>
                            <p class="text-slate-400 text-xs font-medium">a.n. {{ $bank->bank_owner }}</p>
                        </div>

                        {{-- Aksi --}}
                        <div class="flex-shrink-0 flex items-center gap-2">
                            {{-- Toggle Aktif/Nonaktif --}}
                            <form action="{{ route('bank.toggle', $bank->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    title="{{ $bank->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200
                                    {{ $bank->is_active ? 'bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/40' : 'bg-slate-700 text-slate-400 hover:bg-slate-600' }}">
                                    @if($bank->is_active)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    @endif
                                </button>
                            </form>

                            {{-- Hapus --}}
                            <form action="{{ route('bank.destroy', $bank->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus rekening {{ $bank->bank_name }} ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    title="Hapus rekening"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-500/20 text-rose-400 hover:bg-rose-500/40 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="relative z-10 mb-6 p-5 rounded-2xl border border-dashed border-slate-600 text-center">
                    <p class="text-slate-500 text-sm font-medium">Belum ada rekening bank. Tambahkan rekening pertama Anda di bawah.</p>
                </div>
                @endif

                {{-- ===== FORM TAMBAH REKENING BARU ===== --}}
                <div class="relative z-10">
                    <button type="button" id="toggleAddBankBtn"
                        class="flex items-center gap-2 text-sm font-bold text-rose-400 hover:text-rose-300 transition mb-4 group">
                        <span class="w-7 h-7 rounded-lg bg-rose-500/20 flex items-center justify-center group-hover:bg-rose-500/40 transition">
                            <svg id="addBankIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                        <span id="addBankLabel">Tambah Rekening Baru</span>
                    </button>

                    <div id="addBankForm" class="hidden">
                        <div class="p-5 bg-slate-800/60 rounded-2xl border border-slate-700 space-y-4">
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Rekening Baru</p>
                            <form action="{{ route('bank.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 mb-1.5 uppercase tracking-widest">Nama Bank</label>
                                        <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                                               placeholder="Contoh: BCA, Mandiri, BRI..."
                                               class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-600 focus:ring-2 focus:ring-rose-500 transition outline-none text-white font-bold bg-slate-800 placeholder-slate-500 text-sm">
                                        @error('bank_name')
                                            <p class="mt-1 text-rose-400 text-xs font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 mb-1.5 uppercase tracking-widest">Nomor Rekening</label>
                                        <input type="text" name="bank_account" value="{{ old('bank_account') }}"
                                               placeholder="Contoh: 1234567890"
                                               class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-600 focus:ring-2 focus:ring-rose-500 transition outline-none text-white font-black tracking-wider bg-slate-800 placeholder-slate-500 text-sm">
                                        @error('bank_account')
                                            <p class="mt-1 text-rose-400 text-xs font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-black text-slate-400 mb-1.5 uppercase tracking-widest">Atas Nama (Pemilik Rekening)</label>
                                        <input type="text" name="bank_owner" value="{{ old('bank_owner') }}"
                                               placeholder="Contoh: Pashmood Store"
                                               class="w-full px-4 py-3 rounded-xl border-none ring-1 ring-slate-600 focus:ring-2 focus:ring-rose-500 transition outline-none text-white font-bold bg-slate-800 placeholder-slate-500 text-sm">
                                        @error('bank_owner')
                                            <p class="mt-1 text-rose-400 text-xs font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 pt-1">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-sm font-bold rounded-xl transition duration-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        Simpan Rekening
                                    </button>
                                    <button type="button" id="cancelAddBank"
                                        class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 text-sm font-bold rounded-xl transition duration-200">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Flash messages --}}
                @if(session('status') === 'bank-added')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                         class="mt-4 relative z-10 flex items-center gap-2 text-sm text-emerald-400 font-bold bg-emerald-500/10 px-4 py-2.5 rounded-xl border border-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Rekening berhasil ditambahkan!
                    </div>
                @endif
                @if(session('status') === 'bank-deleted')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                         class="mt-4 relative z-10 flex items-center gap-2 text-sm text-rose-400 font-bold bg-rose-500/10 px-4 py-2.5 rounded-xl border border-rose-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Rekening berhasil dihapus.
                    </div>
                @endif
                @if(session('status') === 'bank-updated')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                         class="mt-4 relative z-10 flex items-center gap-2 text-sm text-sky-400 font-bold bg-sky-500/10 px-4 py-2.5 rounded-xl border border-sky-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Status rekening diperbarui.
                    </div>
                @endif
            </div>
        @endif

    <script>
    (function() {
        const toggleBtn  = document.getElementById('toggleAddBankBtn');
        const cancelBtn  = document.getElementById('cancelAddBank');
        const addForm    = document.getElementById('addBankForm');
        const addLabel   = document.getElementById('addBankLabel');
        const addIcon    = document.getElementById('addBankIcon');

        function openForm() {
            addForm.classList.remove('hidden');
            addLabel.textContent = 'Tutup Form';
            addIcon.style.transform = 'rotate(45deg)';
            addForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function closeForm() {
            addForm.classList.add('hidden');
            addLabel.textContent = 'Tambah Rekening Baru';
            addIcon.style.transform = 'rotate(0deg)';
        }

        if (toggleBtn) toggleBtn.addEventListener('click', function() {
            addForm.classList.contains('hidden') ? openForm() : closeForm();
        });

        if (cancelBtn) cancelBtn.addEventListener('click', closeForm);

        // Auto-buka form jika ada error validasi dari request bank
        @if($errors->has('bank_name') || $errors->has('bank_account') || $errors->has('bank_owner'))
            document.addEventListener('DOMContentLoaded', function() {
                openForm();
                document.getElementById('bank-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        @endif
    })();
    </script>
</section>