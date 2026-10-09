<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Reservasi Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('reservasi.store') }}" method="POST">
                    @csrf

                    {{-- ===================================== --}}
                    {{-- Pilih Ruangan --}}
                    {{-- ===================================== --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pilih Ruangan</label>
                        <select name="id_ruang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangans as $ruang)
                            <option value="{{ $ruang->id_ruang }}">
                                {{ $ruang->nama_ruang }} (Kapasitas: {{ $ruang->kapasitas_maksimal }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Pengaju</label>
                            <input
                                type="text"
                                name="nama_pengaju"
                                value="{{ auth()->user()->name }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asal Unit / Divisi</label>
                            <input
                                type="text"
                                name="asal_unit_divisi"
                                value="{{ auth()->user()->unit ?? 'Umum' }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jam Mulai / Selesai</label>
                            <div class="flex gap-1">
                                <input type="time" name="jam_mulai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <input type="time" name="jam_selesai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 flex items-center">
                        <input type="checkbox" name="hubungi_leader_cs" value="1" id="cs" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                        <label for="cs" class="ml-2 text-sm text-gray-600">Perlu bantuan CS untuk tata letak ruangan?</label>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                        Kirim Pengajuan Reservasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>