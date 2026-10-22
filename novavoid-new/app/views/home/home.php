<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Void Store</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?=$head?>
    <?=$js?>
</head>
<body class="bg-light">
    <!-- variable para el topbar -->
    <?=$topbar?>
    <!-- Contenido Principal -->
    <div class="container my-5">
        <!-- Encabezado -->
        <div class="text-center mb-5">
            <h1 class="fw-bold">Catálogo Exclusivo</h1>
            <p class="text-muted">Explorá nuestra colección de prendas</p>
        </div>

        <!-- Botones de Filtrado por Categorías -->
        <div class="d-flex justify-content-center gap-2 flex-wrap mb-5">
            <!-- creo los botones con un foreach -->
            <a href="<?=$ruta?>home" class="btn btn-outline-dark btn-sm px-4">Todas</a>
            <?php
                foreach ($categorias as $categoria) {
                    echo '<a href="'.$ruta.'home/index?categoria='.$categoria->id.'" class="btn btn-outline-dark btn-sm px-4">
                            '.$categoria->nombre.'
                        </a>';
                }
            ?>
            <?php foreach ($categorias as $categoria): ?>
                
            <?php endforeach; ?>
        </div>
        <!-- Grilla de Productos -->
        <div class="row">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?=$ruta?>img/productos/<?php echo htmlspecialchars($producto->imagen ?? ''); ?>" 
                                 class="card-img-top" 
                                 style="height: 280px; object-fit: cover;" 
                                 alt="Imagen del producto">
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">
                                 <a href="<?=$ruta?>productos/detalle/<?= $producto->id ?>" class="text-dark text-decoration-none link-secondary">
                                    <?php echo htmlspecialchars($producto->nombre ?? 'Sin nombre'); ?>
                                </a>
                                </h5>
                               
                                <p class="card-text text-muted small"><?php echo htmlspecialchars($producto->descripcion ?? ''); ?></p>
                                
                                <div class="mt-auto">
                                    <p class="fs-5 fw-bold text-dark mb-3">$<?php echo number_format($producto->precio ?? 0, 2, ',', '.'); ?></p>
                                   <a href="#" data-producto="<?= $producto->id ?>" id="agregar" class="btn btn-dark w-100">Comprar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">No hay productos disponibles en esta categoría.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>