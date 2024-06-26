


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

                                        <button  data-id="{{ $profile->id }}" class="deleteButton btn btn-sm text-danger">
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

                {{-- <nav aria-label="Page navigation" class=" pagination mt-4 d-flex justify-content-end">
                    {{ $profiles->links('pagination::bootstrap-4', ['class' => 'profile-list-page-link']) }}
                </nav> --}}

                <nav aria-label="Page navigation" class=" pagination mt-4 d-flex justify-content-end">
                    {{ $profiles->links('pagination::bootstrap-4') }}
                </nav>

            </div>

