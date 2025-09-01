@extends('admin.layouts.app')

@section('title', 'Category Management')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 font-poppins">
    <h1 class="text-3xl font-bold text-white mb-6">Tambah Kategori</h1>

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-2xl mx-auto">

            <!-- Nama Kategori -->
            <div class="mb-4">
                <label class="block text-sm text-gray-300 mb-1">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    class="w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-4">
                <label class="block text-sm text-gray-300 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" required 
                    class="w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('slug')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm text-gray-300 mb-1">Deskripsi</label>
                <textarea name="description" required 
                    class="w-full px-4 py-2 border border-gray-600 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
