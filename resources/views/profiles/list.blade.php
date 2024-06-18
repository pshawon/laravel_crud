<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Basic CRUD</title>
  </head>
  <body>
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Profiles</h3>
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
            <div class="col-md-10 mt-4">
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>       
            </div>
                
            @endif 
            <div class="col-md-10">
              <div class="card border-0 shadow lg my-4">
                <div class="card-header bg-dark">
                  <h3 class="text-white">Profiles</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
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
                                <a href="{{ route('profiles.view_file', $profile->id) }} " class="btn btn-sm btn-primary">Attachment</a>
                                </td>
                                <td>
                                    <a href="{{ route('profiles.edit', $profile->id) }} " class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('profiles.destroy', $profile->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="deleteProfile({{$profile->id}})" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @endif

                    </table>
                </div>

              </div>

            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <script>
    function deleteProfile(id){
        if(confirm('Are you sure you want to delete this item?')){
            var formId='delete-form-'+id;
            document.getElementById(formId).submit();

        }
    }
</script>

<!-- <script>
    function deleteProfile(id){
        console.log("Delete button clicked for profile ID: " + id); // Debugging line
        if(confirm('Are you sure you want to delete this item?')){
            var formId = 'delete-form-' + id;
            var form = document.getElementById(formId);
            if (form) {
                form.submit();
            } else {
                console.error("Form with ID " + formId + " not found.");
            }
        }
    }
</script> -->

  </body>
</html>


