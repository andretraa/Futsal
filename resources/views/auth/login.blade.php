<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | BSW</title>
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
      background: url('assets/img/depan.jpeg') no-repeat center center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 40px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.1); /* Semi transparan */
      backdrop-filter: blur(15px); /* Blur latar belakang */
      -webkit-backdrop-filter: blur(15px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
      color: #fff;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    .form-control {
      background: transparent;
      border: none;
      border-bottom: 1.5px solid #ccc;
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

    .btn-login {
      width: 100%;
      padding: 12px;
      border-radius: 30px;
      background: #00dfc4;
      color: #000;
      font-weight: 600;
      border: none;
      transition: 0.3s;
    }

    .btn-login:hover {
      background: #00bba7;
      transform: scale(1.02);
    }

    .icon-top {
      text-align: center;
      font-size: 50px;
      margin-bottom: 20px;
      color: #df0000;
    }

    .link-text {
      display: block;
      text-align: center;
      font-size: 0.85rem;
      margin-top: 15px;
      color: #ccc;
      text-decoration: none;
    }

    .link-text:hover {
      color: #00dfc4;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <form class="login-container" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="icon-top"><i class="bi bi-shield-lock-fill"></i></div>
    <h2>Login to BSW</h2>

    <div class="form-group mb-4">
      <label>Email</label>
      <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
    </div>

    <div class="form-group mb-4">
      <label>Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
    </div>

    <button type="submit" class="btn btn-login">Login</button>

    <a href="{{ route('password.request') }}" class="link-text">Forgot your password?</a>
    <a href="{{ route('register') }}" class="link-text">Don't have an account? Register</a>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
