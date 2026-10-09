<!-- resources/views/layouts/sidebar.blade.php -->
<aside 
    x-data="{ 
        open: false, 
        settingOpen: false 
    }" 
    class="bg-gray-900 text-white w-full md:w-64 md:min-h-screen flex-shrink-0"
>
    <!-- Header / Logo + Toggle Mobile -->
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-800 md:justify-center">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-lg font-bold">
            <x-application-logo class="block h-8 w-auto fill-current text-white" />
            <span class="md:hidden lg:inline">NIGHT</span>
        </a>

        <!-- Toggle Button (Mobile Only) -->
        <button 
            @click="open = !open" 
            class="md:hidden text-gray-300 hover:text-white focus:outline-none"
            aria-label="Toggle Sidebar"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Menu Navigation -->
    <nav 
        x-show="open || window.innerWidth >= 768" 
        x-transition 
        class="px-2 py-4 space-y-1 overflow-y-auto"
    >
        <p class="px-4 pt-2 pb-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
            Menu Utama
        </p>
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium transition
                  {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>{{ __('Dashboard') }}</span>
        </a>

        {{-- Jadwal Reservasi --}}
        <a href="{{ route('reservasi.public') }}" 
           class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium transition
                  {{ request()->routeIs('reservasi.public') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ __('Jadwal Reservasi') }}</span>
        </a>
        @auth
            <p class="px-4 pt-4 pb-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Reservasi Saya
            </p>

            <a href="{{ route('reservasi.create') }}" 
               class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('reservasi.create') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 4v16m8-8H4"/>
                </svg>
                <span>{{ __('Buat Reservasi') }}</span>
            </a>
        @endauth


        {{-- SECTION: ADMIN --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <p class="px-4 pt-4 pb-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Panel Admin
                </p>

                {{-- Riwayat Reservasi --}}
                <a href="{{ route('admin.riwayat.index') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.riwayat.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span>{{ __('Riwayat Reservasi') }}</span>
                </a>

                {{-- Kelola Ruangan --}}
                <a href="{{ route('admin.ruang.index') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.ruang.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>{{ __('Kelola Ruangan') }}</span>
                </a>

                
            @endif
        @endauth


        {{-- ============================= --}}
        {{-- SECTION: SETTING (Dropdown) --}}
        {{-- ============================= --}}
        <div class="border-t border-gray-800 my-3"></div>

        <div x-data="{ settingOpen: false }">
            {{-- Tombol Setting (Dropdown Trigger) --}}
            <button 
                @click="settingOpen = !settingOpen"
                class="w-full flex items-center justify-between gap-3 px-4 py-2 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs('profile.*') || request()->routeIs('login') || request()->routeIs('register') 
                            ? 'bg-gray-800 text-white' 
                            : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ __('Setting') }}</span>
                </div>

                {{-- Chevron icon --}}
                <svg 
                    class="w-4 h-4 transition-transform duration-200"
                    :class="{ 'rotate-180': settingOpen }"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown Items --}}
            <div 
                x-show="settingOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="mt-1 ml-4 pl-3 border-l-2 border-gray-700 space-y-1"
            >
                @auth
                    {{-- Opsi 1: Profil (Hanya muncul kalau sudah login) --}}
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('profile.edit') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ __('Profil') }}</span>
                    </a>

                    {{-- Opsi 2: Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-400 hover:bg-red-600 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>{{ __('Log Out') }}</span>
                        </a>
                    </form>
                @else
                    {{-- Opsi 1: Login (guest) --}}
                    <a href="{{ route('login') }}" 
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('login') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>{{ __('Login') }}</span>
                    </a>

                    {{-- Info kecil: register lewat login --}}
                    <p class="px-3 pt-1 text-xs text-gray-500 italic">
                        Belum punya akun? Klik Login, lalu pilih "Register".
                    </p>
                @endauth
            </div>
        </div>
    </nav>
</aside>