<!DOCTYPE html>
<html lang="es">
<head>
    <?= $parametros_de_vista['head'] ?? $head ?? '' ?>
    <title><?= $datos['titulo'] ?? 'Gestión de Usuarios' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f6f9; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .main-content { flex: 1; padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #343a40; color: white; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-success { background: #28a745; color: white; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="card">
                <h1><?= $datos['titulo'] ?? 'Usuarios' ?></h1>
                <hr>
                <a href="<?= $ruta ?>public/index.php?url=admin/crearUsuario" class="btn btn-success">+ Nuevo Usuario</a>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos['usuarios'])): ?>
                            <?php foreach ($datos['usuarios'] as $usu): ?>
                                <tr>
                                    <td><?= $usu->id ?></td>
                                    <td><?= htmlspecialchars($usu->nombre) ?></td>
                                    <td><?= htmlspecialchars($usu->email) ?></td>
                                    <td><?= htmlspecialchars($usu->direccion ?? '-') ?></td>
                                    <td><?= htmlspecialchars($usu->telefono ?? '-') ?></td>
                                    <td><strong><?= htmlspecialchars($usu->rol) ?></strong></td>
                                    <td>
                                        <a href="<?= $ruta ?>public/index.php?url=admin/editarUsuario&id=<?= $usu->id ?>" class="btn btn-primary">Editar</a>
                                        <a href="<?= $ruta ?>public/index.php?url=admin/eliminarUsuario&id=<?= $usu->id ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" style="text-align: center;">No hay usuarios registrados.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>