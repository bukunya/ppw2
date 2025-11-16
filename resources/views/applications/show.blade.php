<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pelamar</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $application->user->name ?? '—' }}</h3>

                    <p><strong>Lowongan:</strong> {{ $application->job->title ?? '—' }}</p>
                    <p><strong>Perusahaan:</strong> {{ $application->job->company ?? '—' }}</p>
                    <p><strong>Status:</strong> {{ $application->status }}</p>

                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-700">Lihat CV</a>
                        <a href="{{ asset('storage/' . $application->cv) }}" download class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700">Download CV</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
