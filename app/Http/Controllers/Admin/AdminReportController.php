<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User; // Pastikan ini di-import
use App\Models\Post; // Pastikan ini di-import
use App\Models\Comment; // Pastikan ini di-import

class AdminReportController extends Controller
{
    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua laporan dan eager load relasi 'user'
        // Jika Anda ingin menampilkan detail post/comment di kartu laporan,
        // Anda juga bisa menambahkan 'post' dan 'comment' di with() di sini.
        // Untuk performa, disarankan eager loading.
        $reports = Report::with(['user'])->latest()->get(); // Mengurutkan berdasarkan yang terbaru

        // Jika Anda ingin paginasi, gunakan ini:
        // $reports = Report::with(['user'])->latest()->paginate(10);

        return view('admin.report.report', compact('reports'));
    }

    /**
     * Display the specified report.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\View\View
     */
    public function show(Report $report)
    {
        // Load relasi user, post, dan comment untuk detail laporan
        $report->load(['user', 'post', 'comment']);
        return view('admin.report.show', compact('report'));
    }

    /**
     * Update the status of the specified report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @param  string  $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Report $report, string $status)
    {
        // Validasi status yang diterima
        // Pastikan 'reviewed' ada di sini, dan 'rejected' dihapus jika tidak lagi digunakan
        $validStatuses = ['pending', 'reviewed', 'resolved']; // <-- PERBAIKAN DI SINI

        if (!in_array($status, $validStatuses)) {
            return back()->with('error', 'Status tidak valid.');
        }

        $report->status = $status;

        // Tambahkan pengecekan jika save() gagal
        if ($report->save()) {
            return redirect()->route('admin.reports.show', $report->id)
                ->with('success', 'Status laporan berhasil diperbarui menjadi ' . ucfirst($status) . '.');
        } else {
            return back()->with('error', 'Gagal memperbarui status laporan. Silakan coba lagi.');
        }
    }
    public function destroy(Report $report)
    {
        try {
            $report->delete(); // Hapus laporan

            return redirect()->route('admin.reports.index')->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani kesalahan jika penghapusan gagal
            return redirect()->back()->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }
}
