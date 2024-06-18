<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            margin-top: 50px;
        }
        .form-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-md-4 form-card">
                <h3 class="text-center mb-4">Sign Up</h3>
                @session("error")
                    <div class="alert alert-success" role="alert">
                    {{session('error')}}
                    </div>
                @endsession
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="signUpName">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="signUpEmail">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="signUpPassword">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Sign Up</button>
                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
