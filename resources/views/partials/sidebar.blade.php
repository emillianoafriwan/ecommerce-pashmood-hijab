<aside class="w-72 glass-sidebar min-h-screen flex flex-col justify-between p-6 shrink-0 sticky top-0 h-screen">
  <div>
    <div class="flex items-center gap-3 px-2 py-4 mb-8">
      <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14M5 7a2 2 0 110-4h14a2 2 0 110 4M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M9 11h4"/></svg>
      </div>
      <div>
        <h2 class="font-extrabold text-xl tracking-tight text-slate-900">PASHMOOD</h2>
        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Pembeli</span>
      </div>
    </div>
    <nav class="space-y-1">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-brand-50 text-brand-700 font-bold text-sm transition">
        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/></svg>
        Dashboard
      </a>
      <a href="{{ route('orders.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-500 hover:text-brand-600 hover:bg-brand-50/50 font-semibold text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
        Riwayat Pesanan
      </a>
      <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-500 hover:text-brand-600 hover:bg-brand-50/50 font-semibold text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Profil
      </a>
    </nav>
  </div>
  <div>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-rose-500 hover:bg-rose-50 font-bold text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        Logout
      </button>
    </form>
  </div>
</aside>
