@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="min-h-screen bg-gray-900 p-6 font-poppins">

        <!-- Flash Message for Success -->
        @if(session('success'))
            <div class="bg-green-500/20 text-green-400 p-2 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl text-white">Daftar Pengguna</h2>
            </div>

            <!-- User Table -->
            <div class="overflow-x-auto max-h-96 custom-scrollbar">
                <table class="min-w-full table-auto border-collapse bg-gray-800 rounded-lg shadow-md">
                    <thead class="bg-gray-700 text-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Username</th>
                            <th class="px-6 py-3 text-left">Email</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-400">
                        @foreach($users as $user)
                        <tr class="border-b border-gray-600 hover:bg-gray-700 transition duration-200 cursor-pointer" onclick="window.location='{{ route('user.show', $user->id) }}'">
                            <td class="px-6 py-4">
                                <a href="{{ route('user.show', $user->id) }}" class="text-blue-400 hover:text-blue-500 transition-colors duration-200">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $user->username }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
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
@endsection
