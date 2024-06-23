@extends("layouts.header")
@section("title","Dashboard")

@section("content")



    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                  @if (Session::has('success'))
                    <div class="alert alert-success">
                      {{ Session::get('success') }}
                    </div>
                  @endif
                  @if (Session::has('error'))
                    <div class="alert alert-danger">
                      {{ Session::get('error') }}
                    </div>
                  @endif

                  <form enctype="multipart/form-data" action=" {{ route('user.update',$user->id) }}" method="post">
                    @method('PUT')
                    @csrf
                      <div class="card-body">
                        <div class="mb-3">
                          <label for="" class="form-label h5">Name</label>
                          <input value="{{ old('name',$user->name) }}" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" Placeholder="Name" name="name" >
                          @error("name")
                          <p class="invalid-feedback">{{ $message }}</p>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">email</label>
                          <input value="{{ old('email',$user->email) }}" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" Placeholder="Email" name="email" readonly >
                          @error('email')
                          <p class="invalid-feedback">{{ $message }}</p>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">Phone</label>
                          <input value="{{ old('phone',$user->phone) }}" type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" Placeholder="Phone" name="phone" >
                          @error('phone')
                          <p class="invalid-feedback">{{ $message }}</p>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">Address</label>
                          <input value="{{ old('address',$user->address) }}" type="text" class="form-control form-control-lg @error('address') is-invalid @enderror" Placeholder="Address" name="address" >
                          @error('address')
                          <p class="invalid-feedback">{{ $message }}</p>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label h5">Image</label>
                          <input type="file" id="image_input" class="form-control form-control-lg @error('image') is-invalid @enderror" Placeholder="Image" name="image" >
                          @error('image')
                          <p class="invalid-feedback">{{ $message }}</p>
                          @enderror
                                @if ($user->image != null)
                                    <img class="w-50 my-2" id="image_output" src="{{ asset('uploads/profiles/'.$user->image)}}" alt="">
                                @endif
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label h5">Attachment</label>
                            <input type="file" class="form-control form-control-lg @error('attached') is-invalid @enderror" Placeholder="Attachment" name="attached" >
                            @error('attached')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                              @if ($user->attached != null) 
                                <a href="{{ asset('uploads/attached/'.$user->attached)}}" target="_blank">View Attachment</a>                                
                              @endif
                          </div>



                        <div class="d-grid">
                          <button class="btn btn-lg btn-primary ">Submit</button>
                        </div>
                      </div>
                </form>

              </div>

            </div>
        </div>

        <script>

            const ImageInput = document.getElementById('image_input');
            const ImageOutput= document.getElementById('image_output');
            ImageInput.addEventListener('change', function(event) {
                // Check if an image is selected
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();

                    // Set the image preview source once the file is read
                    reader.onload = function(e) {
                        ImageOutput.src = e.target.result;
                        ImageOutput.style.display = 'block'; // Show the image preview
                    };

                    // Read the image file
                    reader.readAsDataURL(event.target.files[0]);
                }
            });

        </script>


    @endsection

    @section("scripts")




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    @endsection
