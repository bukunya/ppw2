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
                    <a href="{{ route('jobs.create') }}" class="border border-white hover:bg-white hover:text-black px-2 py-1 rounded-md mb-3">Tambah Lowongan</a>
                    @foreach ($jobs as $job)
                    <div class="border rounded-xl border-white my-4 p-4 flex flex-row items-center justify-between">
                        <div>
                            <h5 class="text-4xl font-bold">{{ $job->title }}</h5>
                            <p>Perusahaan: {{ $job->company }}</p>
                            <p>Lokasi: {{ $job->location }}</p>
                            <p>Gaji: {{ 'Rp ' . number_format($job->salary, 0, ',', '.') }}</p>
                            <p class="mb-4">Jenis: {{ $job->job_type }}</p>
                            <button class="border border-white hover:bg-white hover:text-black px-2 py-1 rounded-md"><a href="{{ route('jobs.edit', $job->id) }}">Edit</a></button>
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="border border-white hover:bg-white hover:text-black px-2 py-1 rounded-md" onclick="return confirm('Hapus data?')">Hapus</button>
                            </form>
                        </div>
                        <img src="{{ asset('storage/' . $job->logo) }}" class="max-w-32 max-h-32 object-contain">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>