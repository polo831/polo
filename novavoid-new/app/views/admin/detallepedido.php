<!DOCTYPE html>
<html lang="es">
<head>
    <?= $parametros_de_vista['head'] ?? $head ?? '' ?>
    <title><?= $datos['titulo'] ?? 'Detalle del Pedido' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f6f9; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .main-content { flex: 1; padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #343a40; color: white; }
        .btn { padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px; display: inline-block; }
        .btn-secondary { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <main class="main-content">
            <div class="card">
                <h1><?= $datos['titulo'] ?? 'Detalle de Pedido' ?></h1>
                <hr>
                
                <?php if (!empty($datos['pedido'])): ?>
                    <div class="info-grid">
                        <div>
                            <p><strong>Cliente:</strong> <?= htmlspecialchars($datos['pedido']->cliente_nombre) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($datos['pedido']->cliente_email) ?></p>
                            <p><strong>Dirección de entrega:</strong> <?= htmlspecialchars($datos['pedido']->cliente_direccion) ?></p>
                        </div>
                        <div>
                            <p><strong>Fecha del Pedido:</strong> <?= htmlspecialchars($datos['pedido']->fecha) ?></p>
                            <p><strong>Medio de Pago:</strong> <?= htmlspecialchars($datos['pedido']->medio_pago_nombre) ?></p>
                            <p><strong>Total General:</strong> <span style="color: #28a745; font-size: 1.2em; font-weight: bold;">$<?= number_format($datos['pedido']->total, 2, ',', '.') ?></span></p>
                        </div>
                    </div>

                    <div style="margin-top: 15px; background: #f8f9fa; padding: 15px; border-radius: 6px;">
                    <form action="<?= $ruta ?>public/index.php?url=admin/actualizarEstadoPedido" method="POST">
                    <input type="hidden" name="pedido_id" value="<?= $datos['pedido']->id ?>">
        
                    <div style="margin-bottom: 10px;">
                    <label for="estado" style="font-weight: bold; display: block; margin-bottom: 5px;">Estado del Pedido:</label>
                    <select name="estado" id="estado" style="padding: 6px; width: 100%; max-width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="Pendiente" <?= ($datos['pedido']->estado ?? '') == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="En preparación" <?= ($datos['pedido']->estado ?? '') == 'En preparación' ? 'selected' : '' ?>>En preparación</option>
                    <option value="Enviado" <?= ($datos['pedido']->estado ?? '') == 'Enviado' ? 'selected' : '' ?>>Enviado</option>
                    <option value="Entregado" <?= ($datos['pedido']->estado ?? '') == 'Entregado' ? 'selected' : '' ?>>Entregado</option>
                    <option value="Cancelado" <?= ($datos['pedido']->estado ?? '') == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                 </div>

                    <button type="submit" class="btn" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    ✉️ Actualizar Estado y Enviar Correo
                 </button>
                </form>
            </div>


                <?php else: ?>
                    <p>Pedido no encontrado.</p>
                <?php endif; ?>
            </div>

            <div class="card">
                <h3>Productos Comprados en este Pedido</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($datos['detalles'])): ?>
                            <?php foreach ($datos['detalles'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->producto_nombre ?? 'Producto desconocido') ?></td>
                                    <td>$<?= number_format($item->producto_precio ?? 0, 2, ',', '.') ?></td>
                                    <td><?= $item->cantidad ?></td>
                                    <td><strong>$<?= number_format($item->subtotal, 2, ',', '.') ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align: center;">No hay detalles para este pedido.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    <a href="<?= $ruta ?>public/index.php?url=admin/pedidos" class="btn btn-secondary">← Volver al Listado de Pedidos</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>