@extends('notes.template')

@section('title', 'Note')

@section('content')
    <main class="container">
        @if (isset($error))
            <p>Note does not exist!</p>
        @endif

        @if (isset($note))
            <textarea id="note" rows="6" cols="24" readonly>{{ $note->text }}</textarea>
            <button onclick="copyNote()">Copy note</button>

        @elseif (isset($slug))
            <p>Do you want to read this note?</p>
            <form action="{{ route('notes.confirm_reading', $slug) }}" method="POST">   
                @csrf
                @method('PATCH')

                <button type="submit">Yes</button>
            </form>

            <button onclick="location.href='{{ route('notes.show_links') }}'">No</button>
        @endif
    </main>
@endsection

@section('scripts')
    <script>
        function copyNote() {
            let copyText = document.getElementById('note');

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);
        }
    </script>
@endsection