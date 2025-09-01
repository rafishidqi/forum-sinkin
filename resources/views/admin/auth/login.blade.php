@extends('admin.layouts.admin-auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 font-poppins">
    <div class="w-full max-w-sm bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">Admin Login</h2>

        @if (session('error'))
            <div class="bg-red-500/20 text-red-400 p-2 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-300 mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="mb-6">
                <label class="block text-sm text-gray-300 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors duration-200">
                Login
            </button>
        </form>
    </div>
</div>
@endsection
