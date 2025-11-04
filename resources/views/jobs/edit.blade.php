<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Lowongan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <input type="text" name="title" value="{{ old('title', $job->title) }}" placeholder="Judul Lowongan" class="form-control text-black mb-2">
                        <textarea name="description" placeholder="Deskripsi" class="form-control text-black mb-2">{{ old('description', $job->description) }}</textarea>
                        <input type="text" name="location" value="{{ old('location', $job->location) }}" placeholder="Lokasi" class="form-control text-black mb-2">
                        <input type="text" name="company" value="{{ old('company', $job->company) }}" placeholder="Nama Perusahaan" class="form-control text-black mb-2">
                        <input type="number" name="salary" value="{{ old('salary', $job->salary) }}" placeholder="Gaji" class="form-control text-black mb-2">
                        <select name="job_type" class="form-control text-black mb-2">
                            <option value="Full-time" {{ old('job_type', $job->job_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('job_type', $job->job_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        </select>
                        <input type="file" name="logo" class="form-control text-black mb-2">
                        @if($job->logo)
                        <img src="{{ asset('storage/' . $job->logo) }}" width="80" class="mb-2">
                        @endif
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>