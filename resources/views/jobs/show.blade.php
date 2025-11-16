<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('jobs.index') }}" class="border border-white hover:bg-white hover:text-black px-2 py-1 rounded-md">
                            ← Kembali
                        </a>
                    </div>

                    <div class="flex flex-row items-start justify-between gap-6">
                        <div class="flex-1">
                            <h1 class="text-4xl font-bold mb-4">{{ $job->title }}</h1>
                            
                            <div class="mb-4">
                                <span class="inline-flex items-center rounded-md bg-blue-100 dark:bg-blue-900 px-3 py-1 text-sm font-medium text-blue-800 dark:text-blue-200">
                                    {{ $job->job_type }}
                                </span>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div>
                                    <span class="font-semibold">Perusahaan:</span>
                                    <span>{{ $job->company }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold">Lokasi:</span>
                                    <span>{{ $job->location }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold">Gaji:</span>
                                    <span>{{ 'Rp ' . number_format($job->salary, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-lg mb-2">Deskripsi Pekerjaan:</h3>
                                <p class="whitespace-pre-line">{{ $job->description }}</p>
                            </div>

                            @auth
                                @if(auth()->user()->role !== 'admin')
                                    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <h3 class="font-semibold text-lg mb-3">Lamar Pekerjaan Ini</h3>
                                        <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="cv" class="block mb-2">Upload CV (PDF, max 2MB)</label>
                                                <input type="file" name="cv" id="cv" required class="block w-full text-sm">
                                                @error('cv') 
                                                    <span class="text-red-600 text-sm">{{ $message }}</span> 
                                                @enderror
                                            </div>
                                            <button type="submit" class="border border-white hover:bg-white hover:text-black px-4 py-2 rounded-md">
                                                Kirim Lamaran
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div class="mt-6 p-4 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                    <p class="text-yellow-800 dark:text-yellow-200">
                                        Silakan <a href="{{ route('login') }}" class="underline font-semibold">login</a> untuk melamar pekerjaan ini.
                                    </p>
                                </div>
                            @endauth
                        </div>

                        @if($job->logo)
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $job->logo) }}" alt="{{ $job->company }}" class="max-w-48 max-h-48 object-contain rounded-lg shadow-md">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
