<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Clínica Dental Dr. Eddy Paulino</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>
<body>

    <div class="login-container">
        <!-- columna  -->
        <div class="login-form-section">
            <div class="mb-4">
                <h2 class="brand-title">Clínica Dental</h2>
                <h4 class="text-muted fw-normal">Dr. Eddy Paulino</h4>
            </div>
            
            <div class="mb-5">
                <h5 class="fw-bold mb-1">¡Bienvenido de nuevo!</h5>
                <p class="text-muted small">Accede a tu cuenta.</p>
            </div>

            <form method="POST" action="#">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@dentalpro.com" required autofocus>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-login w-100 shadow-sm">
                    Iniciar sesión
                </button>
            </form>

        </div>

        <!-- columna -->
        <div class="login-visual-section">
            <div class="visual-circle"></div>
            <div class="visual-icon">
                <!-- icono -->
                <svg class="visual-icon" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M403.331,245.808c26.667-59.947,51.307-146.453,33.173-193.067
                    c-25.707-65.92-80.747-55.04-129.28-45.547c-17.28,3.413-35.2,6.933-51.2,6.933
                    s-33.92-3.52-51.2-6.933c-48.533-9.6-103.467-20.373-129.28,45.547
                    c-18.133,46.507,6.507,133.12,33.173,193.067c0.747,1.707,1.067,3.52,0.853,5.333
                    c-2.56,25.067-3.84,50.347-3.733,75.52c0,68.8,10.453,185.387,49.387,185.387
                    c33.387,0,37.973-44.267,42.88-91.2c6.933-67.52,15.253-115.307,57.92-115.307
                    c42.027,0,50.133,47.36,57.067,114.133c4.907,47.467,9.493,92.267,43.733,92.267
                    c39.04,0,49.493-116.587,49.493-185.387c0-25.173-1.173-50.347-3.733-75.52
                    C402.264,249.328,402.584,247.408,403.331,245.808z"/>
                </svg>
            </div>
            <div class="visual-text">
                <h3>Gestión clínica</h3>
                <p>Implantar y desarrollar un nuevo concepto de odontología multidisciplinaria, capaz de ofertar y realizar todo tipo de tratamientos dentales.</p>
            </div>
        </div>
    </div>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>