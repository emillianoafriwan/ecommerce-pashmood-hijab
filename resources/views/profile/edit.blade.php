<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - PASHMOOD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#FDFBF9] text-slate-900 min-h-screen pb-20">

    <nav class="glass-nav border-b border-rose-100/50 sticky top-0 z-50 p-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center px-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-slate-400 font-bold hover:text-rose-600 transition group text-sm">
                <span class="group-hover:-translate-x-1 transition-transform">←</span> <span class="hidden sm:inline">Kembali ke Dashboard</span>
            </a>
            <h1 class="font-extrabold text-xl tracking-tighter text-rose-800">PASHMOOD</h1>
            <div class="w-10 sm:w-32"></div> </div>
    </nav>

    <main class="max-w-4xl mx-auto py-10 px-4 sm:px-6 mt-4 space-y-10">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-rose-100 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Pengaturan Akun</h2>
        </div>

        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-slate-100">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-slate-100">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-slate-100">
            @include('profile.partials.delete-user-form')
        </div>

    </main>

</body>
</html>