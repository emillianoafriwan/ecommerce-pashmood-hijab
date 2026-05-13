<section>
    <header class="mb-8">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
            {{ __('Informasi Profil & Pengiriman') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500 font-medium max-w-xl leading-relaxed">
            {{ __("Perbarui informasi profil, alamat email, dan data pengiriman akun Anda untuk memastikan pengalaman berbelanja yang lancar.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

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

        <div>
            <label for="address" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">{{ __('Alamat Lengkap Pengiriman') }}</label>
            <textarea id="address" name="address" rows="3" placeholder="Tuliskan alamat lengkap pengiriman Anda..."
                      class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-medium bg-slate-50 focus:bg-white placeholder-slate-300 resize-none">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
            @enderror
        </div>

        @if($user->is_admin || $user->role === 'admin')
            <div class="mt-10 p-6 sm:p-8 bg-slate-900 rounded-[2rem] shadow-xl relative overflow-hidden space-y-6">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -z-10"></div>
                
                <header class="relative z-10 border-b border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-extrabold text-white flex items-center gap-2">
                        💳 {{ __('Pengaturan Rekening Bank') }}
                    </h2>
                    <p class="mt-1 text-xs font-medium text-slate-400">
                        {{ __("Khusus Admin. Data ini akan ditampilkan otomatis sebagai instruksi transfer di halaman pre-order pembeli.") }}
                    </p>
                </header>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="bank_name" class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">{{ __('Nama Bank') }}</label>
                        <input id="bank_name" name="bank_name" type="text" value="{{ old('bank_name', $user->bank_name) }}" placeholder="Contoh: BCA / Mandiri"
                               class="w-full px-5 py-3.5 rounded-xl border-none ring-1 ring-slate-700 focus:ring-2 focus:ring-rose-500 transition outline-none text-white font-bold bg-slate-800 placeholder-slate-500">
                        @error('bank_name')
                            <p class="mt-2 text-rose-400 text-xs font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bank_account" class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">{{ __('Nomor Rekening') }}</label>
                        <input id="bank_account" name="bank_account" type="text" value="{{ old('bank_account', $user->bank_account) }}" placeholder="Contoh: 1234567890"
                               class="w-full px-5 py-3.5 rounded-xl border-none ring-1 ring-slate-700 focus:ring-2 focus:ring-rose-500 transition outline-none text-white font-black tracking-wider bg-slate-800 placeholder-slate-500">
                        @error('bank_account')
                            <p class="mt-2 text-rose-400 text-xs font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="bank_owner" class="block text-[10px] font-black text-slate-400 mb-2 uppercase tracking-widest">{{ __('Atas Nama (Pemilik Rekening)') }}</label>
                        <input id="bank_owner" name="bank_owner" type="text" value="{{ old('bank_owner', $user->bank_owner) }}" placeholder="Contoh: Amira Salma"
                               class="w-full px-5 py-3.5 rounded-xl border-none ring-1 ring-slate-700 focus:ring-2 focus:ring-rose-500 transition outline-none text-white font-bold bg-slate-800 placeholder-slate-500">
                        @error('bank_owner')
                            <p class="mt-2 text-rose-400 text-xs font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

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
</section>