<script>
        $(document).ready(function() {
            function fetchResults(page = 1) {
                let name = $('#nameSearch').val();
                let email = $('#emailSearch').val();
                let phone = $('#phoneSearch').val();
                let address = $('#addressSearch').val();

                $.ajax({
                    url: "{{ route('live.search') }}",
                    type: "GET",
                    data: {
                        'name': name,
                        'email': email,
                        'phone': phone,
                        'address': address,
                        'page': page
                     },
                     success: function(data) {
                        $('#table-body').html('');
                        $('#pagination').html('');

                        if (data.data.length > 0) {
                            $.each(data.data, function(key, item) {
                                $('#table-body').append('<tr><td>' + item.name + '</td><td>' + item.email + '</td><td>' + item.phone + '</td><td>' + item.address + '</td></tr>');
                            });

                            // Handle pagination
                            if (data.links) {
                                $.each(data.links, function(key, link) {
                                    if (link.url) {
                                        $('#pagination').append('<button class="page-link" data-page="' + (new URL(link.url).searchParams.get('page') || 1) + '">' + link.label + '</button>');
                                    } else {
                                        $('#pagination').append('<span>' + link.label + '</span>');
                                    }
                                });
                            }
                        } else {
                            $('#table-body').html('<tr><td colspan="4">No results found</td></tr>');
                        }
                    }  //Done success
                });  //Done ajax
            }

            // Fetch results on input change
            $('#nameSearch, #emailSearch, #phoneSearch, #addressSearch').on('keyup', function() {
                fetchResults();
            });

            // Fetch results on pagination click
            $(document).on('click', '.page-link', function() {
                let page = $(this).data('page');
                fetchResults(page);
            });

            // Initial fetch to load the table
            fetchResults();
        });
    </script>