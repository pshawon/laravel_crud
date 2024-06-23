<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        @yield('css')
        .navbar {
            background-color: black;
            border-radius: 0.5rem;
        }
        .navbar .nav-link {
            color: white !important;
        }
        .navbar .nav-link.active {
            background-color: blue !important;
            border-radius: 0.25rem;
            color: white !important;
        }
        .navbar .btn-logout {
            background-color: red;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }
        .navbar .btn-logout:hover {
            background-color: darkred;
        }
        .navbar-container {
            margin-top: 2rem; /* Add top margin */
            margin-left: 2rem; /* Add left margin */
            margin-right: 2rem; /* Add right margin */
        }
    </style>
</head>
<body>

<div class="navbar-container">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("user.view", ['id' => $user->id]) }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("user.edit", ['id' => $user->id]) }}">Edit</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <a href="{{ route('user.logout') }}" class="btn btn-logout" type="button">Logout</a>
                </form>
            </div>
        </div>
    </nav>



    <div>
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('script')
</body>
</html>
