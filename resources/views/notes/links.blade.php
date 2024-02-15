@extends('notes.template')

@section('title', 'Links')

@section('content')
    <main class="container">
        @foreach ($notes as $note)
            <div>
                <label for="{{ $note->slug }}">{{ $note->readings_left }}</label>
                <input type="text" 
                    id="{{ $note->slug }}"
                    value="{{ route('notes.show_note', ['slug' => $note->slug]) }}" 
                    size="29"
                    readonly>

                <button onclick="copyLink('{{ $note->slug }}')">Copy</button>

                <form action="{{ route('notes.delete_note', $note->slug) }}" method="POST">   
                    @csrf
                    @method('DELETE')
                    
                    <button type="submit">Delete</button>
                </form>
            </div>
        @endforeach

        {{ $notes->links() }}
    </main>
@endsection

@section('scripts')
    <script>
        function copyLink(slug) {
            let copyText = document.getElementById(slug);

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);
        }
    </script>
@endsection