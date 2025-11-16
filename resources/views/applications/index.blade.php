<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pelamar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-lg font-medium text-gray-700">Kelola daftar pelamar yang tersedia.</p>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('applications.export') }}" class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                Export Semua
                            </a>
                            
                            <div class="relative inline-block">
                                <button onclick="document.getElementById('exportDropdown').classList.toggle('hidden')" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                    Export Per Lowongan ▼
                                </button>
                                <div id="exportDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-10 max-h-64 overflow-y-auto">
                                    @php
                                        $jobs = \App\Models\JobVacancy::all();
                                    @endphp
                                    @foreach($jobs as $job)
                                        <a href="{{ route('applications.export', ['job_id' => $job->id]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ $job->title }} - {{ $job->company }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama Pelamar</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Lowongan</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">CV</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($applications as $app)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $app->user->name ?? '—' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $app->job->title ?? '—' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            @if($app->cv)
                                                <div class="flex gap-2">
                                                    <a href="{{ asset('storage/' . $app->cv) }}" target="_blank" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-700">Lihat CV</a>
                                                    <a href="{{ asset('storage/' . $app->cv) }}" download class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700">Download CV</a>
                                                </div>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            @if($app->status === 'Pending')
                                                <span class="inline-flex items-center rounded-md bg-yellow-100 text-yellow-700 px-2 py-1 text-xs font-medium">Pending</span>
                                            @elseif($app->status === 'Accepted')
                                                <span class="inline-flex items-center rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-medium">Accepted</span>
                                            @elseif($app->status === 'Rejected')
                                                <span class="inline-flex items-center rounded-md bg-red-100 text-red-700 px-2 py-1 text-xs font-medium">Rejected</span>
                                            @else
                                                <span class="inline-flex items-center rounded-md bg-gray-100 text-gray-700 px-2 py-1 text-xs font-medium">{{ $app->status }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Accepted">
                                                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700">Terima</button>
                                                </form>

                                                <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700">Tolak</button>
                                                </form>

                                                <form action="{{ route('applications.destroy', $app->id) }}" method="POST" onsubmit="return confirm('Hapus pelamar ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-gray-600 px-3 py-1 text-xs font-semibold text-white hover:bg-gray-700">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada pelamar yang daftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
