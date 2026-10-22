<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Noda Void</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .btn-negro {
            background-color: #212529;
            color: #fff;
        }
        .btn-negro:hover {
            background-color: #000;
            color: #fff;
        }
        .img-detalle {
            max-height: 450px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
    <?=$head?>
    <?=$js?>
</head>
<body>

    <!-- Navbar -->
    <?=$topbar?>

    <div class="container my-5">
    <h2>Tu Carrito de Compras - Noda Void</h2>
    
    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="alert alert-info mt-4" role="alert">
            Tu carrito está vacío. ¡Explora el catálogo y añade algunas prendas!
        </div>
        <a href="<?=$ruta?>home" class="btn btn-dark mt-3">Ver Productos</a>
    <?php else: ?>
        <div class="table-responsive mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre'] ?? 'Producto #' . $id); ?></td>
                            <td>$<?= number_format($item['precio'], 2, ',', '.'); ?></td>
                            <td><?= $item['cantidad']; ?></td>
                            <td>$<?= number_format($item['precio'] * $item['cantidad'], 2, ',', '.'); ?></td>
                            <td>
                                <a href="" onclick="eliminar_de_lista(<?=$id?>)" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h3>Total: $<?= number_format($total, 2, ',', '.'); ?></h3>
            <div>
                <a href="<?=$ruta?>home" class="btn btn-outline-dark me-2">Seguir comprando</a>
                <a href="<?=$ruta?>carrito/finalizar" class="btn btn-success">Finalizar Compra</a>
            </div>
        </div>
    <?php endif; ?>
</div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>