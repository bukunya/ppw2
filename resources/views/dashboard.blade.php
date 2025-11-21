<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    @if(auth()->user()->role === 'admin')
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-4">Notifikasi Terbaru</h3>
                            @if($notifications->count() > 0)
                                <ul class="space-y-2">
                                    @foreach($notifications as $notification)
                                        <li class="p-3 bg-gray-100 dark:bg-gray-700 rounded">
                                            <p>{{ $notification->data['message'] }}</p>
                                            <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Tidak ada notifikasi baru.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
