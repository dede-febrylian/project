<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Ruangan') }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.ruang.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.ruang.edit', $ruang->id_ruang) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- ============================================ --}}
            {{-- CARD: INFO UTAMA RUANGAN                     --}}
            {{-- ============================================ --}}
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">

                {{-- Header Card dengan Nama & Status --}}
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wider opacity-80 mb-1">Ruangan</p>
                            <h3 class="text-2xl font-bold">{{ $ruang->nama_ruang }}</h3>
                        </div>
                        <div>
                            @php
                                $statusColor = match($ruang->status_ruang) {
                                    'tersedia'    => 'bg-green-500',
                                    'terpakai'    => 'bg-yellow-500',
                                    'maintenance' => 'bg-red-500',
                                    default       => 'bg-gray-500',
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur">
                                <span class="w-2 h-2 rounded-full {{ $statusColor }} mr-2"></span>
                                {{ ucfirst($ruang->status_ruang ?? 'tersedia') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Info Detail --}}
                <div class="divide-y divide-gray-100">

                    {{-- ID Ruangan --}}
                    <div class="grid grid-cols-3 gap-4 px-6 py-4">
                        <div class="text-sm font-medium text-gray-500">ID Ruangan</div>
                        <div class="col-span-2 text-sm text-gray-900 font-mono">
                            #{{ $ruang->id_ruang }}
                        </div>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="grid grid-cols-3 gap-4 px-6 py-4">
                        <div class="text-sm font-medium text-gray-500">Kapasitas Maksimal</div>
                        <div class="col-span-2">
                            <span class="inline-flex items-center gap-2 text-sm text-gray-900">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z"/>
                                </svg>
                                {{ $ruang->kapasitas_maksimal }} orang
                            </span>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="grid grid-cols-3 gap-4 px-6 py-4">
                        <div class="text-sm font-medium text-gray-500">Deskripsi</div>
                        <div class="col-span-2 text-sm text-gray-900">
                            {{ $ruang->deskripsi ?: '—' }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- ============================================ --}}
            {{-- CARD: FASILITAS KURSI                        --}}
            {{-- ============================================ --}}
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        Fasilitas Kursi
                    </h3>
                </div>

                @if($ruang->fasilitas)
                    <div class="divide-y divide-gray-100">
                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Jumlah Kursi</div>
                            <div class="col-span-2 text-sm text-gray-900">
                                {{ $ruang->fasilitas->jumlah_kursi }} kursi
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 px-6 py-4">
                            <div class="text-sm font-medium text-gray-500">Keterangan</div>
                            <div class="col-span-2 text-sm text-gray-900">
                                {{ $ruang->fasilitas->keterangan ?: '—' }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center gap-2 text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-sm italic">Belum ada data fasilitas</p>
                        </div>
                    </div>
                @endif
            </div>
            </div>

        </div>
    </div>
</x-app-layout>