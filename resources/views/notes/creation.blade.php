@extends('notes.template')

@section('title', 'Creation')

@section('content')
    <main>
        <form id="create_form" class ="container" action="{{ route('notes.create_note') }}" method="POST">
            @csrf

            <label for="text">New note:</label>
            <textarea name="text"
                id="text"
                placeholder="..."
                rows="6" cols="24"
                ></textarea>

            <label for="readings_left">Readings till destruction:</label>
            <select name="readings_left" id="readings_left">
                <option selected="selected">1</option>

                <?php for ($i = 2; $i <= 10; $i++) {
                    echo "<option>$i</option>";
                } ?>
            </select>

            <button type="submit">Create note</button>

            <p>Server response:</p>
            <div id="response_message" style="display: none;"></div>
        </form>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#create_form').submit(function(e) {
                $('#response_message').hide();

                e.preventDefault();

                let form = $('#create_form')[0];
                let formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('notes.create_note') }}',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#response_message').html(
                            `<p>${JSON.stringify(response.data)}</p>`
                        );
                        $('#response_message').show();
                    },
                    error: function(xhr, status, error) {
                        $('#response_message').html(
                            `<p>${JSON.stringify(JSON.parse(xhr.responseText).errors)}</p>`
                        );
                        $('#response_message').show();
                    }
                });
            });
        });
    </script>
@endsection