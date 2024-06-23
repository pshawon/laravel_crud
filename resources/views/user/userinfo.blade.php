@extends("layouts.header")
@section("title","Dashboard")
@section("css")
        .profile-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }
        .profile-info {
            text-align: center;
        }
        .profile-info h2 {
            margin-bottom: 1rem;
            color: #333;
        }
        .profile-info p {
            margin-bottom: 0.5rem;
            color: #666;
        }
@endsection
 
@section("content")
<div class="profile-container text-center">
    <img src="{{ asset('uploads/profiles/'.$user->image) }}" alt="Profile Image" class="profile-image">
    <div class="profile-info">
        <h2>{{ $user->name }}</h2>
        <p><strong>Address:</strong> {{ $user->address }}</p>
        <p><strong>Phone:</strong> {{ $user->phone }}</p>
    </div>
</div>
@endsection


