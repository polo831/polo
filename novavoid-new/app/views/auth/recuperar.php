<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - Nova Void Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card p-4 shadow-sm border-0 bg-white" style="width: 400px;">
        <h3 class="text-center fw-bold mb-3">Recuperar Acceso</h3>
        <p class="text-muted text-center small mb-4">Ingresa tu correo y define una nueva contraseña segura.</p>
        
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required placeholder="tu@email.com">
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nueva Contraseña</label>
                <input type="password" name="nueva_password" class="form-control" required placeholder="Nueva contraseña">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Confirmar Nueva Contraseña</label>
                <input type="password" name="confirmar_password" class="form-control" required placeholder="Repite la contraseña">
            </div>

            <button type="submit" class="btn btn-dark w-100 fw-bold py-2">Actualizar Contraseña</button>
            
            <div class="text-center mt-3">
                <a href="<?=$ruta?>auth/login" class="text-decoration-none text-muted small">Volver al Login</a>
            </div>
        </form>
    </div>
</body>
</html>