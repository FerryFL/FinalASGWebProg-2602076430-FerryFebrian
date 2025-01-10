<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Login Page</title>
    @include('link.cssbs')
</head>

<body class="vh-100 d-flex justify-content-center align-items-center">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center">Login</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <button type="submit" class="btn btn-success w-100">Login</button>
                    <div class="d-flex flex-row text-center mt-3">
                        <p>Don't have an account? </p>
                        <a href="{{ route('register') }}">Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
@include('link.jsbs');

</html>
