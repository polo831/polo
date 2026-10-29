<!DOCTYPE html>
<html lang="es">
<head>
    <?= $parametros_de_vista['head'] ?? $head ?? '' ?>
    <title><?= $datos['titulo'] ?? 'Gestión de Productos' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f6f9; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #343a40; color: white; padding: 20px; }
        .sidebar h2 { font-size: 20px; text-align: center; margin-bottom: 30px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { padding: 10px 0; border-bottom: 1px solid #4f5962; }
        .sidebar ul li a { color: white; text-decoration: none; display: block; }
        .sidebar ul li a:hover { color: #17a2b8; }
        .main-content { flex: 1; padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <!-- Menú Lateral -->
        <nav class="sidebar">
            <h2>Panel Tienda</h2>
            <ul>
                <li><a href="http://localhost/polo/novavoid-new/public/index.php?url=admin/panel">Inicio</a></li>
                <li><a href="http://localhost/polo/novavoid-new/public/index.php?url=admin/productos">Gestionar Productos (ABM)</a></li>
                <li><a href="http://localhost/polo/novavoid-new/public/index.php?url=admin/usuarios">Gestionar Usuarios</a></li>
                <li><a href="http://localhost/polo/novavoid-new/public/index.php?url=auth/logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
       
        <!-- Contenido Principal -->
        <main class="main-content">
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1><?= $datos['titulo'] ?></h1>
                    <a href="http://localhost/polo/novavoid-new/public/index.php?url=admin/crearProducto" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Agregar Producto</a>
                </div>
                <hr>

                <!-- Tabla de Productos -->
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr style="background: #343a40; color: white; text-align: left;">
                            <th style="padding: 12px;">ID</th>
                            <th style="padding: 12px;">Nombre</th>
                            <th style="padding: 12px;">Precio</th>
                            <th style="padding: 12px;">Stock</th>
                            <th style="padding: 12px; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos['productos'])): ?>
                            <?php foreach ($datos['productos'] as $prod): ?>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <!-- CORREGIDO: Usamos -> en lugar de [] -->
                                    <td style="padding: 12px;"><?= $prod->id ?></td>
                                    <td style="padding: 12px; font-weight: bold;"><?= htmlspecialchars($prod->nombre) ?></td>
                                    <td style="padding: 12px;">$<?= number_format($prod->precio, 2, ',', '.') ?></td>
                                    <td style="padding: 12px;"><?= $prod->stock ?></td>
                                    <td style="padding: 12px; text-align: center;">
                                        <a href="http://localhost/polo/novavoid-new/public/index.php?url=admin/editarProducto&id=<?= $prod->id ?>" style="background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 5px;">Editar</a>
                                        <a href="http://localhost/polo/novavoid-new/public/index.php?url=admin/eliminarProducto&id=<?= $prod->id ?>" style="background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px;" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="padding: 20px; text-align: center; color: #6c757d;">No hay productos cargados en la base de datos.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>