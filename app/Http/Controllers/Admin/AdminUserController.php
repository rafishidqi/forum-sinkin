<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::all(); // Mengambil semua data pengguna
        return view('admin.user.user', compact('users')); // Mengirim data pengguna ke view user.index
    }

    // Menampilkan detail pengguna berdasarkan ID
    public function show($id)
    {
        $user = User::findOrFail($id); // Mencari pengguna berdasarkan ID atau menampilkan error jika tidak ditemukan
        return view('admin.user.userdetail', compact('user')); // Mengirim data pengguna ke view userdetail
    }
}