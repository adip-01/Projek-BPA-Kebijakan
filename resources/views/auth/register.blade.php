<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register SIMK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f2f2f2;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial, Helvetica, sans-serif;
        }

        .register-card{
            width:400px;
            background:white;
            border-radius:10px;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
            overflow:hidden;
        }

        .header{
            text-align:center;
            padding:20px;
        }

        .header h1{
            color:#1e88e5;
            font-weight:bold;
        }

        .logo-box{
            background:#f5f5f5;
            text-align:center;
            padding:20px;
        }

        .logo-box img{
            width:150px;
        }

        .body-form{
            padding:30px;
        }

        .form-control{
            border:none;
            border-bottom:1px solid #ccc;
            border-radius:0;
            box-shadow:none !important;
        }

        .btn-register{
            background:#ef6c7b;
            color:white;
            width:100%;
            border:none;
            padding:12px;
            border-radius:5px;
            margin-top:20px;
        }

        .btn-register:hover{
            background:#e95b6b;
        }

        .login-link{
            text-align:center;
            margin-top:20px;
        }
    </style>
</head>
<body>

<div class="register-card">

    <div class="header">
        <h1>SIMK</h1>
    </div>

    <div class="logo-box">
        <img src="{{ asset('images/telkom.png') }}" alt="Telkom">
    </div>

    <div class="body-form">

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-4">
                <input type="text"
                       class="form-control"
                       name="name"
                       placeholder="Nama"
                       required>
            </div>

            <div class="mb-4">
                <input type="email"
                       class="form-control"
                       name="email"
                       placeholder="Email"
                       required>
            </div>

            <div class="mb-4">
                <input type="password"
                       class="form-control"
                       name="password"
                       placeholder="Password"
                       required>
            </div>

            <div class="mb-4">
                <input type="password"
                       class="form-control"
                       name="password_confirmation"
                       placeholder="Konfirmasi Password"
                       required>
            </div>

            <button type="submit" class="btn-register">
                Register
            </button>

        </form>

        <div class="login-link">
            Already have an account?
            <a href="/login">Login Here</a>
        </div>

    </div>

</div>

</body>
</html>