@extends('notes.template')

@section('title', 'Links')

@section('content')
    <main class="container">
        <div id="data-container"></div>
        
        <div id="pagination"></div>

        <p>Server response:</p>
        <div id="response_message" style="display: none;"></div>
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

    <script>
        $(document).ready(function() {
            const itemsPerPage = 5; 
            let currentPage = 1;
            let totalPages = 1;
            let data = null;

            function displayData() {
                const startingIndex = (currentPage - 1) * itemsPerPage;
                const endingIndex = Math.min(startingIndex + itemsPerPage, data.length);
                const paginatedData = data.slice(startingIndex, endingIndex);

                let html = "";
                for (const item of paginatedData) {
                    html += `
                    <div class="link_div">
                        <label for="${item.slug}">${item.readings_left}</label>
                        <input type="text" 
                            id="${item.slug}"
                            value="${window.location.origin + '/notes/' + item.slug}"
                            size="29"
                            readonly>

                        <button onclick="copyLink('${item.slug}')">Copy</button>

                        <form class="delete_form" data-url="${window.location.origin + '/api/notes/' + item.slug}">
                            @csrf
                            @method("DELETE")

                            <input type="hidden" name="slug" value="${item.slug}">

                            <button type="button" class="delete-button">Delete</button>
                        </form>
                    <div>
                    `;
                }
                $("#data-container").html(html);
            }

            function generatePagination(totalPages) {
                let html = "";
                if (totalPages > 1) {
                    for (let i = 1; i <= totalPages; i++) {
                    const activeClass = i === currentPage ? "active" : "";
                    html += `
                        <a href="#" class="${activeClass}" data-page="${i}">${i}</a>
                    `;
                    }
                }
                $("#pagination").html(html);
            }

            function handlePaginationClick(event) {
                event.preventDefault();
                const clickedPage = $(event.target).data("page");
                if (clickedPage && clickedPage !== currentPage) {
                    currentPage = clickedPage;
                    displayData();
                    generatePagination(totalPages);
                }
            }

            function fetchDataAndDisplay() {
                if (!data) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('notes.get_links') }}',
                        dataType: 'json',
                        success: function(response) {
                            data = response.data;
                            totalPages = Math.ceil(data.length / itemsPerPage);
                            displayData();
                            generatePagination(totalPages);

                            $('#response_message').html(
                                `<p>${JSON.stringify(data[0] ? data[0] : '...')} ...</p>`
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
                } else {
                    displayData();
                    generatePagination(totalPages);
                }
            }

            $("#pagination").on("click", "a", handlePaginationClick);

            fetchDataAndDisplay();
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.delete-button', function() {
                let button = $(this);
                let form = button.closest('.delete_form');
                let url = form.data('url');

                $.ajax({
                    type: 'DELETE',
                    url: url,
                    dataType: 'json',
                    success: function(response, status, xhr) {
                        $('#response_message').html(
                            `<p>Status code ${JSON.stringify(xhr.status)}</p>`
                        );

                        $('#response_message').show();                        
                        
                        button.closest('.link_div').remove(); 
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