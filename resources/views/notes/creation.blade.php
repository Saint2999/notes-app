@extends('notes.template')

@section('title', 'Creation')

@section('content')
    <main>
        <form class ="container" action="{{ route('notes.create_note') }}" method="POST">
            @csrf

            <label for="text">New note:</label>
            <textarea name="text"
                id="text"
                placeholder="..."
                rows="6" cols="24"
                required></textarea>

            <label for="readings_left">Readings till destruction:</label>
            <select name="readings_left" id="readings_left">
                <option selected="selected">1</option>

                <?php for ($i = 2; $i <= 10; $i++) {
                    echo "<option>$i</option>";
                } ?>
            </select>

            <button type="submit">Create note</button>
        </form>
    </main>
@endsection