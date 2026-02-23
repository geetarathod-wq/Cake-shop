<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | MyCakes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --gold: #D4AF37; --dark-choco: #2C1810; --cream: #FFFDF5; }
        body { background: var(--dark-choco); height: 100vh; display: flex; align-items: center; font-family: 'Poppins', sans-serif; }
        .login-card { background: var(--cream); border-radius: 30px; padding: 40px; width: 100%; max-width: 400px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .btn-gold { background: var(--gold); color: var(--dark-choco); font-weight: 700; border: none; border-radius: 50px; padding: 12px; width: 100%; transition: 0.3s; }
        .btn-gold:hover { transform: scale(1.02); background: #f2d472; }
        .form-control { border-radius: 15px; border: 1px solid #ddd; padding: 12px; }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="login-card text-center">
            <h2 class="mb-4" style="font-family: 'Playfair Display'; color: var(--dark-choco);">Admin Login</h2>
            <form action="{{ route('admin.login.submit') }}" method="POST">
    @csrf
    
    <div class="mb-3 text-start">
        <label class="form-label fw-bold">Username</label>
        <input type="text" name="username" class="form-control" placeholder="admin" required>
    </div>

    <div class="mb-4 text-start">
        <label class="form-label fw-bold">Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
    </div>

    <button type="submit" class="btn btn-gold">Enter Dashboard</button>
</form>
        </div>
    </div>
</body>
</html>