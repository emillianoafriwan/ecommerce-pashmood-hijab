<section>
    <header class="mb-8 border-b border-slate-100 pb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center border border-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                {{ __('Perbarui Password') }}
            </h2>
        </div>
        <p class="text-sm text-slate-500 font-medium max-w-xl leading-relaxed mt-3">
            {{ __('Pastikan akun PASHMOOD Anda menggunakan password acak yang panjang agar tetap aman dan terhindar dari akses yang tidak sah.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">{{ __('Password Saat Ini') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300">
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">{{ __('Password Baru') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300">
            @error('password', 'updatePassword')
                <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-widest">{{ __('Konfirmasi Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300">
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="bg-slate-900 text-white font-bold px-8 py-3.5 rounded-2xl hover:bg-rose-600 transition duration-300 shadow-xl shadow-slate-200">
                {{ __('Simpan Password') }}
            </button>

            @if (session('status') === 'password-updated')
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