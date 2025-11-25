<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ANC Reminder') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|inter:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .bg-grid-pattern {
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="antialiased text-slate-800 bg-white selection:bg-primary-500 selection:text-white" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navigation -->
    <nav :class="{ 'bg-white/80 backdrop-blur-md shadow-sm': scrolled, 'bg-transparent': !scrolled }" class="fixed w-full z-50 transition-all duration-300 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <!-- Logo Icon -->
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        A
                    </div>
                    <span class="font-display font-bold text-xl tracking-tight text-slate-900">ANC Reminder</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-slate-600 hover:text-primary-600 transition-colors">Fitur</a>
                    <a href="#about" class="text-sm font-medium text-slate-600 hover:text-primary-600 transition-colors">Tentang</a>
                    <a href="/admin/login" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-sm font-medium hover:bg-slate-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Masuk Admin
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-slate-600 hover:text-slate-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-[0.4] -z-10"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-purple-100 rounded-full blur-3xl opacity-50 animate-pulse" style="animation-delay: 1s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-3xl mx-auto" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-sm font-medium mb-6 border border-primary-100">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                    </span>
                    Sistem Pemantauan Kehamilan Cerdas
                </div>
                
                <h1 x-show="show" x-transition:enter="transition ease-out duration-1000 delay-200" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="text-5xl md:text-7xl font-display font-bold text-slate-900 tracking-tight mb-8 leading-tight">
                    Pantau Kesehatan Ibu <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-purple-600">Demi Generasi Emas</span>
                </h1>
                
                <p x-show="show" x-transition:enter="transition ease-out duration-1000 delay-400" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="text-xl text-slate-600 mb-10 leading-relaxed">
                    Aplikasi terpadu untuk memantau kunjungan ANC (Antenatal Care), mengirim pengingat otomatis via WhatsApp, dan memastikan kesehatan ibu hamil terjaga.
                </p>
                
                <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-600" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="/admin" class="w-full sm:w-auto px-8 py-4 rounded-full bg-primary-600 text-white font-semibold text-lg hover:bg-primary-700 transition-all shadow-lg hover:shadow-primary-500/30 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        Mulai Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white text-slate-700 font-semibold text-lg border border-slate-200 hover:border-primary-200 hover:bg-primary-50 transition-all flex items-center justify-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Hero Image/Illustration -->
            <div class="mt-20 relative max-w-5xl mx-auto" x-data="{ show: false }" x-init="setTimeout(() => show = true, 800)">
                <div x-show="show" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative rounded-2xl bg-slate-900/5 p-2 ring-1 ring-inset ring-slate-900/10 lg:-m-4 lg:rounded-3xl lg:p-4">
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden border border-slate-200 aspect-[16/9] flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100">
                        <!-- Placeholder for App Screenshot -->
                        <div class="text-center p-10">
                            <div class="w-20 h-20 bg-primary-100 text-primary-600 rounded-2xl mx-auto flex items-center justify-center mb-4 animate-float">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-display font-bold text-slate-800">Dashboard Monitoring</h3>
                            <p class="text-slate-500 mt-2">Visualisasi data pasien dan jadwal kunjungan dalam satu tampilan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-primary-600 font-semibold tracking-wide uppercase text-sm mb-3">Fitur Unggulan</h2>
                <h3 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-4">Semua yang Anda Butuhkan</h3>
                <p class="text-lg text-slate-600">Kelola data ibu hamil dan jadwal kunjungan dengan lebih mudah dan efisien.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-primary-500/10 transition-all duration-300 border border-slate-100 hover:border-primary-100">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Manajemen Pasien</h4>
                    <p class="text-slate-600 leading-relaxed">Pencatatan data ibu hamil yang lengkap, riwayat kunjungan, dan status kesehatan dalam satu database terpusat.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-primary-500/10 transition-all duration-300 border border-slate-100 hover:border-primary-100">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Pengingat Otomatis</h4>
                    <p class="text-slate-600 leading-relaxed">Kirim notifikasi WhatsApp otomatis kepada pasien untuk jadwal kunjungan berikutnya agar tidak terlewat.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-primary-500/10 transition-all duration-300 border border-slate-100 hover:border-primary-100">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Laporan & Analitik</h4>
                    <p class="text-slate-600 leading-relaxed">Pantau kinerja layanan ANC dengan dashboard analitik yang informatif dan laporan yang mudah diunduh.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white font-bold">A</div>
                        <span class="font-display font-bold text-xl text-white">ANC Reminder</span>
                    </div>
                    <p class="text-sm text-slate-400">Sistem Informasi Kesehatan Ibu & Anak</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Contact</a>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-8 text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} ANC Reminder App. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
