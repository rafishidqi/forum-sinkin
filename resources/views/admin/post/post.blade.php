@extends('admin.layouts.app')

@section('title', 'Posts Management')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 font-poppins">

    <h1 class="text-3xl font-bold text-white mb-6">Daftar Postingan</h1>

    <!-- Daftar Postingan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($posts as $post)
        {{-- Kondisi untuk membedakan postingan yang tidak dipublikasikan --}}
        <div class="p-4 rounded-lg shadow-md transition-all duration-300 cursor-pointer
            @if($post->is_published == 0)
                bg-red-800 hover:bg-red-700 border border-red-600
            @else
                bg-gray-800 hover:shadow-2xl hover:scale-105
            @endif
        " onclick="window.location='{{ route('admin.posts.show', $post->id) }}'">
            
            <!-- Card Header -->
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm text-blue-400">s/{{ $post->category->name }}</span>
                <span class="text-sm text-gray-400">u/{{ $post->user->username }}</span>
            </div>

            {{-- Indikator Status Publikasi --}}
            @if($post->is_published == 0)
            <div class="mb-3">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Dihapus Pengguna
                </span>
            </div>
            @endif

            <!-- Gambar Postingan (Tampilan Kondisional) -->
            @if($post->image)
            <div class="mb-4">
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-md">
            </div>
            @endif

            <!-- Judul Kartu -->
            <h2 class="text-xl font-semibold text-white mb-2">{{ $post->title }}</h2>
            <p class="text-sm text-gray-400">{{ $post->slug }}</p>

            <!-- Konten Postingan (Kutipan) -->
            <p class="text-gray-300 mt-2 text-sm line-clamp-3">{{ $post->content }}</p>

            {{-- Tombol Restore untuk Postingan yang Dihapus Pengguna --}}
            @if($post->is_published == 0)
            <div class="mt-4 text-right">
                <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" class="inline-block" id="restore-form-{{ $post->id }}">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300"
                            onclick="event.stopPropagation()"> {{-- PENTING: TAMBAHKAN INI --}}
                        Restore
                    </button>
                </form>
            </div>
            @endif
        </div>
        @endforeach
    </div>

</div>

<script>
    // Konfirmasi sebelum Restore postingan
    document.querySelectorAll('form[id^="restore-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirim
            // Tidak perlu e.stopPropagation() di sini karena sudah di tombol
            Swal.fire({
                title: 'Anda yakin ingin me-restore postingan ini?',
                text: "Postingan ini akan kembali dipublikasikan!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Restore',
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