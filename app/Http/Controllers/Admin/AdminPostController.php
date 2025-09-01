<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    // Menampilkan daftar postingan
    public function index()
    {
        // Eager load user dan category untuk setiap postingan agar bisa diakses di view
        $posts = Post::with(['user', 'category'])->get();
        return view('admin.post.post', compact('posts')); // Tampilkan tampilan dengan data postingan
    }

    // Menampilkan detail postingan
    public function show($id)
    {
        // Mengambil postingan beserta relasi yang diperlukan:
        // - user: untuk informasi pembuat postingan
        // - category: untuk informasi kategori postingan
        // - comments: HANYA komentar level teratas (parent_id IS NULL)
        //   - Di dalam comments, juga eager load user yang membuat komentar
        //   - Dan eager load replies (balasan) untuk setiap komentar parent
        //     - Di dalam replies, juga eager load user yang membuat balasan
        $post = Post::with([
            'user',
            'category',
            'comments' => function ($query) {
                $query->whereNull('parent_id') // Filter hanya komentar parent
                    ->with(['user', 'replies' => function ($replyQuery) {
                        $replyQuery->with('user') // Eager load user untuk balasan
                            ->orderBy('created_at', 'asc'); // Urutkan balasan
                    }])
                    ->orderBy('created_at', 'asc'); // Urutkan komentar parent
            }
        ])->findOrFail($id); // Mencari postingan berdasarkan ID

        return view('admin.post.show', compact('post')); // Tampilkan tampilan detail postingan
    }

    // Membanned postingan
    public function ban($id)
    {
        $post = Post::findOrFail($id); // Mencari postingan berdasarkan ID
        $post->is_banned = true; // Tandai sebagai dibanned
        $post->save(); // Simpan perubahan

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dibanned.');
    }

    // Menghapus postingan
    public function destroy($id)
    {
        $post = Post::findOrFail($id); // Mencari postingan berdasarkan ID
        $post->delete(); // Hapus postingan

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus.');
    }

    // Metode untuk menampilkan komentar dari suatu postingan (jika Anda memiliki halaman komentar terpisah)
    public function showComments($id)
    {
        // Mengambil postingan beserta komentar dan balasannya
        // Logika ini sudah cukup baik jika ini memang halaman terpisah untuk semua komentar
        $post = Post::with([
            'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->with(['user', 'replies' => function ($replyQuery) {
                        $replyQuery->with('user')->orderBy('created_at', 'asc');
                    }])
                    ->orderBy('created_at', 'asc');
            }
        ])->findOrFail($id);

        // Menampilkan halaman komentar untuk postingan
        return view('admin.comment.comment', compact('post'));
    }

    public function restore($id)
    {
        $post = Post::findOrFail($id); // Mencari postingan berdasarkan ID
        $post->is_published = 1; // Ubah status menjadi dipublikasikan
        $post->save(); // Simpan perubahan

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil di-restore.');
    }

    public function destroyComment(Comment $comment) // Nama metode berbeda agar tidak konflik dengan destroy Post
    {
        try {
            // Jika Anda ingin "soft delete" (menandai sebagai dihapus)
            // $comment->is_deleted = 1;
            // $comment->save();
            // return redirect()->back()->with('success', 'Komentar berhasil ditandai sebagai dihapus.');

            // Jika Anda ingin "hard delete" (menghapus permanen)
            $comment->delete();

            return redirect()->back()->with('success', 'Komentar berhasil dihapus secara permanen.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus komentar: ' . $e->getMessage());
        }
    }
}
