@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Total Pengguna Card -->
    <a href="{{ route('user.index') }}" class="block bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center mb-2">
            <i class="fas fa-users text-3xl text-blue-400 mr-4"></i>
            <h2 class="text-sm font-medium text-gray-400">Total Pengguna</h2>
        </div>
        <p class="text-2xl font-bold text-blue-400">{{ $userCount }}</p>
    </a>

    <!-- Total Postingan Card -->
    <a href="{{ route('admin.posts.index') }}" class="block bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center mb-2">
            <i class="fas fa-newspaper text-3xl text-green-400 mr-4"></i>
            <h2 class="text-sm font-medium text-gray-400">Total Postingan</h2>
        </div>
        <p class="text-2xl font-bold text-green-400">{{ $postCount }}</p>
    </a>

    <!-- Total Kategori Card -->
    <a href="{{ route('categories.index') }}" class="block bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center mb-2">
            <i class="fas fa-th-list text-3xl text-purple-400 mr-4"></i>
            <h2 class="text-sm font-medium text-gray-400">Total Kategori</h2>
        </div>
        <p class="text-2xl font-bold text-purple-400">{{ $categoryCount }}</p>
    </a>

    <!-- Total Laporan Card -->
    <a href="{{ route('admin.reports.index') }}" class="block bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
        <div class="flex items-center mb-2">
            <i class="fas fa-flag text-3xl text-red-400 mr-4"></i>
            <h2 class="text-sm font-medium text-gray-400">Total Laporan</h2>
        </div>
        <p class="text-2xl font-bold text-red-400">{{ $reportCount }}</p>
    </a>
</div>
@endsection