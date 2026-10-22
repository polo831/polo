<?php
// Vista de registro para Noda Void con Bootstrap
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Noda Void</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?=$head?>
</head>
<body class="bg-light d-flex align-items-center py-5" style="min-height: 100vh;">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 p-4">
                    <div class="card-body">
                        <!-- Título de la marca -->
                        <h2 class="text-center mb-1 fw-bold text-uppercase" style="letter-spacing: 2px;">Noda Void</h2>
                        <p class="text-center text-muted mb-4">Crea tu cuenta para comenzar</p>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" required class="form-control" placeholder="Tu nombre completo">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" id="email" name="email" required class="form-control" placeholder="ejemplo@correo.com">
                            </div>

                            <!-- Campo Dirección -->
                           <div class="mb-3">
                                <label for="direccion" class="form-label fw-bold">Dirección</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Ej: San Martín 1234, Santa Fe">
                            </div>

                            <!-- Campo Teléfono -->
                            <div class="mb-3">
                                <label for="telefono" class="form-label fw-bold">Teléfono / Celular</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" required placeholder="Ej: 3421234567">
                           </div>

                            <!-- Campo Contraseña -->
                            <div class="mb-3">
                                  <label for="password" class="form-label fw-bold">Contraseña</label>
                                 <input type="password" id="password" name="password" class="form-control" required placeholder="Mínimo 8 caracteres">
                                <div class="form-text">Debe tener al menos 8 caracteres, una letra mayúscula, un número y un símbolo especial.</div>
                            </div>

                            <!-- Campo Confirmar Contraseña -->
                            <div class="mb-3">
                                 <label for="confirmar_password" class="form-label fw-bold">Confirmar Contraseña</label>
                                <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" required placeholder="Repite tu contraseña">
                            </div>

                            

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark py-2">Registrarse</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted mb-0">¿Ya tienes una cuenta? <a href="<?=$ruta?>auth/login" class="text-decoration-none fw-semibold text-dark">Inicia sesión aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>