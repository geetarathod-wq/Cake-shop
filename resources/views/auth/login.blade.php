<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Blonde Bakery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --gold: #D4AF37; --cream: #F9F7F2; --dark: #1A1A1A; }
        
        body { 
            background-color: var(--cream); 
            font-family: 'Montserrat', sans-serif; 
            height: 100vh; 
            margin: 0;
            overflow: hidden;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }

        .login-wrapper { display: flex; height: 100vh; }

        /* Left side: Editorial Image */
        .brand-side {
            flex: 1.2;
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), 
                        url('https://images.unsplash.com/photo-1535141192574-5d4897c12636?q=80&w=1976') center/cover;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: white;
            position: relative;
        }
        
        @media (max-width: 991px) { .brand-side { display: none; } }

        /* Right side: Form */
        .form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: var(--cream);
            position: relative;
        }

        .login-card { width: 100%; max-width: 380px; }
        
        .brand-logo { 
            font-size: 1.8rem; 
            letter-spacing: 6px; 
            text-decoration: none; 
            color: var(--dark); 
            display: block; 
            margin-bottom: 3rem;
        }

        /* Minimalist Input Styling */
        .form-group { position: relative; margin-bottom: 35px; }
        
        .form-control {
            background: transparent; border: none; border-bottom: 1px solid rgba(0,0,0,0.1);
            border-radius: 0; padding: 10px 0; font-size: 0.95rem; transition: 0.4s;
            color: var(--dark);
        }

        .form-control:focus {
            box-shadow: none; border-bottom: 1px solid var(--gold); background: transparent;
        }

        .floating-label {
            position: absolute; top: 10px; left: 0; pointer-events: none;
            transition: 0.3s ease all; font-size: 0.75rem; text-transform: uppercase;
            letter-spacing: 1.5px; color: #999;
        }

        .form-control:focus ~ .floating-label,
        .form-control:not(:placeholder-shown) ~ .floating-label {
            top: -18px; font-size: 0.65rem; color: var(--gold);
        }

        /* Buttons */
        .btn-luxury {
            background: var(--dark); color: white; border: 1px solid var(--dark);
            width: 100%; padding: 16px; text-transform: uppercase; letter-spacing: 3px;
            font-size: 0.75rem; transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .btn-luxury:hover {
            background: transparent; color: var(--dark);
        }

        .error-box {
            background: #fff0f0; border-left: 2px solid #ff4d4d;
            padding: 12px; margin-bottom: 25px; font-size: 0.8rem; color: #d00;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="brand-side">
        <h4 class="serif italic mb-0">The Art of Baking</h4>
        <h2 class="serif display-4">Reserved for the Connoisseur.</h2>
    </div>

    <div class="form-side">
        <div class="login-card">
            <a href="/" class="brand-logo serif">BLONDE BAKERY.</a>
            
            <h1 class="serif italic h3 mb-4">Welcome Back</h1>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder=" " value="{{ old('email') }}" required autofocus>
                    <label class="floating-label">Email Address</label>
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder=" " required>
                    <label class="floating-label">Password</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label small" for="remember">Keep me signed in</label>
                    </div>
                    <a href="#" class="small text-muted text-decoration-none">Forgot?</a>
                </div>

                <button type="submit" class="btn-luxury">Authenticate</button>

                <p class="text-center mt-5 small text-muted">
                    New to the bakery? <a href="{{ route('register') }}" class="text-dark fw-bold text-decoration-none ms-1">Create Account</a>
                </p>
            </form>
        </div>
    </div>
</div>

</body>
</html>