<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"></meta>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <title>Basic CRUD</title>
    <style>
        .table-fixed {
            width: 100%;
            table-layout: fixed;
        }

        .table-fixed td {
            overflow: hidden;
            text-overflow: ellipsis;
            word-wrap: break-word; /* Allow text to wrap within cells */
            max-width: 200px; /* Adjust this based on your needs */
        }

    </style>


  </head>
  <body>
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Admin</h3>
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center">
            {{-- @if (Session::has('success'))
            <div class="col-md-10 mt-4">
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            </div>

            @endif
            @if (Session::has('error'))
            <div class="col-md-10 mt-4">
                <div class="alert alert-success">
                    {{ Session::get('error') }}
                </div>
            </div>

            @endif --}}
            <div class="col-md-14">
              <div class="card border-0 shadow lg my-4">
                <div class="card-header bg-dark">
                  <h3 class="text-white">Profiles</h3>
                </div>

                <!-- Search Form  -->
                 <div class='card-header'>
                    <input type="search" id="search" name="search" class="form-control" placeholder="Search" aria-label="Search">
                 </div>


                <div class="card-body table-responsive">
                    <table class="table table-bordered ">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Attached</th>
                            <th>Action</th>
                        </tr>
                        <tbody class="allData">
                        @if (count($profiles) > 0)
                        @foreach ( $profiles as $profile)
                            <tr>
                                <td>{{$profile->id}}</td>
                                <td>{{$profile->name}}</td>
                                <td>{{$profile->email}}</td>
                                <td>{{$profile->phone}}</td>
                                <td>{{$profile->address}}</td>
                                <td>
                                    @if ($profile->image != null)
                                        <img style="border-radius: 50%" src="{{ asset('uploads/profiles/'.$profile->image)}}" alt="" width="50px" height="50px">

                                    @endif

                                </td>
                                <td>
                                <a href="{{ route('profiles.view_file', $profile->id) }} " class="btn btn-lg "><i class="bi bi-file-earmark-arrow-down-fill h4"></i></a>
                                </td>
                                <td class="" >
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('profiles.edit', $profile->id) }} " class="btn btn-sm" >
                                            <i class="bi bi-pencil-square h4"></i>
                                        </a>

                                            <button  type="button" data-id="{{$profile->id}}" class="deleteButton btn btn-sm text-danger">
                                                <i class="bi bi-trash h4"></i>
                                            </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>


                        <tbody id="table-body" class="searchData">
                            <!-- Search results will be injected here -->
                        </tbody>


                    </table>

                            <nav id="pagination" aria-label="Page navigation" class="mt-4 d-flex justify-content-end">
                                {{ $profiles->links('pagination::bootstrap-4') }}
                            </nav>

                </div>

              </div>

            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {

        $('.deleteButton').on('click', function() {
        var id = $(this).data('id');
         deleteProfile(id);
        });


        function deleteProfile(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: '{{ route("profiles.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.message) {
                            // Redirect to the profile index page with a success message
                            window.location.href = '{{ route("profiles.index") }}' + '?message=' + encodeURIComponent(response.message);

                        } else {
                            alert('Error: Record not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                        }
                });
            }
        }
        // Fetch results for search
        $('#search').on('keyup', function() {
            fetchResults();
        });


        function fetchResults(page = 1) {
                let search = $('#search').val();


                if(search){
                    $('.allData').hide();
                    $('.searchData').show();
                }else{
                    $('.allData').show();
                    $('.searchData').hide();}


                $.ajax({
                    url: "{{ route('profiles.search') }}",
                    type: "GET",
                    data: {
                        'search': search,
                        'page': page
                    },
                    success: function(data) {
                        $('#table-body').html('');
                        $('#pagination').html('');

                        if (data.data.length > 0) {
                            $.each(data.data, function(key, item) {
                                var varImageAttached = '';
                                var fileAttached='';
                                var editRoute='';
                                var imageAttached = `{{ asset('uploads/profiles') }}/${item.image}`;
                                var fileAttached=`{{ asset('uploads/attached') }}/${item.attached}`;
                                var editRoute=`{{ route('profiles.edit', ':id') }} ` .replace(':id', item.id);

                                $('#table-body').append('<tr><td>'
                                 + item.id + '</td><td>'
                                 + item.name + '</td><td>'
                                 + item.email + '</td><td>'
                                 + item.phone + '</td><td>'
                                 + item.address + '</td><td><img style="border-radius: 50%" src="'
                                 + imageAttached + ' " alt="No found" width="50px" height="50px"></td><td><a href=" '
                                + fileAttached+' " class="btn btn-lg "><i class="bi bi-file-earmark-arrow-down-fill h4"></i></a></td><td><div class="d-flex align-items-center"><a href="'
                                +editRoute+'" class="btn btn-sm"><i class="bi bi-pencil-square h4"></i></a> </div></td></tr>');
                            });

                            // Handle pagination
                            if (data.links) {
                                $.each(data.links, function(key, link) {
                                    if (link.url) {
                                        $('#pagination').append('<button class="page-link" data-page="' + (new URL(link.url).searchParams.get('page') || 1) + '">' + link.label + '</button>');
                                    } else {
                                        $('#pagination').append('<span>' + link.label + '</span>');}
                                });
                            }
                        } else {
                            $('#table-body').html('<tr><td colspan="4">No results found</td></tr>');}
                    }
                });
        }



            // Fetch results on pagination click
            $(document).on('click', '.page-link', function() {
                let page = $(this).data('page');
                fetchResults(page);
            });

            // Initial fetch to load the table
            fetchResults();
    });



    </script>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    {{-- <script>
    function deleteProfile(id){
        if(confirm('Are you sure you want to delete this item?')){
            var formId='delete-form-'+id;
            document.getElementById(formId).submit();

        }
    }


</script> --}}
  </body>
</html>


