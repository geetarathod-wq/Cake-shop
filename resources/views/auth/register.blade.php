<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Inner Circle | Blonde Bakery</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --gold: #D4AF37; --cream: #F9F7F2; --dark: #1A1A1A; }
        body { background-color: var(--cream); font-family: 'Montserrat', sans-serif; height: 100vh; overflow: hidden; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        
        /* Split Layout */
        .register-container { display: flex; height: 100vh; }
        .image-side { 
            flex: 1; 
            background: url('https://images.unsplash.com/photo-1550617931-e17a7b70dce2?q=80&w=2070') center/cover;
            display: none; 
        }
        @media (min-width: 992px) { .image-side { display: block; } }

        .form-side { 
            flex: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 40px; 
            background: var(--cream);
        }

        .auth-card { width: 100%; max-width: 400px; }
        .brand-logo { font-size: 1.5rem; letter-spacing: 4px; text-decoration: none; color: var(--dark); display: block; margin-bottom: 2rem; }
        
        /* Premium Inputs */
        .form-control {
            background: transparent; border: none; border-bottom: 1px solid rgba(0,0,0,0.1);
            border-radius: 0; padding: 12px 0; font-size: 0.9rem; transition: 0.3s;
        }
        .form-control:focus {
            box-shadow: none; border-bottom: 1px solid var(--gold); background: transparent;
        }
        .form-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 0; }

        .btn-luxury {
            background: var(--dark); color: white; border: none; width: 100%;
            padding: 15px; text-transform: uppercase; letter-spacing: 2px;
            font-size: 0.8rem; margin-top: 2rem; transition: 0.4s;
        }
        .btn-luxury:hover { background: var(--gold); }
    </style>
</head>
<body>

<div class="register-container">
    <div class="image-side"></div>

    <div class="form-side">
        <div class="auth-card">
            <a href="/" class="brand-logo serif text-center">BLONDE BAKERY.</a>
            
            <h2 class="serif italic h3 mb-1">Create an Account</h2>
            <p class="small text-muted mb-4">Join our community for exclusive access to seasonal drops.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn-luxury">Register</button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="small text-decoration-none text-muted">
                        Already have an account? <span class="text-dark fw-bold">Sign In</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>