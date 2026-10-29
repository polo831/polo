<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Noda Void</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?=$head?>
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4 p-4 bg-white">
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">Noda Void</h2>
                    <p class="text-muted small">Inicia sesión en tu cuenta</p>
                </div>

                <?php if (!empty($mensajeExito)): ?>
                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?php echo htmlspecialchars($mensajeExito); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <form action="polo/novavoid-new/public/index.php?url=auth/login" method="POST">
                
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" id="email" name="email" required class="form-control border-start-0 ps-0" placeholder="tu@correo.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" id="password" name="password" required class="form-control border-start-0 ps-0" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark py-2 fw-semibold rounded-3 shadow-sm">Ingresar</button>
                        <div class="text-center mt-3">
                     <a href="<?=$ruta?>auth/ProcesarRecuperar" class="text-decoration-none text-muted">¿Olvidaste tu contraseña?</a>
                    </div>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="text-muted small mb-0">¿No tienes cuenta? <a href="<?=$ruta?>auth/register" class="text-decoration-none fw-semibold text-dark">Regístrate aquí</a></p>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>