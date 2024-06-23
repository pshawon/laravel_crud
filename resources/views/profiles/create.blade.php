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
        <h3 class="text-white text-center">Profile Creation</h3>
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center"> 
            <div class="col-md-10">
              <div class="card border-0 shadow lg my-4">
                <div class="card-header bg-dark">
                  <h3 class="text-white">Create Profile</h3>
                </div>
                  <form enctype="multipart/form-data" action="{{ route('profiles.store') }}" method="post">
                    @csrf                  
                      <div class="card-body">
                        <div class="mb-3">
                          <label for="" class="form-label h5">Name</label>
                          <input value="{{ old('name') }}" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" Placeholder="Name" name="name" >
                          @error("name")
                          <p class="invalid-feedback">{{ $message }}</p>                 
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">email</label>
                          <input value="{{ old('email') }}" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" Placeholder="Email" name="email" >
                          @error('email')
                          <p class="invalid-feedback">{{ $message }}</p>                 
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">Phone</label>
                          <input value="{{ old('phone') }}" type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" Placeholder="Phone" name="phone" >
                          @error('phone')
                          <p class="invalid-feedback">{{ $message }}</p>                 
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">Address</label>
                          <input value="{{ old('address') }}" type="text" class="form-control form-control-lg @error('address') is-invalid @enderror" Placeholder="Address" name="address" >
                          @error('address')
                          <p class="invalid-feedback">{{ $message }}</p>                 
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">Image</label>
                          <input type="file" class="form-control form-control-lg @error('image') is-invalid @enderror" Placeholder="Image" name="image" >
                          @error('image')
                          <p class="invalid-feedback">{{ $message }}</p>                 
                          @enderror
                        </div>

                        <div class="mb-3">
                          <label for="" class="form-label h5">Attachment</label>
                          <input type="file" class="form-control form-control-lg @error('attached') is-invalid @enderror" Placeholder="Attachment" name="attached" >
                          @error('attached')
                          <p class="invalid-feedback">{{ $message }}</p>                 
                          @enderror
                        </div>
                        <div class="d-grid">
                          <button class="btn btn-lg btn-primary ">Submit</button>
                        </div>
                      </div>
                </form>

              </div>

            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>