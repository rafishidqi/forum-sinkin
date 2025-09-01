<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        // Mengambil semua kategori dari database
        $categories = Category::all();

        // Mengarahkan ke tampilan kategori dengan data kategori
        return view('admin.categories.categories', compact('categories')); // Menyesuaikan dengan nama file view yang benar
    }

    // Menampilkan form untuk membuat kategori baru
    public function create()
    {
        return view('admin.categories.create'); // Menyesuaikan dengan nama file view untuk create
    }

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'required|string',
        ]);

        // Menyimpan kategori baru
        Category::create($request->all());

        // Redirect ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit kategori
    public function edit(Category $category)
    {
        // Mengarahkan ke tampilan edit dengan data kategori
        return view('admin.categories.edit', compact('category'));
    }

    // Memperbarui kategori yang sudah ada
    public function update(Request $request, Category $category)
    {
        // Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'required|string',
        ]);

        // Memperbarui kategori
        $category->update($request->all());

        // Redirect ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        // Menghapus kategori
        $category->delete();

        // Redirect ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}