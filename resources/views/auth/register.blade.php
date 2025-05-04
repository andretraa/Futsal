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
      background: linear-gradient(135deg, #667eea, #764ba2);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .register-container {
      width: 100%;
      max-width: 450px;
      padding: 40px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(15px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.3);
      color: #fff;
      position: relative;
    }

    .register-container h2 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    .form-control {
      background: transparent;
      border: none;
      border-bottom: 1.5px solid #ddd;
      border-radius: 0;
      color: #fff;
      padding-left: 0;
    }

    .form-control:focus {
      border-color: #fff;
      background: transparent;
      box-shadow: none;
    }

    .form-group label {
      font-weight: 500;
      font-size: 0.9rem;
    }

    .btn-register {
      width: 100%;
      padding: 12px;
      border-radius: 30px;
      background: #00dfc4;
      color: #000;
      font-weight: 600;
      border: none;
      transition: 0.3s;
    }

    .btn-register:hover {
      background: #00bba7;
      transform: scale(1.02);
    }

    .icon-top {
      text-align: center;
      font-size: 50px;
      margin-bottom: 20px;
      color: #00dfc4;
    }

    .login-link {
      display: block;
      text-align: center;
      font-size: 0.85rem;
      margin-top: 20px;
      color: #ccc;
      text-decoration: none;
    }

    .login-link:hover {
      color: #00dfc4;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <form class="register-container" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="icon-top"><i class="bi bi-person-plus-fill"></i></div>
    <h2>Create Account</h2>

    <div class="form-group mb-3">
      <label>Full Name</label>
      <input type="text" name="name" class="form-control" placeholder="Your full name" value="{{ old('name') }}" required>
    </div>

    <div class="form-group mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" placeholder="Your email" value="{{ old('email') }}" required>
    </div>

    <div class="form-group mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" placeholder="Create password" required>
    </div>

    <div class="form-group mb-4">
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
    </div>

    <button type="submit" class="btn btn-register">Register</button>

    <a href="{{ route('login') }}" class="login-link">Already have an account? Login</a>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
