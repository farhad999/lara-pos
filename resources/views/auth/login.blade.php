<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login|{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('/vendor/bootstrap-4/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('app.css')}}">
</head>
<body class="login-wrapper">

<div class="login-container">

    <h4 class="text-center my-2">{{env('app_name')}}</h4>

    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{session()->get('message')}}
        </div>
    @endif

    <div class="card">

        <div class="card-body">
            {!! Form::open(['url' => action([\App\Http\Controllers\AuthController::class, 'login']), 'id' => 'login-form']) !!}

            <div class="form-group my-2">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', '', ['placeholder' => 'Email', 'class' => 'form-control']) !!}
            </div>

            <div class="form-group my-2">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
            </div>

            <button class="btn btn-primary mt-2">Login</button>

            {!! Form::close() !!}

        </div>
    </div>
</div>

<script src="{{asset('/vendor/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('/vendor/jquery.validate.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $("#login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            // Specify validation error messages
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
                email: "Please enter a valid email address"
            },
        });
    })
</script>

</body>
</html>
