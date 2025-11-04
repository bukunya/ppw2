<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Lowongan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="title" placeholder="Judul Lowongan" class="form-control text-black mb-2">
                        <textarea name="description" placeholder="Deskripsi" class="form-control text-black mb-2"></textarea>
                        <input type="text" name="location" placeholder="Lokasi" class="form-control text-black mb-2">
                        <input type="text" name="company" placeholder="Nama Perusahaan" class="form-control text-black mb-2">
                        <input type="number" name="salary" placeholder="Gaji" class="form-control text-black mb-2">
                        <select name="job_type" class="form-control text-black mb-2">
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                        </select>
                        <input type="file" name="logo" class="form-control text-black mb-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>