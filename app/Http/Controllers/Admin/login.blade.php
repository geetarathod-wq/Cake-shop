<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | MyCakes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fdfaf6; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: 'Poppins', sans-serif; }
        .login-box { background: #2C1810; padding: 40px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); width: 100%; max-width: 400px; text-align: center; color: white; border: 2px solid #D4AF37; }
        .btn-gold { background: #D4AF37; color: #2C1810; font-weight: bold; border: none; padding: 12px; transition: 0.3s; width: 100%; border-radius: 8px; }
        .btn-gold:hover { background: #b8952d; transform: scale(1.02); }
        .form-control { background: rgba(255,255,255,0.1); border: 1px solid #D4AF37; color: white; border-radius: 8px; }
        .form-control:focus { background: rgba(255,255,255,0.2); color: white; box-shadow: none; border-color: #fff; }
        .forgot { color: #D4AF37; text-decoration: none; font-size: 0.8rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="color: #D4AF37; font-weight: bold;">MyCakes Admin</h2>
        <p class="mb-4">Luxury Bakery Management</p>
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@mycakes.com" required>
            </div>
            <div class="mb-3 text-start">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="text-end mb-3">
                <a href="#" class="forgot">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-gold">LOG IN</button>
        </form>
    </div>
</body>
</html>