@extends('notes.template')

@section('title', 'Note')

@section('content')
    <main class="container" id="container">
        <div id="note_div" style="display: none;">        
        </div>

        <div id="are_you_sure_div" style="display: none;">        
            <p>Do you want to read this note?</p>
            <form id="confirm_form" action="{{ route('notes.confirm_reading', $slug) }}" method="POST">   
                @csrf
                @method('PATCH')

                <button type="submit">Yes</button>
            </form>

            <button onclick="location.href='{{ route('notes.show_links') }}'">No</button>
        </div>

        <p>Server response:</p>
        <div id="response_message" style="display: none;"></div>
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

    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: '{{ route('notes.get_note', ['slug' => $slug]) }}',
                dataType: 'json',
                success: function(response) {
                    let note = response.data;
                    document.getElementById('note_div').innerHTML = 
                    `<textarea id="note" rows="6" cols="24" readonly>${note.text}</textarea>
                    <button onclick="copyNote()">Copy note</button>`; 

                    $('#are_you_sure_div').show();
                },
                error: function(xhr, status, error) {
                    $('#response_message').html(
                        `<p>${JSON.stringify(JSON.parse(xhr.responseText).errors)}</p>`
                    );

                    $('#response_message').show();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#confirm_form').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'PATCH',
                    url: '{{ route('notes.confirm_reading', ['slug' => $slug]) }}',
                    dataType: 'json',
                    success: function(response, status, xhr) {
                        $('#response_message').html(
                            `<p>Status code ${JSON.stringify(xhr.status)}</p>`
                        );
                        
                        $('#response_message').show();

                        $('#are_you_sure_div').hide();

                        $('#note_div').show();
                    },
                    error: function(xhr, status, error) {
                        $('#response_message').html(
                            `<p>${JSON.stringify(JSON.parse(xhr.responseText).errors)}</p>`
                        );
                        
                        $('#response_message').show();

                        $('#are_you_sure_div').hide();
                    }
                });
            });
        });
    </script>
@endsection