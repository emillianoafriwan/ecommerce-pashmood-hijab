<section>
    <header class="mb-8 border-b border-slate-100 pb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center border border-rose-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                {{ __('Hapus Akun') }}
            </h2>
        </div>
        <p class="text-sm text-slate-500 font-medium max-w-xl leading-relaxed mt-3">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data pesanan Anda akan hilang secara permanen. Pastikan Anda yakin sebelum melakukan tindakan ini.') }}
        </p>
    </header>

    <button x-data="" 
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-white border-2 border-rose-100 text-rose-600 font-bold px-8 py-3.5 rounded-2xl hover:bg-rose-50 hover:border-rose-200 transition duration-300 shadow-sm">
        {{ __('Hapus Akun Permanen') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-extrabold text-slate-800 mb-3 tracking-tight">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="text-sm text-slate-500 font-medium mb-8 leading-relaxed">
                {{ __('Tindakan ini tidak dapat dibatalkan. Semua data riwayat pesanan dan profil Anda akan terhapus. Silakan masukkan password Anda untuk mengonfirmasi.') }}
            </p>

            <div class="mb-8">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input id="password" name="password" type="password"
                       class="w-full px-5 py-4 rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-rose-500 transition outline-none text-slate-800 font-bold bg-slate-50 focus:bg-white placeholder-slate-300"
                       placeholder="{{ __('Masukkan password Anda') }}" />
                
                @error('password', 'userDeletion')
                    <p class="mt-2 text-rose-500 text-xs font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" x-on:click="$dispatch('close')"
                        class="w-full sm:w-auto px-6 py-3.5 rounded-2xl font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 hover:text-slate-800 transition">
                    {{ __('Batal') }}
                </button>

                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3.5 rounded-2xl font-bold text-white bg-rose-600 hover:bg-rose-700 transition shadow-lg shadow-rose-200">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>