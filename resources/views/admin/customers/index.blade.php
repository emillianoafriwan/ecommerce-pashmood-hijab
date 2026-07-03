<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan - Admin PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen pb-20">

    <header class="bg-slate-900 text-white py-6 mb-10 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Admin Panel</p>
                <h1 class="text-2xl font-extrabold tracking-tighter">PASHMOOD</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="/dashboard" class="flex items-center justify-center w-10 h-10 rounded-full border border-slate-700 hover:border-rose-500 bg-slate-800 overflow-hidden transition" title="Dashboard">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-rose-100 flex items-center justify-center text-rose-700 font-bold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-slate-800 shadow-sm border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Daftar Pelanggan</h2>
                    <p class="mt-1 text-sm text-slate-500 font-medium">Lihat detail profil, aktivitas transaksi, dan rekap pengeluaran pembeli.</p>
                </div>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-700 bg-white hover:text-rose-600 border border-slate-200 shadow-sm transition gap-2 w-full sm:w-auto">
                ← Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto hide-scroll">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                            <th class="px-8 py-5">Nama / Kontak</th>
                            <th class="px-8 py-5">No. Telepon</th>
                            <th class="px-8 py-5">Alamat</th>
                            <th class="px-8 py-5 text-center">Profil</th>
                            <th class="px-8 py-5 text-center">Transaksi Sukses</th>
                            <th class="px-8 py-5 text-right">Total Belanja</th>
                            <th class="px-8 py-5">Bergabung Pada</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-300 group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ substr($customer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $customer->name }}</p>
                                        <p class="text-xs text-slate-400 font-medium">{{ $customer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-sm text-slate-600 font-medium">
                                {{ $customer->phone ?? '-' }}
                            </td>
                            <td class="px-8 py-6">
                                @if($customer->isProfileComplete())
                                    <p class="text-xs font-bold text-slate-700">{{ $customer->city }}, {{ $customer->province }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium leading-relaxed max-w-xs">{{ $customer->detail_address }}</p>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum mengisi alamat</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($customer->isProfileComplete())
                                    <span class="inline-flex px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        Lengkap
                                    </span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-full bg-amber-50 text-amber-600 border border-amber-100">
                                        Belum Lengkap
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center text-sm font-bold text-slate-800">
                                {{ $customer->orders_count }} PO
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-black text-rose-600">
                                    Rp {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-xs text-slate-400 font-semibold">
                                {{ $customer->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-8 py-10 text-center text-slate-400 font-medium">
                                Belum ada pelanggan terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
</body>
</html>
