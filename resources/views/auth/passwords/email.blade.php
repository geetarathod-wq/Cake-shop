<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Blonde Bakery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --gold: #D4AF37; --cream: #F9F7F2; --dark: #1A1A1A; }

        body {
            background-color: var(--cream);
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }

        .reset-card {
            background: white;
            border-radius: 30px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        }

        .brand-logo {
            font-size: 1.8rem;
            letter-spacing: 6px;
            text-decoration: none;
            color: var(--dark);
            display: block;
            text-align: center;
            margin-bottom: 2rem;
        }

        .btn-gold {
            background: var(--dark);
            color: white;
            border: 1px solid var(--dark);
            width: 100%;
            padding: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            transition: 0.4s;
            border-radius: 50px;
        }

        .btn-gold:hover {
            background: transparent;
            color: var(--dark);
        }

        .form-control {
            border-radius: 50px;
            border: 1px solid #ddd;
            padding: 12px 20px;
        }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.1);
        }

        .alert-success {
            background: #e8f5e9;
            border-left: 3px solid #28a745;
            color: #155724;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <a href="/" class="brand-logo serif">BLONDE BAKERY.</a>
        <h2 class="serif text-center mb-4">Reset Password</h2>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label text-muted small text-uppercase">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-gold">Send Password Reset Link</button>
        </form>

        <p class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-muted small">Back to Login</a>
        </p>
    </div>
</body>
</html>