<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroGestor — Recuperar Contraseña</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 30, 15, 0.65);
            z-index: 0;
        }

        .card-box {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo-area img {
            height: 80px;
            margin-bottom: 0.5rem;
        }

        .logo-area h1 {
            color: #1a3a2a;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .logo-area p {
            color: #c9a84c;
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .descripcion {
            color: #555;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .form-label {
            color: #1a3a2a;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #1a3a2a;
            box-shadow: 0 0 0 3px rgba(26,58,42,0.1);
        }

        .btn-enviar {
            background: linear-gradient(135deg, #1a3a2a, #2d6a4f);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            letter-spacing: 1px;
        }

        .btn-enviar:hover {
            background: linear-gradient(135deg, #c9a84c, #b8862a);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(201,168,76,0.4);
        }

        .back-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .back-link a {
            color: #1a3a2a;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link a:hover {
            color: #c9a84c;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="card-box">
        <div class="logo-area">
            <img src="{{ asset('images/Logo_AgroGestor.png') }}" alt="AgroGestor">
            <h1>AgroGestor</h1>
            <p>Recuperar Contraseña</p>
        </div>

        <p class="descripcion">
            Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>

        @if (session('status'))
            <div class="alert alert-success mb-3" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus
                       placeholder="correo@ejemplo.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-enviar">ENVIAR ENLACE</button>

            <div class="back-link">
                <a href="{{ route('login') }}">← Volver al inicio de sesión</a>
            </div>
        </form>
    </div>
</body>
</html>
