<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard Status Ruangan Real-time') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Lihat ketersediaan ruangan saat ini — 
                    <span class="font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </p>
            </div>
            @auth
                <a href="{{ route('reservasi.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Reservasi
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @forelse($ruangans as $ruang)
                    @php
                        $statusConfig = match($ruang->status_realtime) {
                            'tersedia' => [
                                'label' => 'Tersedia',
                                'badge' => 'bg-green-100 text-green-800',
                                'dot'   => 'bg-green-500',
                            ],
                            'digunakan' => [
                                'label' => 'Sedang Digunakan',
                                'badge' => 'bg-yellow-100 text-yellow-800',
                                'dot'   => 'bg-yellow-500',
                            ],
                            'maintenance' => [
                                'label' => 'Maintenance',
                                'badge' => 'bg-red-100 text-red-800',
                                'dot'   => 'bg-red-500',
                            ],
                            default => [
                                'label' => 'Unknown',
                                'badge' => 'bg-gray-100 text-gray-800',
                                'dot'   => 'bg-gray-500',
                            ],
                        };
                    @endphp

                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition-shadow overflow-hidden flex flex-col">

                        <div class="relative h-44 overflow-hidden bg-gray-100">
                            @if($ruang->gambar)
                                <img src="{{ asset('storage/' . $ruang->gambar) }}" 
                                     alt="{{ $ruang->nama_ruang }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                {{-- Placeholder kalau tidak ada gambar --}}
                                <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            @endif

                            {{-- Status Badge Overlay --}}
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold shadow {{ $statusConfig['badge'] }}">
                                    <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }} animate-pulse"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex-1">
                            <h3 class="text-lg font-bold text-gray-800 truncate">
                                {{ $ruang->nama_ruang }}
                            </h3>
                            
                            @if($ruang->deskripsi)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                    {{ Str::limit($ruang->deskripsi, 80) }}
                                </p>
                            @endif

                            <div class="mt-3 space-y-2">
                                {{-- Kapasitas --}}
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z"/>
                                    </svg>
                                    <span>Kapasitas: <strong>{{ $ruang->kapasitas_maksimal }}</strong> orang</span>
                                </div>

                                {{-- Fasilitas Kursi --}}
                                @if($ruang->fasilitas)
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                        </svg>
                                        <span>Kursi: <strong>{{ $ruang->fasilitas->jumlah_kursi }}</strong>
                                            @if($ruang->fasilitas->keterangan)
                                                <span class="text-gray-400">({{ $ruang->fasilitas->keterangan }})</span>
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- ============================================ --}}
                        {{-- ACTION                                       --}}
                        {{-- ============================================ --}}
                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                            @auth
                                <a href="{{ route('reservasi.create') }}" 
                                   class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    Reservasi
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    Login untuk reservasi
                                </a>
                            @endauth
                        </div>

                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-lg shadow p-12 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-500">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-base font-medium">Belum ada ruangan terdaftar</p>
                                <p class="text-sm text-gray-400">
                                    Hubungi admin untuk menambahkan ruangan
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>