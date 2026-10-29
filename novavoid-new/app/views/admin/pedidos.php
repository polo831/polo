<!DOCTYPE html>
<html lang="es">
<head>
    <?= $parametros_de_vista['head'] ?? $head ?? '' ?>
    <title><?= $datos['titulo'] ?? 'Gestión de Pedidos' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f6f9; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .main-content { flex: 1; padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #343a40; color: white; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px; display: inline-block; }
        .btn-info { background: #17a2b8; color: white; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="card">
                <h1><?= $datos['titulo'] ?? 'Pedidos' ?></h1>
                <hr>

                <table>
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Cliente</th>
                            <th>Medio de Pago</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos['pedidos'])): ?>
                            <?php foreach ($datos['pedidos'] as $ped): ?>
                                <tr>
                                    <td>#<?= $ped->id ?></td>
                                    <td><?= htmlspecialchars($ped->cliente_nombre ?? 'Desconocido') ?></td>
                                    <td><?= htmlspecialchars($ped->medio_pago_nombre ?? 'No especificado') ?></td>
                                    <td><strong>$<?= number_format($ped->total, 2, ',', '.') ?></strong></td>
                                    <td><?= htmlspecialchars($ped->fecha) ?></td>
                                    <td>
                                        <a href="<?= $ruta ?>public/index.php?url=admin/detallePedido&id=<?= $ped->id ?>" class="btn btn-info">Ver Detalle</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align: center;">No hay pedidos registrados.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>