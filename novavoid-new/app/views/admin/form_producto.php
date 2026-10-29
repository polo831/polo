<!DOCTYPE html>
<html lang="es">
<head>
    <?= $parametros_de_vista['head'] ?? $head ?? '' ?>
    <title><?= $datos['titulo'] ?? 'Gestión de Producto' ?></title>
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
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; border: none; cursor: pointer; display: inline-block; }
        .btn-success { background: #28a745; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
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
                <h1><?= $datos['titulo'] ?></h1>
                <hr>

                <form action="<?= $ruta ?>public/index.php?url=admin/guardarProducto" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
    <!-- Campo oculto para edición o creación (usando objetos ->) -->
    <input type="hidden" name="id" value="<?= $datos['producto']->id ?? '' ?>">

    <div class="form-group">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($datos['producto']->nombre ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="precio">Precio ($):</label>
        <input type="number" step="0.01" id="precio" name="precio" value="<?= $datos['producto']->precio ?? '' ?>" required>
    </div>

    <div class="form-group">
        <label for="stock">Stock disponible:</label>
        <input type="number" id="stock" name="stock" value="<?= $datos['producto']->stock ?? '' ?>" required>
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" name="categoria_id" required>
            <option value="">Seleccione una categoría...</option>
            <?php if (!empty($datos['categorias'])): ?>
                <?php foreach ($datos['categorias'] as $cat): ?>
                    <option value="<?= $cat->id ?>" <?= (isset($datos['producto']->categoria_id) && $datos['producto']->categoria_id == $cat->id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat->nombre) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="imagen">Imagen del Producto:</label>
        <input type="file" id="imagen" name="imagen">
        <?php if (!empty($datos['producto']->imagen)): ?>
            <p style="font-size: 13px; color: #666; margin-top: 5px;">Imagen actual: <strong><?= $datos['producto']->imagen ?></strong></p>
        <?php endif; ?>
    </div>

    <div style="margin-top: 20px; display: flex; justify-content: space-between;">
        <a href="http://localhost/polo/novavoid-new/public/index.php?url=admin/productos" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-success">Guardar Producto</button>
    </div>
</form>