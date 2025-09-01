@extends('admin.layouts.app')

@section('title', 'Category Management')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 font-poppins">

    <h1 class="text-3xl font-bold text-white mb-6">Kategori Diskusi</h1>

    <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl text-white">Daftar Kategori</h2>
            <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 transform hover:scale-105">
                Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-400 p-2 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Kategori -->
        <div class="overflow-x-auto max-h-96 custom-scrollbar">
            <table class="min-w-full table-auto border-collapse bg-gray-800 rounded-lg shadow-md">
                <thead class="bg-gray-700 text-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Deskripsi</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400">
                    @foreach($categories as $category)
                    <tr class="border-b border-gray-600 hover:bg-gray-700 transition duration-200">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $category->name }}</td>
                        <td class="px-6 py-4">{{ $category->description }}</td>
                        <td class="px-6 py-4 flex space-x-4">
                            <!-- Edit Button -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-yellow-400 hover:text-yellow-500 transition-colors duration-200">Edit</a>

                            <!-- Delete Button with confirmation -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-500 transition-colors duration-200 cursor-pointer">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    /* Scrollbar Styles */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #2d2d2d; /* Track color */
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4A5568; /* Scrollbar thumb color */
        border-radius: 4px;
        transition: background 0.3s ease;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #2b2b2b; /* Scrollbar thumb color on hover */
    }

    .custom-scrollbar::-webkit-scrollbar-corner {
        background: #2d2d2d; /* Corner color */
    }
</style>

<script>
    // JavaScript for confirming delete action
    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus kategori ini?");
    }
</script>

@endsection
