@extends('admin.layouts.app')

@section('title', 'Posts Management')

@section('content')
<div class="min-h-screen bg-gray-900 p-6 font-poppins">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Detail Postingan</h1>
        <!-- Kembali Button -->
        <a href="{{ route('admin.posts.index') }}" class="mt-6 inline-block text-blue-500 hover:text-blue-400">
            <button class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </a>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-blue-400">s/{{ $post->category->name }}</span>
            <span class="text-sm text-gray-400">u/{{ $post->user->username }}</span>
        </div>

        <!-- Title & Slug -->
        <h2 class="text-2xl font-semibold text-white mb-2">{{ $post->title }}</h2>
        <p class="text-sm text-gray-400 mb-4">{{ $post->slug }}</p>

        <!-- Gambar Postingan (Tampilan Kondisional) -->
        @if($post->image)
        <div class="mb-4">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-auto max-h-96 object-contain rounded-md">
        </div>
        @endif

        <!-- Post Content -->
        <div class="text-gray-300 mb-4 break-words"> {{-- Tambahkan break-words di sini --}}
            <p>{{ $post->content }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4 mt-4">
            <!-- Ban Button -->
            <form action="{{ route('admin.posts.ban', $post->id) }}" method="POST" class="inline-block" id="ban-form-{{ $post->id }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                    Ban
                </button>
            </form>

            <!-- Hapus Button -->
            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block" id="delete-form-{{ $post->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">
                    Hapus
                </button>
            </form>

            {{-- Tombol Restore (Hanya Tampil Jika is_published = 0) --}}
            @if($post->is_published == 0)
            <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" class="inline-block" id="restore-form-{{ $post->id }}">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">
                    Restore
                </button>
            </form>
            @endif
        </div>

    </div>

    <!-- Comments Section -->
    <div class="mt-6">
        <h3 class="text-xl font-semibold text-white mb-4">Komentar</h3>

        @forelse($post->comments as $comment)
            {{-- Memanggil komponen komentar rekursif --}}
            <x-comment-item :comment="$comment" :level="0" />
        @empty
            <p class="text-gray-400 italic">Belum ada komentar untuk postingan ini.</p>
        @endforelse
    </div>

</div>

<script>
    // Konfirmasi sebelum Ban postingan
    document.querySelectorAll('form[id^="ban-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirim
            Swal.fire({
                title: 'Anda yakin ingin mem-ban postingan ini?',
                text: "Postingan ini akan dibatasi aksesnya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ban',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika pengguna mengkonfirmasi
                }
            });
        });
    });

    // Konfirmasi sebelum menghapus postingan
    document.querySelectorAll('form[id^="delete-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirim
            Swal.fire({
                title: 'Anda yakin ingin menghapus postingan ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika pengguna mengkonfirmasi
                }
            });
        });
    });

    // Konfirmasi sebelum me-restore postingan
    document.querySelectorAll('form[id^="restore-form-"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirim
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

    // Konfirmasi sebelum menghapus komentar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form[id^="delete-comment-form-"]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah form langsung dikirim
                Swal.fire({
                    title: 'Anda yakin ingin menghapus komentar ini?',
                    text: "Komentar ini akan dihapus secara permanen!",
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
    });
</script>

@endsection