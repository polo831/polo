<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $datos['titulo'] ?? 'Panel' ?></title>
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f6f9; }
        .dashboard-container { display: flex; height: 100vh; }
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
        <li><a href="index.php?url=admin">Inicio</a></li>
        <li><a href="index.php?url=admin/productos">Gestionar Productos (ABM)</a></li>
        <li><a href="index.php?url=admin/usuarios">Gestionar Usuarios</a></li>
        <li><a href="index.php?url=auth/logout">Cerrar Sesión</a></li>
    </ul>
    </nav>
       
        <!-- Contenido Principal -->
        <main class="main-content">
            <div class="card">
                <h1><?= $datos['titulo'] ?></h1>
                <p><?= $datos['mensaje'] ?></p>
                <hr>
                <p></p>
            </div>
        </main>
    </div>

</body>
</html>