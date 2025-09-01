@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="min-h-screen bg-gray-900 p-6 font-poppins">

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
            <!-- Avatar Section -->
            <div class="flex justify-center mb-6">
                <img src="{{ $user->avatar }}" alt="Avatar" class="w-32 h-32 rounded-full border-4 border-blue-600">
            </div>

            <!-- User Information Section -->
            <div class="text-gray-300 text-lg space-y-4">
                <p><strong class="text-white">Nama:</strong> {{ $user->name }}</p>
                <p><strong class="text-white">Username:</strong> {{ $user->username }}</p>
                <p><strong class="text-white">Email:</strong> {{ $user->email }}</p>
                <p><strong class="text-white">Bio:</strong> {{ $user->bio ?? 'Tidak ada bio' }}</p>
                <p><strong class="text-white">Status:</strong> {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}</p>
                <p><strong class="text-white">Terdaftar pada:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                <p><strong class="text-white">Terakhir diperbarui:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <a href="{{ route('user.index') }}" class="text-blue-400 hover:text-blue-600 transition duration-300">Kembali ke daftar pengguna</a>

    </div>
@endsection
