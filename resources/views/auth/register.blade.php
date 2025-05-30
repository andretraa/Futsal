<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register | BSW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            /* Latar belakang disamakan dengan halaman login */
            background: url('{{ asset('assets/img/depan.jpeg') }}') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container { /* Class name digeneralisasi */
            width: 100%;
            max-width: 400px; /* Lebar max disamakan dengan login */
            padding: 40px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            color: #fff;
            position: relative;
        }

        .auth-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-control {
            background: transparent;
            border: none;
            border-bottom: 1.5px solid #ccc; /* Disamakan dengan login */
            border-radius: 0;
            color: #fff;
            padding-left: 0;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .form-control:focus {
            border-color: #00dfc4;
            background: transparent;
            box-shadow: none;
        }

        .form-group label {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .btn-auth { /* Class name digeneralisasi */
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            background: #00dfc4;
            color: #000;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-auth:hover {
            background: #00bba7;
            transform: scale(1.02);
        }

        .icon-top {
            text-align: center;
            font-size: 50px;
            margin-bottom: 20px;
            color: #df0000; /* Warna ikon disamakan dengan login */
        }

        .link-text { /* Class name digeneralisasi */
            display: block;
            text-align: center;
            font-size: 0.85rem;
            margin-top: 15px; /* Margin disamakan dengan login */
            color: #ccc;
            text-decoration: none;
        }

        .link-text:hover {
            color: #00dfc4;
            text-decoration: underline;
        }

        /* Styling untuk pesan error validasi */
        .is-invalid {
            border-color: #e3342f !important;
        }

        .invalid-feedback {
            display: block; /* Memastikan pesan error selalu terlihat jika ada */
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #e3342f;
        }
    </style>
</head>

<body>
    <form class="auth-container" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="icon-top"><i class="bi bi-person-plus-fill"></i></div>
        <h2>Create Account</h2>

        <div class="form-group mb-3">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Your full name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Create password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-auth">Register</button>

        <a href="{{ route('login') }}" class="link-text">Already have an account? Login</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>