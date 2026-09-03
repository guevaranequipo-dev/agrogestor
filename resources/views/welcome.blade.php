<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroGestor — Sistema de Gestión de Fincas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f0;
        }

        /* ===== NAVBAR ===== */
        .landing-nav {
            background: linear-gradient(135deg, #1a3a2a, #2d6a4f);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }

        .landing-nav .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .landing-nav .brand img {
            height: 45px;
        }

        .landing-nav .brand-text {
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .landing-nav .brand-text span {
            color: #c9a84c;
        }

        .landing-nav .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-nav-login {
            color: white;
            border: 2px solid rgba(255,255,255,0.5);
            padding: 0.4rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-nav-login:hover {
            border-color: #c9a84c;
            color: #c9a84c;
        }

        .btn-nav-register {
            background: #c9a84c;
            color: #1a3a2a;
            padding: 0.4rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-nav-register:hover {
            background: white;
            color: #1a3a2a;
        }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(10, 30, 15, 0.7);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            padding: 2rem;
        }

        .hero-content img {
            height: 140px;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 15px rgba(0,0,0,0.5));
            animation: flotar 3s ease-in-out infinite;
        }

        @keyframes flotar {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: 3px;
            margin-bottom: 0.5rem;
        }

        .hero-content h1 span {
            color: #c9a84c;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.85);
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: #c9a84c;
            color: #1a3a2a;
            padding: 0.9rem 2.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(201,168,76,0.4);
        }

        .btn-hero-primary:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,255,255,0.3);
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            padding: 0.9rem 2.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid white;
            transition: all 0.3s;
        }

        .btn-hero-secondary:hover {
            background: white;
            color: #1a3a2a;
            transform: translateY(-2px);
        }

        /* ===== FEATURES ===== */
        .features {
            padding: 5rem 2rem;
            background: white;
        }

        .features h2 {
            text-align: center;
            color: #1a3a2a;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .features .subtitle {
            text-align: center;
            color: #c9a84c;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-bottom: 3rem;
        }

        .feature-card {
            text-align: center;
            padding: 2rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s;
            opacity: 0;
            transform: translateY(30px);
        }

        .feature-card.visible {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.6s ease;
        }

        .feature-card:hover {
            background: #f5f5f0;
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: #1a3a2a;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* ===== STATS ===== */
        .stats {
            background: linear-gradient(135deg, #1a3a2a, #2d6a4f);
            padding: 4rem 2rem;
            color: white;
        }

        .stat-item {
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
        }

        .stat-item.visible {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.6s ease;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #c9a84c;
        }

        .stat-item p {
            color: rgba(255,255,255,0.85);
            font-size: 0.95rem;
        }

        /* ===== CTA ===== */
        .cta {
            padding: 5rem 2rem;
            text-align: center;
            background: #f5f5f0;
        }

        .cta h2 {
            color: #1a3a2a;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta p {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.05rem;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #1a3a2a;
            color: rgba(255,255,255,0.7);
            text-align: center;
            padding: 1.5rem;
            font-size: 0.85rem;
        }

        .footer span {
            color: #c9a84c;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="landing-nav">
        <div class="brand">
            <img src="{{ asset('images/Logo_AgroGestor.png') }}" alt="AgroGestor Logo">
            <span class="brand-text">Agro<span>Gestor</span></span>
        </div>
        <div class="nav-buttons">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-nav-login">Iniciar Sesión</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav-register">Registrarse</a>
            @endif
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <img src="{{ asset('images/Logo_AgroGestor.png') }}" alt="AgroGestor">
            <h1>AGRO<span>GESTOR</span></h1>
            <p>Sistema web para gestionar tus fincas, trabajadores, pagos, insumos y finanzas de manera organizada y eficiente.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-hero-primary">Comenzar Gratis</a>
                <a href="{{ route('login') }}" class="btn-hero-secondary">Iniciar Sesión</a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <h2>Todo lo que necesitas para tu finca</h2>
        <p class="subtitle">Módulos del sistema</p>

        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">🏡</div>
                        <h3>Gestión de Fincas</h3>
                        <p>Registra y administra múltiples fincas desde una sola cuenta. Cada finca con su propia información y módulos.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">👷</div>
                        <h3>Control de Trabajadores</h3>
                        <p>Registra trabajadores, controla su información, salario por día y estado de actividad en la finca.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">💵</div>
                        <h3>Pagos Flexibles</h3>
                        <p>Maneja pagos por jornal, contrato o recolección. Ideal para fincas cafeteras con pago por kilo recolectado.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">📋</div>
                        <h3>Actividades Agrícolas</h3>
                        <p>Programa y controla actividades agrícolas, asigna trabajadores y monitorea el estado de cada tarea.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">🧪</div>
                        <h3>Catálogo de Insumos</h3>
                        <p>Controla tu inventario de fertilizantes, abonos y venenos con stock disponible y precio unitario.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Reportes y Finanzas</h3>
                        <p>Visualiza ingresos, gastos, balance financiero y estadísticas de productividad con gráficas interactivas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-item">
                        <h3>100%</h3>
                        <p>Web — accede desde cualquier dispositivo</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h3>6+</h3>
                        <p>Módulos de gestión integrados</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h3>∞</h3>
                        <p>Fincas por usuario sin límite</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h3>🔒</h3>
                        <p>Datos seguros y privados por usuario</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <img src="{{ asset('images/Logo_AgroGestor.png') }}" alt="AgroGestor" style="height: 80px; margin-bottom: 1.5rem;">
        <h2>¿Listo para organizar tu finca?</h2>
        <p>Crea tu cuenta gratis y empieza a gestionar tus fincas hoy mismo.</p>
        <a href="{{ route('register') }}" class="btn-hero-primary">Crear Cuenta Gratis</a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2026 <span>AgroGestor</span> — Sistema de Gestión de Fincas. Desarrollado por <span>Santiago Guevara</span>.</p>
    </footer>

    <script>
        // Animaciones de entrada al hacer scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-card, .stat-item').forEach(el => {
            observer.observe(el);
        });
    </script>

</body>
</html>
