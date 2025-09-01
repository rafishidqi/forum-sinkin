@extends('admin.layouts.app') {{-- Pastikan ini sesuai dengan nama layout admin Anda --}}

@section('title', 'Manajemen Laporan')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 font-poppins">

    <h1 class="text-3xl font-bold text-white mb-6">Daftar Laporan</h1>

    <!-- Daftar Laporan dalam format Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($reports as $report)
        <div class="bg-gray-800 p-4 rounded-lg shadow-md hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer"
             onclick="window.location='{{ route('admin.reports.show', $report->id) }}'"> {{-- Asumsi ada route show untuk detail laporan --}}
            
            <!-- Card Header -->
            <div class="flex justify-between items-center mb-4">
                {{-- Menampilkan pelapor (user_id) --}}
                <span class="text-sm text-gray-400">
                    Pelapor: u/{{ $report->user->username ?? 'N/A' }} {{-- Menggunakan relasi user --}}
                </span>
                {{-- Menampilkan ID Laporan --}}
                <span class="text-xs text-gray-500">ID: {{ $report->id }}</span>
            </div>

            <!-- Tipe Laporan (Post atau Komentar) -->
            <div class="mb-2">
                @if ($report->post_id)
                    <span class="text-sm text-blue-400">Laporan Postingan</span>
                    <p class="text-xs text-gray-400">Post ID: {{ $report->post_id }}</p>
                @elseif ($report->comment_id)
                    <span class="text-sm text-purple-400">Laporan Komentar</span>
                    <p class="text-xs text-gray-400">Comment ID: {{ $report->comment_id }}</p>
                @else
                    <span class="text-sm text-gray-400">Tipe Tidak Diketahui</span>
                @endif
            </div>

            <!-- Alasan Laporan -->
            <h2 class="text-xl font-semibold text-white mb-2">Alasan:</h2>
            <p class="text-gray-300 mt-2 text-sm line-clamp-3">{{ $report->reason }}</p>

            <!-- Status Laporan -->
            <div class="mt-4 flex justify-between items-center">
                @if ($report->status == 'pending')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Pending
                    </span>
                @elseif ($report->status == 'resolved')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Selesai
                    </span>
                @elseif ($report->status == 'rejected')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Ditolak
                    </span>
                @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ ucfirst($report->status) }}
                    </span>
                @endif
                <span class="text-xs text-gray-500">Dibuat: {{ $report->created_at->format('d M Y H:i') }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-gray-800 p-6 rounded-lg shadow-md text-center text-gray-400">
            Tidak ada laporan yang tersedia.
        </div>
        @endforelse
    </div>

    {{-- Opsional: Tambahkan paginasi jika Anda menggunakan Report::paginate(jumlah) di controller --}}
    {{-- <div class="mt-6">
        {{ $reports->links() }}
    </div> --}}

</div>
@endsection
