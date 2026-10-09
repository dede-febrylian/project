<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Ruangan') }}
            </h2>
            <a href="{{ route('admin.ruang.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info ID --}}
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700">
                Mengedit ruangan <strong>{{ $ruang->nama_ruang }}</strong> 
                (ID: #{{ $ruang->id_ruang }})
            </div>

            <form action="{{ route('admin.ruang.update', $ruang->id_ruang) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ============================================ --}}
                {{-- SECTION: DATA RUANGAN                        --}}
                {{-- ============================================ --}}
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                        Data Ruangan
                    </h3>

                    <div class="space-y-4">

                        {{-- Nama Ruangan --}}
                        <div>
                            <label for="nama_ruang" class="block text-sm font-medium text-gray-700">
                                Nama Ruangan <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="nama_ruang" 
                                name="nama_ruang" 
                                value="{{ old('nama_ruang', $ruang->nama_ruang) }}"
                                required
                                placeholder="Contoh: Ruang Meeting A"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error('nama_ruang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kapasitas --}}
                        <div>
                            <label for="kapasitas_maksimal" class="block text-sm font-medium text-gray-700">
                                Kapasitas Maksimal <span class="text-red-500">*</span>
                            </label>
                            <div class="relative mt-1">
                                <input 
                                    type="number" 
                                    id="kapasitas_maksimal" 
                                    name="kapasitas_maksimal" 
                                    value="{{ old('kapasitas_maksimal', $ruang->kapasitas_maksimal) }}"
                                    min="1"
                                    required
                                    placeholder="Contoh: 20"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-16"
                                >
                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">
                                    orang
                                </span>
                            </div>
                            @error('kapasitas_maksimal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                                Deskripsi
                            </label>
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="3"
                                placeholder="Contoh: Ruangan ber-AC dengan proyektor dan whiteboard"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('deskripsi', $ruang->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status_ruang" class="block text-sm font-medium text-gray-700">
                                Status Ruangan <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="status_ruang" 
                                name="status_ruang" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="tersedia"    
                                    {{ old('status_ruang', $ruang->status_ruang) == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="maintenance" 
                                    {{ old('status_ruang', $ruang->status_ruang) == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance
                                </option>
                            </select>
                            @error('status_ruang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- SECTION: FASILITAS KURSI                     --}}
                {{-- ============================================ --}}
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                        Fasilitas Kursi
                    </h3>

                    @if(!$ruang->fasilitas)
                        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-700">
                            ⚠️ Ruangan ini belum memiliki data fasilitas. Isi form di bawah untuk menambahkannya.
                        </div>
                    @endif

                    <div class="space-y-4">

                        {{-- Jumlah Kursi --}}
                        <div>
                            <label for="jumlah_kursi" class="block text-sm font-medium text-gray-700">
                                Jumlah Kursi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative mt-1">
                                <input 
                                    type="number" 
                                    id="jumlah_kursi" 
                                    name="jumlah_kursi" 
                                    value="{{ old('jumlah_kursi', $ruang->fasilitas->jumlah_kursi ?? 0) }}"
                                    min="0"
                                    required
                                    placeholder="Contoh: 20"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-16"
                                >
                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm text-gray-500">
                                    kursi
                                </span>
                            </div>
                            @error('jumlah_kursi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Keterangan Kursi --}}
                        <div>
                            <label for="keterangan_kursi" class="block text-sm font-medium text-gray-700">
                                Keterangan Kursi
                            </label>
                            <input 
                                type="text" 
                                id="keterangan_kursi" 
                                name="keterangan_kursi" 
                                value="{{ old('keterangan_kursi', $ruang->fasilitas->keterangan ?? '') }}"
                                placeholder="Contoh: Kursi lipat, kursi putar, dll"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error('keterangan_kursi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- TOMBOL AKSI                                  --}}
                {{-- ============================================ --}}
                <div class="flex items-center justify-between">
                    {{-- Tombol Hapus (kiri) --}}
                    <button 
                        type="button"
                        onclick="if(confirm('Yakin ingin menghapus ruangan ini? Tindakan tidak dapat dibatalkan.')) { document.getElementById('delete-form').submit(); }"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-md hover:bg-red-100 transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Ruangan
                    </button>

                    {{-- Tombol Batal & Simpan (kanan) --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.ruang.index') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>

            {{-- Form Hapus Terpisah (di luar form utama) --}}
            <form id="delete-form" 
                  action="{{ route('admin.ruang.destroy', $ruang->id_ruang) }}" 
                  method="POST"
                  class="hidden">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>
</x-app-layout>