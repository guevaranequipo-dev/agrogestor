<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AgroGestor — {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/pages/animaciones.css',
            'resources/js/app.js',
            'resources/js/pages/animaciones.js',
        ])

        <style>
            /* Navbar */
            nav.main-nav {
                background: linear-gradient(135deg, #1a3a2a, #2d6a4f);
                padding: 0.75rem 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            }

            .nav-brand {
                color: white;
                font-size: 1.4rem;
                font-weight: 700;
                text-decoration: none;
                letter-spacing: 1px;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .nav-brand span {
                color: #c9a84c;
            }

            .nav-links {
                display: flex;
                align-items: center;
                gap: 1.5rem;
            }

            .nav-links a {
                color: rgba(255,255,255,0.85);
                text-decoration: none;
                font-size: 0.95rem;
                font-weight: 500;
                transition: color 0.2s;
            }

            .nav-links a:hover {
                color: #c9a84c;
            }

            .nav-user {
                color: #c9a84c;
                font-weight: 600;
                font-size: 0.95rem;
            }

            .nav-logout {
                background: rgba(201,168,76,0.2);
                border: 1px solid #c9a84c;
                color: #c9a84c !important;
                padding: 0.3rem 0.8rem;
                border-radius: 6px;
                font-size: 0.85rem;
                cursor: pointer;
                transition: all 0.2s;
            }

            .nav-logout:hover {
                background: #c9a84c !important;
                color: #1a3a2a !important;
            }

            /* Header */
            .page-header {
                background: white;
                border-bottom: 3px solid #c9a84c;
                padding: 1rem 1.5rem;
            }

            .page-header h2 {
                color: #1a3a2a;
                font-weight: 700;
                font-size: 1.2rem;
                margin: 0;
            }

            /* Content */
            .main-content {
                background: #f5f5f0;
                min-height: calc(100vh - 120px);
                padding: 1.5rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">

            <!-- Navbar -->
            <nav class="main-nav">
                <a href="{{ route('fincas.index') }}" class="nav-brand">
                    🌿 Agro<span>Gestor</span>
                </a>

                <div class="nav-links">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('fincas.index') }}">Mis Fincas</a>

                    <span class="nav-user">{{ Auth::user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}" style="margin:0">
                        @csrf
                        <button type="submit" class="nav-logout">Cerrar Sesión</button>
                    </form>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <div class="page-header">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <main class="main-content">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
