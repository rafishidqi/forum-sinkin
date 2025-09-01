@extends('admin.layouts.app') {{-- Pastikan ini sesuai dengan nama layout admin Anda --}}

@section('title', 'Detail Laporan')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 font-poppins">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Detail Laporan</h1>
        <!-- Kembali Button -->
        <a href="{{ route('admin.reports.index') }}" class="mt-6 inline-block text-blue-500 hover:text-blue-400">
            <button class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </a>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">

        <!-- Header Informasi Laporan -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-gray-400">Pelapor: u/{{ $report->user->username ?? 'N/A' }}</span>
            <span class="text-sm text-gray-400">ID Laporan: {{ $report->id }}</span>
        </div>

        <!-- Tipe Laporan (Post atau Komentar) -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-white mb-2">Target Laporan:</h2>
            @if ($report->post_id)
                <p class="text-white text-lg font-semibold">Postingan (ID: {{ $report->post_id }})</p>
                @if ($report->post)
                    <p class="text-gray-300 text-sm">Judul Postingan: {{ $report->post->title }}</p>
                    <p class="text-gray-400 text-xs">Konten: {{ Str::limit($report->post->content, 200) }}</p>
                    {{-- Opsional: Link ke detail postingan --}}
                    <a href="{{ route('admin.posts.show', $report->post_id) }}" class="text-blue-400 hover:text-blue-500 text-sm mt-1 block">Lihat Postingan</a>
                @else
                    <p class="text-gray-400 text-sm">Postingan tidak ditemukan.</p>
                @endif
            @elseif ($report->comment_id)
                <p class="text-white text-lg font-semibold">Komentar (ID: {{ $report->comment_id }})</p>
                @if ($report->comment)
                    <p class="text-gray-300 text-sm">Konten Komentar: {{ Str::limit($report->comment->content, 200) }}</p>
                    {{-- Opsional: Link ke detail postingan yang berisi komentar --}}
                    @if ($report->comment->post_id)
                        <a href="{{ route('admin.posts.show', $report->comment->post_id) }}#comment-{{ $report->comment_id }}" class="text-blue-400 hover:text-blue-500 text-sm mt-1 block">Lihat Komentar di Postingan</a>
                    @endif
                @else
                    <p class="text-gray-400 text-sm">Komentar tidak ditemukan.</p>
                @endif
            @else
                <p class="text-white text-lg font-semibold">Tipe Target Tidak Diketahui</p>
            @endif
        </div>

        <!-- Alasan Laporan -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-white mb-2">Alasan Laporan:</h2>
            <p class="text-gray-300">{{ $report->reason }}</p>
        </div>

        <!-- Status Laporan -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-white mb-2">Status:</h2>
            @if ($report->status == 'pending')
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Pending
                </span>
            @elseif ($report->status == 'resolved')
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Selesai
                </span>
            @elseif ($report->status == 'reviewed') {{-- Diubah dari 'rejected' --}}
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"> {{-- Warna baru untuk 'reviewed' --}}
                    Direview
                </span>
            @else
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                    {{ ucfirst($report->status) }}
                </span>
            @endif
        </div>

        <!-- Timestamps -->
        <div class="mb-4 text-sm text-gray-500">
            <p>Dibuat pada: {{ $report->created_at->format('d M Y H:i') }}</p>
            <p>Diperbarui pada: {{ $report->updated_at->format('d M Y H:i') }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4 mt-6">
            <!-- Tandai Selesai Button -->
            <form action="{{ route('admin.reports.update_status', ['report' => $report->id, 'status' => 'resolved']) }}" method="POST" class="inline-block" id="resolve-form-{{ $report->id }}">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Tandai Selesai
                </button>
            </form>

            <!-- Tandai Direview Button -->
            <form action="{{ route('admin.reports.update_status', ['report' => $report->id, 'status' => 'reviewed']) }}" method="POST" class="inline-block" id="reviewed-form-{{ $report->id }}">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Tandai Direview
                </button>
            </form>

            <!-- Hapus Laporan Button -->
            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="inline-block" id="delete-report-form-{{ $report->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Hapus Laporan
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    // Konfirmasi sebelum mengubah status laporan menjadi Selesai
    document.querySelectorAll('form[id^="resolve-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirim
            Swal.fire({
                title: 'Anda yakin ingin menandai laporan ini sebagai Selesai?',
                text: "Status laporan akan diperbarui!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Selesai',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika pengguna mengkonfirmasi
                }
            });
        });
    });

    // Konfirmasi sebelum mengubah status laporan menjadi Direview
    document.querySelectorAll('form[id^="reviewed-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirim
            Swal.fire({
                title: 'Anda yakin ingin menandai laporan ini sebagai Direview?',
                text: "Status laporan akan diperbarui!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Direview',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika pengguna mengkonfirmasi
                }
            });
        });
    });

    // Konfirmasi sebelum menghapus laporan
    document.querySelectorAll('form[id^="delete-report-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirim
            Swal.fire({
                title: 'Anda yakin ingin menghapus laporan ini?',
                text: "Laporan yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika pengguna mengkonfirmasi
                }
            });
        });
    });
</script>
@endsection