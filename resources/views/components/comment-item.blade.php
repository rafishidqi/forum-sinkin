@props(['comment', 'level' => 0])

{{-- Menentukan kelas CSS berdasarkan level indentasi --}}
<div class="mb-3 rounded-lg border
    @if($level == 0)
        bg-gray-700 border-gray-600 p-4
    @else
        {{-- Indentasi berdasarkan level. ml-4, ml-8, ml-12, dst. --}}
        ml-{{ ($level > 0 ? $level * 4 : 0) }}
        bg-gray-600 border-gray-500 p-3
    @endif
">
    <div class="flex justify-between items-center text-white text-sm mb-1">
        <div>
            @if($comment->is_deleted)
                <span class="text-gray-400 italic">[komentar dihapus]</span>
            @else
                <strong>{{ $comment->user->username }}</strong>: {{ $comment->content }}
            @endif
        </div>
        
        {{-- Tombol Hapus Komentar --}}
        <div>
            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="inline-block" id="delete-comment-form-{{ $comment->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-500 text-xs font-semibold"
                        onclick="event.stopPropagation()"> {{-- Mencegah klik menyebar ke div induk --}}
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Render balasan secara rekursif --}}
    @if($comment->replies->isNotEmpty())
        <div class="mt-2">
            @foreach($comment->replies as $reply)
                {{-- Memanggil komponen ini lagi untuk setiap balasan, dengan level yang ditingkatkan --}}
                <x-comment-item :comment="$reply" :level="$level + 1" />
            @endforeach
        </div>
    @endif
</div>
