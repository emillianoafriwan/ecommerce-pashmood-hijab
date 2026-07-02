<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id }} - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme-loader')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FDFBF9] min-h-screen text-slate-900 pb-20">

    <nav class="bg-white border-b border-rose-100/50 sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-slate-500 font-bold hover:text-rose-600 transition group text-sm">
                <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
            </a>
            <h1 class="font-extrabold text-xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="w-20"></div> </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 mt-10 space-y-8">
        
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Nomor Pesanan</p>
                <h2 class="text-2xl font-extrabold text-slate-800">#{{ $order->id }}</h2>
            </div>
            
            <span class="px-5 py-2 text-xs font-black uppercase tracking-widest rounded-full 
                {{ $order->status == 'paid' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 
                   ($order->status == 'waiting' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 
                   ($order->status == 'completed' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 
                   ($order->status == 'shipped' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 
                   ($order->status == 'canceled' ? 'bg-slate-100 text-slate-600 border border-slate-200' : 'bg-rose-100 text-rose-700 border border-rose-200')))) }}">
                {{ $order->statusIndo() }}
            </span>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-2xl text-sm font-bold">
                {{ session('error') }}
            </div>
        @endif

        @php
            $status = $order->status;
            
            $step1 = 'completed'; // Checkout selalu completed
            $step2 = 'pending';
            $step3 = 'pending';
            $step4 = 'pending';
            $step5 = 'pending';
            
            // Default text info
            $time1 = $order->created_at->format('H:i, d M Y');
            $desc2 = 'Belum melakukan pembayaran';
            $desc3 = 'Menunggu pembayaran';
            $desc4 = 'Menunggu pengiriman';
            $desc5 = 'Menunggu pesanan sampai';
            
            if ($status === 'pending' || $status === 'pre_order') {
                $step2 = 'active';
                $desc2 = 'Silakan unggah bukti transfer';
            } elseif ($status === 'waiting') {
                $step2 = 'completed';
                $desc2 = 'Bukti transfer diunggah';
                $step3 = 'active';
                $desc3 = 'Menunggu verifikasi admin';
            } elseif ($status === 'paid') {
                $step2 = 'completed';
                $desc2 = 'Bukti transfer diunggah';
                $step3 = 'completed';
                $desc3 = 'Pembayaran terverifikasi';
                $step4 = 'active';
                $desc4 = 'Sedang diproses & dikemas';
            } elseif ($status === 'shipped') {
                $step2 = 'completed';
                $desc2 = 'Bukti transfer diunggah';
                $step3 = 'completed';
                $desc3 = 'Pembayaran terverifikasi';
                $step4 = 'completed';
                $desc4 = 'Paket dikirim (' . ($order->courier ?? 'Kurir') . ')';
                $step5 = 'active';
                $desc5 = 'Silakan konfirmasi penerimaan';
            } elseif ($status === 'completed') {
                $step2 = 'completed';
                $desc2 = 'Bukti transfer diunggah';
                $step3 = 'completed';
                $desc3 = 'Pembayaran terverifikasi';
                $step4 = 'completed';
                $desc4 = 'Paket dikirim (' . ($order->courier ?? 'Kurir') . ')';
                $step5 = 'completed';
                $desc5 = 'Pesanan telah diterima';
            } elseif ($status === 'canceled') {
                if ($order->payment_proof) {
                    $step2 = 'completed';
                    $desc2 = 'Bukti transfer diunggah';
                    $step3 = 'canceled';
                    $desc3 = 'Pembayaran ditolak / dibatalkan';
                } else {
                    $step2 = 'canceled';
                    $desc2 = 'Pesanan dibatalkan sebelum bayar';
                }
            }

            // Calculate progress percentage
            $progressPercent = 0;
            if ($status === 'pending' || $status === 'pre_order') {
                $progressPercent = 0;
            } elseif ($status === 'waiting') {
                $progressPercent = 25;
            } elseif ($status === 'paid') {
                $progressPercent = 50;
            } elseif ($status === 'shipped') {
                $progressPercent = 75;
            } elseif ($status === 'completed') {
                $progressPercent = 100;
            } elseif ($status === 'canceled') {
                $progressPercent = $order->payment_proof ? 25 : 0;
            }

            $stepStyles = [
                'completed' => [
                    'circle' => 'bg-rose-600 text-white border-2 border-rose-600 shadow-lg shadow-rose-100',
                    'icon' => 'text-white',
                    'text' => 'text-slate-800 font-extrabold',
                    'desc' => 'text-slate-500 font-medium'
                ],
                'active' => [
                    'circle' => 'bg-white text-rose-600 border-2 border-rose-600 ring-4 ring-rose-100 shadow-md',
                    'icon' => 'text-rose-600',
                    'text' => 'text-rose-600 font-black',
                    'desc' => 'text-rose-500 font-bold'
                ],
                'canceled' => [
                    'circle' => 'bg-red-50 text-red-600 border-2 border-red-300',
                    'icon' => 'text-red-600',
                    'text' => 'text-red-600 font-black',
                    'desc' => 'text-red-500 font-bold'
                ],
                'pending' => [
                    'circle' => 'bg-slate-50 text-slate-400 border border-slate-200',
                    'icon' => 'text-slate-400',
                    'text' => 'text-slate-400 font-semibold',
                    'desc' => 'text-slate-400 font-normal'
                ]
            ];
            
            $s1 = $stepStyles[$step1];
            $s2 = $stepStyles[$step2];
            $s3 = $stepStyles[$step3];
            $s4 = $stepStyles[$step4];
            $s5 = $stepStyles[$step5];
        @endphp

        <!-- Timeline Alur Pesanan -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-8">Status Alur Pesanan</h3>
            
            <!-- Desktop Timeline (Horizontal) -->
            <div class="hidden md:block relative w-full mb-4">
                <!-- Progress Line -->
                <div class="absolute top-6 left-12 right-12 h-[3px] bg-slate-100 -translate-y-1/2 z-0">
                    <div class="h-full bg-rose-500 transition-all duration-500" style="width: {{ $progressPercent }}%;"></div>
                </div>
                
                <!-- Steps Container -->
                <div class="flex justify-between items-start relative z-10">
                    <!-- Step 1: Pemesanan -->
                    <div class="flex flex-col items-center text-center w-24">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 {{ $s1['circle'] }}">
                            @if($step1 === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-xs mt-3 {{ $s1['text'] }}">Pemesanan</p>
                        <p class="text-[10px] mt-1 {{ $s1['desc'] }} leading-tight">{{ $time1 }}</p>
                    </div>

                    <!-- Step 2: Pembayaran -->
                    <div class="flex flex-col items-center text-center w-24">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 {{ $s2['circle'] }}">
                            @if($step2 === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @elseif($step2 === 'canceled')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-xs mt-3 {{ $s2['text'] }}">Pembayaran</p>
                        <p class="text-[10px] mt-1 {{ $s2['desc'] }} leading-tight">{{ $desc2 }}</p>
                    </div>

                    <!-- Step 3: Verifikasi -->
                    <div class="flex flex-col items-center text-center w-24">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 {{ $s3['circle'] }}">
                            @if($step3 === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @elseif($step3 === 'canceled')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-xs mt-3 {{ $s3['text'] }}">Verifikasi</p>
                        <p class="text-[10px] mt-1 {{ $s3['desc'] }} leading-tight">{{ $desc3 }}</p>
                    </div>

                    <!-- Step 4: Pengiriman -->
                    <div class="flex flex-col items-center text-center w-24">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 {{ $s4['circle'] }}">
                            @if($step4 === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011-1v-4a1 1 0 01.4-.8l3-3a1 1 0 01.6-.2h3m-5 9v-4m5 4h.5a1.5 1.5 0 001.5-1.5V10a1.5 1.5 0 00-1.5-1.5H18M13 7h5.5a1.5 1.5 0 011.5 1.5v3m-13 5a2 2 0 11-4 0 2 2 0 014 0zm10 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-xs mt-3 {{ $s4['text'] }}">Pengiriman</p>
                        <p class="text-[10px] mt-1 {{ $s4['desc'] }} leading-tight">{{ $desc4 }}</p>
                    </div>

                    <!-- Step 5: Selesai -->
                    <div class="flex flex-col items-center text-center w-24">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 {{ $s5['circle'] }}">
                            @if($step5 === 'completed')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-xs mt-3 {{ $s5['text'] }}">Selesai</p>
                        <p class="text-[10px] mt-1 {{ $s5['desc'] }} leading-tight">{{ $desc5 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Timeline (Vertical) -->
            <div class="block md:hidden relative pl-8 space-y-8">
                <!-- Vertical Line -->
                <div class="absolute left-4 top-3 bottom-3 w-[2px] bg-slate-100 z-0">
                    @php
                        $vertHeight = match($progressPercent) {
                            100 => '100%',
                            75  => '75%',
                            50  => '50%',
                            25  => '25%',
                            default => '0%'
                        };
                    @endphp
                    <div class="w-full bg-rose-500 transition-all duration-500" style="height: {{ $vertHeight }};"></div>
                </div>
                
                <!-- Step 1 -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-8 w-8 h-8 rounded-full flex items-center justify-center z-10 transition-all duration-300 {{ $s1['circle'] }} text-xs shrink-0 font-bold">
                        @if($step1 === 'completed')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            1
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm {{ $s1['text'] }}">Pemesanan Dibuat</h4>
                        <p class="text-xs mt-0.5 {{ $s1['desc'] }}">{{ $time1 }}</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-8 w-8 h-8 rounded-full flex items-center justify-center z-10 transition-all duration-300 {{ $s2['circle'] }} text-xs shrink-0 font-bold">
                        @if($step2 === 'completed')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @elseif($step2 === 'canceled')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @else
                            2
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm {{ $s2['text'] }}">Pembayaran</h4>
                        <p class="text-xs mt-0.5 {{ $s2['desc'] }}">{{ $desc2 }}</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-8 w-8 h-8 rounded-full flex items-center justify-center z-10 transition-all duration-300 {{ $s3['circle'] }} text-xs shrink-0 font-bold">
                        @if($step3 === 'completed')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @elseif($step3 === 'canceled')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @else
                            3
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm {{ $s3['text'] }}">Verifikasi Pembayaran</h4>
                        <p class="text-xs mt-0.5 {{ $s3['desc'] }}">{{ $desc3 }}</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-8 w-8 h-8 rounded-full flex items-center justify-center z-10 transition-all duration-300 {{ $s4['circle'] }} text-xs shrink-0 font-bold">
                        @if($step4 === 'completed')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            4
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm {{ $s4['text'] }}">Pengiriman</h4>
                        <p class="text-xs mt-0.5 {{ $s4['desc'] }}">{{ $desc4 }}</p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-8 w-8 h-8 rounded-full flex items-center justify-center z-10 transition-all duration-300 {{ $s5['circle'] }} text-xs shrink-0 font-bold">
                        @if($step5 === 'completed')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        @else
                            5
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm {{ $s5['text'] }}">Selesai</h4>
                        <p class="text-xs mt-0.5 {{ $s5['desc'] }}">{{ $desc5 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest">Ringkasan Pesanan</h3>
            </div>
            <div class="p-8 grid gap-6 sm:grid-cols-2">
                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-100">
                    <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Tanggal Pesan</p>
                    <p class="text-sm font-bold text-slate-800">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-100">
                    <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Jumlah Item</p>
                    <p class="text-sm font-bold text-slate-800">{{ $order->orderItems->sum('quantity') }} produk</p>
                </div>
                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-100">
                    <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Metode Kirim</p>
                    <p class="text-sm font-bold text-slate-800">{{ $order->courier ?? 'Belum dipilih' }}</p>
                </div>
                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-100">
                    <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mb-2">Status Pembayaran</p>
                    <p class="text-sm font-bold text-slate-800">{{ $order->statusIndo() }}</p>
                </div>
            </div>
            <div class="p-8">
                <div class="space-y-6">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden shrink-0">
                                <img src="{{ $item->product->imageUrl() ?? asset('images/default.jpg') }}" alt="Produk" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Produk PASHMOOD' }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-[10px] uppercase tracking-widest font-black text-slate-400 mt-2">Variasi: {{ $item->variation->color ?? 'Standar' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-extrabold text-slate-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-slate-50 p-8 flex flex-col sm:flex-row sm:justify-between sm:items-center border-t border-slate-100 gap-4">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Pembayaran</p>
                    <p class="text-2xl font-black text-rose-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                @if($order->resi_number && in_array($order->status, ['shipped', 'completed']))
                    <div class="text-sm text-slate-600">
                        <p class="font-black uppercase tracking-widest text-slate-400">No. Resi</p>
                        <p class="mt-1 font-bold text-slate-800">{{ $order->resi_number }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Alamat Pengiriman
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Penerima & Kontak</p>
                    <p class="font-bold text-slate-800">{{ $order->user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $order->phone }}</p>
                </div>
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Alamat Lengkap</p>
                    <p class="text-sm font-medium text-slate-600 leading-relaxed">{{ $order->address }}</p>
                </div>
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Jasa Pengiriman</p>
                    <p class="font-bold text-slate-800">{{ $order->courier ?? 'Belum dipilih' }}</p>
                </div>
            </div>
        </div>

        @if(in_array($order->status, ['pre_order', 'pending']))
            
            @php
                $admin = \App\Models\User::where('role', 'admin')->first();
                $adminBanks = $admin ? $admin->bankAccounts()->where('is_active', true)->get() : collect();
                // Fallback ke kolom lama jika belum ada data di tabel baru
                $hasBanks = $adminBanks->count() > 0 || ($admin && $admin->bank_account);
            @endphp

            @if($hasBanks)
            <div class="bg-white border-2 border-rose-100 p-8 rounded-[2.5rem] shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -z-10"></div>
                
                <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-2 flex items-center gap-2">
                    💳 Instruksi Pembayaran
                </h3>
                <p class="text-slate-500 text-sm mb-6 leading-relaxed">
                    Agar pre-order Anda segera kami proses, silakan lakukan pembayaran sebesar <strong class="text-rose-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> ke salah satu rekening berikut:
                </p>

                {{-- List semua rekening aktif --}}
                @if($adminBanks->count() > 0)
                    <div class="space-y-3 mb-8">
                        @foreach($adminBanks as $bank)
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 flex flex-col md:flex-row items-center md:items-stretch gap-4">
                            {{-- Logo / Inisial Bank --}}
                            <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-auto rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-black text-base self-center md:self-stretch">
                                {{ strtoupper(substr($bank->bank_name, 0, 3)) }}
                            </div>
                            {{-- Info --}}
                            <div class="flex-1 flex flex-col md:flex-row items-center md:items-stretch gap-4 text-center md:text-left">
                                <div class="flex-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bank Tujuan</p>
                                    <p class="text-lg font-black text-slate-800">{{ $bank->bank_name }}</p>
                                </div>
                                <div class="flex-1 border-t md:border-t-0 md:border-l border-slate-200 pt-3 md:pt-0 md:pl-5">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor Rekening</p>
                                    <p class="text-xl font-black text-rose-600 tracking-wider">{{ $bank->bank_account }}</p>
                                </div>
                                <div class="flex-1 border-t md:border-t-0 md:border-l border-slate-200 pt-3 md:pt-0 md:pl-5">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Atas Nama</p>
                                    <p class="text-base font-bold text-slate-800">{{ $bank->bank_owner }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    {{-- Fallback ke kolom lama --}}
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
                        <div class="text-center md:text-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Bank Tujuan</p>
                            <p class="text-lg font-black text-slate-800">{{ $admin->bank_name }}</p>
                        </div>
                        <div class="text-center md:text-left border-t md:border-t-0 md:border-l border-slate-200 pt-4 md:pt-0 md:pl-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor Rekening</p>
                            <p class="text-2xl font-black text-rose-600 tracking-wider">{{ $admin->bank_account }}</p>
                        </div>
                        <div class="text-center md:text-left border-t md:border-t-0 md:border-l border-slate-200 pt-4 md:pt-0 md:pl-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Atas Nama</p>
                            <p class="text-lg font-bold text-slate-800">{{ $admin->bank_owner }}</p>
                        </div>
                    </div>
                @endif

                @if($order->rejection_reason)
                    <div class="bg-rose-50 border border-rose-200 p-5 rounded-2xl mb-6">
                        <p class="text-rose-700 font-bold text-sm mb-1">⚠️ Pembayaran Ditolak</p>
                        <p class="text-rose-600 text-sm mb-2">Alasan: {{ $order->rejection_reason }}</p>
                        <p class="text-xs text-rose-500 font-medium">Silakan unggah ulang bukti transfer yang valid.</p>
                    </div>
                @endif

                <form action="{{ route('order.confirm', $order->id) }}" method="POST" enctype="multipart/form-data" data-no-ajax="true">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Upload Bukti Transfer</label>
                        <input type="file" id="payment_proof" name="payment_proof" accept="image/*" onchange="previewPaymentProof(this)" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 transition cursor-pointer border border-slate-200 rounded-2xl p-2" required>
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">Format: JPG, JPEG, PNG. Ukuran maksimal: 20 MB.</p>
                        @error('payment_proof')
                            <p class="text-rose-600 text-xs font-bold mt-2">{{ $message }}</p>
                        @enderror

                        {{-- Pratinjau Bukti Transfer --}}
                        <div id="payment-proof-preview-container" class="hidden mt-6 bg-slate-50 p-6 rounded-3xl border border-slate-100 flex flex-col items-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Pratinjau Bukti Transfer</p>
                            <div class="w-48 h-64 rounded-2xl overflow-hidden border-4 border-white shadow-lg relative bg-slate-200 flex items-center justify-center">
                                <img id="payment-proof-preview" src="" class="w-full h-full object-cover hidden">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-rose-600 transition shadow-xl shadow-slate-200">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
            @else
            <div class="bg-amber-50 p-6 rounded-[2rem] border border-amber-200 text-amber-700 text-sm font-bold text-center">
                Mohon maaf, sistem pembayaran sedang dalam pemeliharaan. Silakan hubungi admin.
            </div>
            @endif

        @elseif($order->status == 'waiting')
            <div class="bg-amber-50 p-8 rounded-[2.5rem] text-center border border-amber-100 flex flex-col items-center">
                <div class="w-16 h-16 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-amber-800 font-extrabold text-lg mb-2">Menunggu Verifikasi Admin</h3>
                <p class="text-amber-700 text-sm mb-6 max-w-md">Bukti transfer Anda telah kami terima. Tim kami akan segera melakukan pengecekan dalam waktu 1x24 jam.</p>
                <div class="w-48 h-64 rounded-2xl overflow-hidden border-4 border-white shadow-lg">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-full object-cover">
                </div>
            </div>

        @elseif($order->status == 'canceled')
            <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-start gap-5">
                    <div class="w-12 h-12 bg-white text-slate-500 rounded-full flex items-center justify-center shrink-0 border border-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    <div>
                        <h3 class="text-slate-800 font-extrabold text-lg mb-2">Pesanan Dibatalkan</h3>
                        <p class="text-slate-500 text-sm mb-4">Pre-order ini sudah dibatalkan dan tidak akan diproses ke tahap pembayaran atau pengiriman.</p>
                        @if($order->cancellation_reason)
                            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Alasan Pembatalan</p>
                                <p class="text-sm font-semibold text-slate-700 leading-relaxed">{{ $order->cancellation_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        @else
            <div class="bg-emerald-50 p-6 rounded-[2rem] text-center border border-emerald-100 flex items-center justify-center gap-4">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-emerald-800 font-bold text-sm md:text-base">Pembayaran Terverifikasi. Pre-Order Anda sedang diproses!</p>
            </div>
        @endif

        @if(in_array($order->status, ['pre_order', 'pending', 'waiting']))
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-rose-100 p-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-6">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-sm uppercase tracking-widest mb-2">Batalkan Pesanan</h3>
                        <p class="text-sm text-slate-500 leading-relaxed max-w-xl">Jika Anda tidak ingin melanjutkan pre-order ini, isi alasan pembatalan terlebih dahulu. Stok produk akan otomatis dikembalikan.</p>
                    </div>
                </div>

                <form id="form-cancel-order" action="{{ route('order.cancel', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="cancellation_reason" class="block text-xs font-black text-slate-700 mb-3 uppercase tracking-widest">Alasan Pembatalan</label>
                        <textarea id="cancellation_reason" name="cancellation_reason" rows="4" class="w-full border border-slate-200 rounded-2xl p-4 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-300" placeholder="Contoh: Saya ingin mengubah warna / belum bisa melakukan pembayaran." required>{{ old('cancellation_reason') }}</textarea>
                        @error('cancellation_reason')
                            <p class="text-rose-600 text-xs font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="button" onclick="handleCancelClick(event)" class="w-full md:w-auto bg-rose-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-rose-700 transition shadow-lg shadow-rose-100 text-sm uppercase tracking-wider">
                        Batalkan Pesanan
                    </button>
                </form>
            </div>
        @endif

        @if($order->resi_number && in_array($order->status, ['shipped', 'completed']))
            @php
                $trackingUrl = match($order->courier) {
                    'JNE Express' => 'https://www.jne.co.id/id/tracking/trace',
                    'J&T Express' => 'https://jet.co.id/track',
                    'Sicepat' => 'https://www.sicepat.com/checkAwb',
                    'Anteraja' => 'https://anteraja.id/tracking',
                    default => null,
                };
            @endphp
            <div class="bg-slate-900 text-white p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden">
                <div class="absolute -right-6 -top-6 text-slate-800 opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" viewBox="0 0 20 20" fill="currentColor"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5h-3V7h-1z" /></svg>
                </div>
                
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-rose-400 mb-1">Status Logistik</p>
                    <h3 class="text-xl font-extrabold mb-6">Paket Telah Dikirim!</h3>
                    
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-1">Kurir</p>
                            <p class="font-bold text-lg">{{ $order->courier }}</p>
                        </div>
                        <div class="md:border-l md:border-slate-700 pl-0 md:pl-6">
                            <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-1">Nomor Resi</p>
                            <p class="font-black text-2xl tracking-wider text-rose-300">{{ $order->resi_number }}</p>
                        </div>
                    </div>

                    @if($trackingUrl)
                        <a href="{{ $trackingUrl }}" target="_blank" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-white text-slate-900 px-6 py-3 text-xs font-black uppercase tracking-widest hover:bg-rose-100 transition">
                            Lacak Paket
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if($order->status == 'shipped')
            <div class="bg-indigo-50 border border-indigo-100 p-8 rounded-[2.5rem] text-center shadow-sm">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">📦</div>
                <h3 class="text-xl font-extrabold text-indigo-900 mb-2">Paket Sudah Sampai?</h3>
                <p class="text-sm text-indigo-700 mb-6 max-w-md mx-auto">Pastikan Anda telah menerima produk dalam kondisi baik sebelum mengonfirmasi pesanan selesai.</p>
                
                <form id="form-complete-order" action="{{ route('order.complete', $order->id) }}" method="POST">
                    @csrf
                    <button type="button" onclick="handleCompleteClick()" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 w-full md:w-auto text-sm uppercase tracking-wider">
                        Ya, Pesanan Diterima
                    </button>
                </form>
            </div>
        @endif

        @if($order->status == 'completed')
            <div id="review-section" class="bg-rose-50 border border-rose-100 p-8 rounded-[2.5rem] text-center shadow-sm">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">✨</div>
                <h3 class="text-xl font-extrabold text-rose-900 mb-2">Terima Kasih, Pashmood Sisters!</h3>
                <p class="text-sm text-rose-700 mb-6 max-w-md mx-auto">Bagikan pengalamanmu berbelanja di PASHMOOD. Ulasanmu sangat berarti bagi kami.</p>
                
                <div class="max-w-2xl mx-auto bg-white rounded-3xl p-6 shadow-sm border border-rose-100 text-left">
                    <div class="divide-y divide-rose-50">
                        @foreach($order->orderItems as $item)
                            <div class="py-4 first:pt-0 last:pb-0">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 shrink-0">
                                            <img src="{{ $item->product->imageUrl() ?? asset('images/default.jpg') }}" alt="Produk" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $item->product->name ?? 'Produk PASHMOOD' }}</h4>
                                            <p class="text-xs text-slate-400 mt-0.5">Variasi: {{ $item->variation->color ?? 'Standar' }}</p>
                                        </div>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        @php
                                            $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                                                ->where('product_id', $item->product_id)
                                                ->exists();
                                        @endphp
                                        @if($hasReviewed)
                                            <a href="{{ route('product.show', $item->product_id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold border border-emerald-100 hover:bg-emerald-600 hover:text-white transition duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                Sudah Diulas (Lihat)
                                            </a>
                                        @else
                                            <button type="button" onclick="toggleReviewForm({{ $item->id }})" class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold hover:bg-rose-700 transition shadow-md shadow-rose-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                Tulis Ulasan
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                @if(!$hasReviewed)
                                    <!-- Collapsible Review Form -->
                                    <div id="review-form-{{ $item->id }}" class="hidden mt-4 bg-rose-50/40 rounded-3xl p-6 border border-rose-100/60 text-slate-800 transition-all duration-300">
                                        <h5 class="font-extrabold text-sm text-rose-950 mb-0.5">Berikan Ulasan untuk {{ $item->product->name }}</h5>
                                        <p class="text-rose-700/70 text-[10px] mb-6">Ulasan Anda sangat berharga bagi pelanggan PASHMOOD lainnya.</p>

                                        <form action="{{ route('review.store', $item->product_id) }}" method="POST" enctype="multipart/form-data" data-no-ajax="true" class="space-y-5">
                                            @csrf
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="block text-[10px] font-black uppercase tracking-widest text-rose-900 mb-2">Rating</label>
                                                    <input type="hidden" name="rating" id="rating-input-{{ $item->id }}" value="5">
                                                    <div class="flex items-center gap-4 bg-white border border-rose-100 rounded-xl px-4 py-2">
                                                        <div class="flex items-center gap-1" id="star-container-{{ $item->id }}">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <button type="button" onclick="setRating({{ $item->id }}, {{ $i }})" class="hover:scale-110 transition duration-150 focus:outline-none">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 star-icon text-amber-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                </button>
                                                            @endfor
                                                        </div>
                                                        <span id="rating-label-{{ $item->id }}" class="text-xs font-bold text-rose-800">Sempurna (5/5)</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-black uppercase tracking-widest text-rose-900 mb-2">Foto / Video</label>
                                                    <div class="relative flex items-center bg-white border border-rose-100 rounded-xl px-4 py-2 hover:border-rose-300 transition group cursor-pointer">
                                                        <input type="file" name="media" id="media-input-{{ $item->id }}" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName({{ $item->id }}, this)">
                                                        <div class="flex items-center justify-between w-full">
                                                            <span id="file-name-{{ $item->id }}" class="text-xs text-slate-400 truncate pr-4">Pilih foto atau video...</span>
                                                            <span class="shrink-0 px-3 py-1.5 bg-rose-50 text-rose-700 text-[10px] font-bold rounded-lg border border-rose-100 group-hover:bg-rose-600 group-hover:text-white transition duration-200">
                                                                Pilih File
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-rose-900 mb-2">Ulasan Anda</label>
                                                <textarea name="comment" rows="3" class="w-full bg-white border border-rose-100 rounded-2xl px-4 py-3.5 text-xs text-slate-800 focus:ring-2 focus:ring-rose-200 focus:border-rose-300 focus:outline-none placeholder-slate-400 transition" placeholder="Bagikan ulasan jujur Anda tentang produk ini (kualitas bahan, kenyamanan, dll)..." required></textarea>
                                            </div>
                                            <div class="flex justify-end gap-2.5">
                                                <button type="button" onclick="toggleReviewForm({{ $item->id }})" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition">
                                                    Batal
                                                </button>
                                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-rose-200">
                                                    Kirim Ulasan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </main>

    <!-- Custom Confirmation Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <!-- Modal Container -->
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl border border-rose-100/50 transform scale-95 opacity-0 transition-all duration-300">
            <!-- Icon / Emoji -->
            <div id="modal-icon" class="w-16 h-16 bg-rose-50 border border-rose-100 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner">
                📦
            </div>
            
            <!-- Header -->
            <h3 id="modal-title" class="text-xl font-extrabold text-slate-800 text-center mb-2">Konfirmasi</h3>
            <p id="modal-message" class="text-sm text-slate-500 text-center mb-8 leading-relaxed">Apakah Anda yakin?</p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" id="modal-cancel" class="flex-1 px-6 py-4 rounded-2xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition text-sm uppercase tracking-wider text-center">
                    Batal
                </button>
                <button type="button" id="modal-confirm" class="flex-1 px-6 py-4 rounded-2xl text-white font-bold transition shadow-lg text-sm uppercase tracking-wider text-center">
                    Ya
                </button>
            </div>
        </div>
    </div>

    <script>
        (() => {
            function toggleReviewForm(itemId) {
                const form = document.getElementById('review-form-' + itemId);
                if (form) {
                    form.classList.toggle('hidden');
                }
            }

            function setRating(itemId, rating) {
                document.getElementById('rating-input-' + itemId).value = rating;
                const container = document.getElementById('star-container-' + itemId);
                const stars = container.querySelectorAll('.star-icon');
                const ratingLabel = document.getElementById('rating-label-' + itemId);
                
                const labels = {
                    1: 'Sangat Kurang (1/5)',
                    2: 'Kurang (2/5)',
                    3: 'Cukup (3/5)',
                    4: 'Sangat Puas (4/5)',
                    5: 'Sempurna (5/5)'
                };
                
                ratingLabel.textContent = labels[rating];
                
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('text-slate-200');
                        star.classList.add('text-amber-400');
                    } else {
                        star.classList.remove('text-amber-400');
                        star.classList.add('text-slate-200');
                    }
                });
            }

            function updateFileName(itemId, input) {
                const label = document.getElementById('file-name-' + itemId);
                if (input.files && input.files[0]) {
                    label.textContent = input.files[0].name;
                    label.classList.remove('text-slate-400');
                    label.classList.add('text-slate-700', 'font-semibold');
                } else {
                    label.textContent = 'Pilih foto atau video...';
                    label.classList.remove('text-slate-700', 'font-semibold');
                    label.classList.add('text-slate-400');
                }
            }

            function previewPaymentProof(input) {
                const previewContainer = document.getElementById('payment-proof-preview-container');
                const previewImg = document.getElementById('payment-proof-preview');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    previewImg.src = '';
                    previewImg.classList.add('hidden');
                    previewContainer.classList.add('hidden');
                }
            }

            let activeForm = null;

            function showConfirm({ title, message, icon, confirmText, confirmClass, formId }) {
                const modal = document.getElementById('confirm-modal');
                const modalContainer = modal.querySelector('div');
                
                document.getElementById('modal-title').textContent = title;
                document.getElementById('modal-message').textContent = message;
                document.getElementById('modal-icon').textContent = icon || '📦';
                
                const confirmBtn = document.getElementById('modal-confirm');
                confirmBtn.textContent = confirmText || 'Ya';
                confirmBtn.className = 'flex-1 px-6 py-4 rounded-2xl text-white font-bold transition shadow-lg text-sm uppercase tracking-wider text-center ' + (confirmClass || 'bg-rose-600 hover:bg-rose-700 shadow-rose-200');
                
                activeForm = document.getElementById(formId);
                
                modal.classList.remove('hidden');
                void modal.offsetWidth; // Force reflow
                modal.classList.remove('opacity-0');
                modalContainer.classList.remove('scale-95', 'opacity-0');
                modalContainer.classList.add('scale-100', 'opacity-100');
                document.body.classList.add('overflow-hidden');
            }

            function closeConfirmModal() {
                const modal = document.getElementById('confirm-modal');
                const modalContainer = modal.querySelector('div');
                
                modal.classList.add('opacity-0');
                modalContainer.classList.remove('scale-100', 'opacity-100');
                modalContainer.classList.add('scale-95', 'opacity-0');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            document.getElementById('modal-cancel').addEventListener('click', closeConfirmModal);
            document.getElementById('confirm-modal').addEventListener('click', (e) => {
                if (e.target === e.currentTarget) closeConfirmModal();
            });
            document.getElementById('modal-confirm').addEventListener('click', () => {
                if (activeForm) {
                    activeForm.submit();
                }
            });

            function handleCancelClick(event) {
                const form = document.getElementById('form-cancel-order');
                if (form.reportValidity()) {
                    showConfirm({
                        title: 'Batalkan Pesanan?',
                        message: 'Apakah Anda yakin ingin membatalkan pesanan ini? Stok produk akan otomatis dikembalikan.',
                        icon: '⚠️',
                        confirmText: 'Ya, Batalkan',
                        confirmClass: 'bg-rose-600 hover:bg-rose-700 shadow-rose-200',
                        formId: 'form-cancel-order'
                    });
                }
            }

            function handleCompleteClick() {
                showConfirm({
                    title: 'Konfirmasi Penerimaan',
                    message: 'Apakah Anda yakin sudah menerima pesanan ini dengan aman? Pastikan produk dalam kondisi baik sebelum konfirmasi.',
                    icon: '📦',
                    confirmText: 'Ya, Diterima',
                    confirmClass: 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-200',
                    formId: 'form-complete-order'
                });
            }

            // Expose required functions to window object
            window.toggleReviewForm = toggleReviewForm;
            window.setRating = setRating;
            window.updateFileName = updateFileName;
            window.previewPaymentProof = previewPaymentProof;
            window.handleCancelClick = handleCancelClick;
        })();
    </script>
    <!-- FLOATING CHAT WIDGET -->
    @include('partials.chat-widget', ['orderId' => $order->id])

    <script src="{{ asset('/js/smooth-navigation.js') }}"></script>
    @include('partials.theme-customizer')
</body>
</html>
