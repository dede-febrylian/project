<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Ruangan Baru') }}
            </h2>
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

            <form action="{{ route('admin.ruang.store') }}" method="POST">
                @csrf
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
                        Data Ruangan
                    </h3>

                    <div class="space-y-4">

                        <div>
                            <label for="nama_ruang" class="block text-sm font-medium text-gray-700">
                                Nama Ruangan 
                            </label>
                            <input 
                                type="text" 
                                id="nama_ruang" 
                                name="nama_ruang" 
                                value="{{ old('nama_ruang') }}"
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
                                Kapasitas Maksimal 
                            </label>
                            <div class="relative mt-1">
                                <input 
                                    type="number" 
                                    id="kapasitas_maksimal" 
                                    name="kapasitas_maksimal" 
                                    value="{{ old('kapasitas_maksimal') }}"
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
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status_ruang" class="block text-sm font-medium text-gray-700">
                                Status Ruangan 
                            </label>
                            <select 
                                id="status_ruang" 
                                name="status_ruang" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="tersedia"    {{ old('status_ruang') == 'tersedia'    ? 'selected' : '' }}>Tersedia</option>
                                <option value="maintenance" {{ old('status_ruang') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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

                    <div class="space-y-4">

                        {{-- Jumlah Kursi --}}
                        <div>
                            <label for="jumlah_kursi" class="block text-sm font-medium text-gray-700">
                                Jumlah Kursi 
                            </label>
                            <div class="relative mt-1">
                                <input 
                                    type="number" 
                                    id="jumlah_kursi" 
                                    name="jumlah_kursi" 
                                    value="{{ old('jumlah_kursi') }}"
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
                                value="{{ old('keterangan_kursi') }}"
                                placeholder="Contoh: Kursi lipat, kursi putar, dll"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                            @error('keterangan_kursi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.ruang.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Ruangan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>