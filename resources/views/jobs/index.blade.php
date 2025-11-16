<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Lowongan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div class="flex items-center gap-2 mb-3">
                                <a href="{{ route('jobs.create') }}" class="border border-white hover:bg-white hover:text-black px-2 py-1 rounded-md">Tambah Lowongan</a>

                                <a href="{{ route('jobs.import.template') }}" class="border border-green-500 text-green-500 hover:bg-green-500 hover:text-white px-2 py-1 rounded-md">
                                    Download Template Import
                                </a>

                                <form action="{{ route('jobs.import') }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
                                    @csrf
                                    <input type="file" name="file" required class="text-sm">
                                    <button type="submit" class="btn btn-info border border-white hover:bg-white hover:text-black px-2 py-1 rounded-md">Import Lowongan</button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @foreach ($jobs as $job)
                    <div class="border rounded-xl border-white my-4 p-4 flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <h5 class="text-4xl font-bold">{{ $job->title }}</h5>
                            <p>Perusahaan: {{ $job->company }}</p>
                            <p>Lokasi: {{ $job->location }}</p>
                            <p>Gaji: {{ 'Rp ' . number_format($job->salary, 0, ',', '.') }}</p>
                            <p class="mb-4">Jenis: {{ $job->job_type }}</p>
                            
                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ route('jobs.show', $job->id) }}" class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white px-3 py-1 rounded-md">
                                    Lihat Detail
                                </a>

                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('jobs.edit', $job->id) }}" class="border border-white hover:bg-white hover:text-black px-2 py-1 rounded-md">Edit</a>
                                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white px-2 py-1 rounded-md" onclick="return confirm('Hapus data?')">Hapus</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        @if($job->logo)
                            <img src="{{ asset('storage/' . $job->logo) }}" class="max-w-32 max-h-32 object-contain" alt="{{ $job->company }}">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>