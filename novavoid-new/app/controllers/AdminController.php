<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;

class AdminController extends Controller
{
    // Constructor
    public function __construct()
    {
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

    /* Panel principal del administrador */
    public function actionpanel()
    {
        SessionController::onlyUsers();
        /* sirve para no usar tantos ../ */
        $ruta = self::$path;

        $datos = [
            "titulo" => "Panel de Administración",
            "mensaje" => "Bienvenido al panel de control de tu tienda."
        ];
        
        static::path();
        $nombre_de_archivoDeVista = 'panel';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];
        
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    } // <-- Aquí se cierra correctamente actionpanel()

    /* Listar productos en la gestión (ABM) */
   public function actionProductos()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;

        // Consultamos los productos uniendo la tabla stock mediante LEFT JOIN
        $productos = DataBase::query("
         SELECT p.*, s.cantidad as stock, c.nombre as categoria_nombre 
         FROM productos p 
        LEFT JOIN stock s ON p.id = s.producto_id 
        LEFT JOIN categorias c ON p.categoria_id = c.id
        ORDER BY p.id DESC
        ");
        $datos = [
            "titulo" => "Gestión de Productos",
            "productos" => $productos
        ];

        static::path();
        $nombre_de_archivoDeVista = 'productos'; 
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /* Mostrar formulario para crear un producto nuevo */
    public function actionCrearProducto()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;

        $categorias = DataBase::query("SELECT * FROM categorias");

        $datos = [
            "titulo" => "Nuevo Producto",
            "categorias" => $categorias
        ];

        static::path();
        $nombre_de_archivoDeVista = 'form_producto';
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /* Mostrar formulario para editar un producto existente */


  
    public function actionEditarProducto()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;

        $id = $_GET['id'] ?? null;
        $producto = null;

        if ($id) {
            // Consultamos el producto uniendo la tabla stock con LEFT JOIN
            $resultado = DataBase::query("
                SELECT p.*, s.cantidad as stock 
                FROM productos p 
                LEFT JOIN stock s ON p.id = s.producto_id 
                WHERE p.id = :id
            ", [':id' => $id]);
            $producto = $resultado[0] ?? null;
        }

        $categorias = DataBase::query("SELECT * FROM categorias");

        $datos = [
            "titulo" => "Editar Producto",
            "producto" => $producto,
            "categorias" => $categorias
        ];

        static::path();
        $nombre_de_archivoDeVista = 'form_producto';
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }




    /* Procesar la inserción o actualización de un producto */
    public function actionGuardarProducto()
    {
        SessionController::onlyUsers();
        static::path();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');
            $precio = $_POST['precio'] ?? 0;
            $stockCantidad = $_POST['stock'] ?? 0;
            $categoria_id = $_POST['categoria_id'] ?? null;

            // Manejo de imagen opcional
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = time() . '_' . $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/img/' . $nombreArchivo);
                $imagen = $nombreArchivo;
            }

            if (!empty($id)) {
                // 1. Actualizar datos básicos del producto
                if ($imagen) {
                    $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, categoria_id = :categoria_id, imagen = :imagen WHERE id = :id";
                    DataBase::execute($sql, [':nombre' => $nombre, ':precio' => $precio, ':categoria_id' => $categoria_id, ':imagen' => $imagen, ':id' => $id]);
                } else {
                    $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, categoria_id = :categoria_id WHERE id = :id";
                    DataBase::execute($sql, [':nombre' => $nombre, ':precio' => $precio, ':categoria_id' => $categoria_id, ':id' => $id]);
                }

                // 2. Actualizar o insertar el stock en la tabla stock
                $checkStock = DataBase::query("SELECT id FROM stock WHERE producto_id = :id", [':id' => $id]);
                if (!empty($checkStock)) {
                    DataBase::execute("UPDATE stock SET cantidad = :cantidad WHERE producto_id = :producto_id", [':cantidad' => $stockCantidad, ':producto_id' => $id]);
                } else {
                    DataBase::execute("INSERT INTO stock (producto_id, cantidad) VALUES (:producto_id, :cantidad)", [':producto_id' => $id, ':cantidad' => $stockCantidad]);
                }

            } else {
                // 1. Insertar nuevo producto en la tabla productos
                $sql = "INSERT INTO productos (nombre, precio, categoria_id, imagen) VALUES (:nombre, :precio, :categoria_id, :imagen)";
                DataBase::execute($sql, [
                    ':nombre' => $nombre,
                    ':precio' => $precio,
                    ':categoria_id' => $categoria_id,
                    ':imagen' => $imagen ?? 'no-image.png'
                ]);

                // 2. Obtener el ID del producto recién creado para asignarle su stock
                $nuevoProducto = DataBase::query("SELECT id FROM productos ORDER BY id DESC LIMIT 1");
                $productoId = $nuevoProducto[0]->id ?? null;

                if ($productoId) {
                    DataBase::execute("INSERT INTO stock (producto_id, cantidad) VALUES (:producto_id, :cantidad)", [
                        ':producto_id' => $productoId,
                        ':cantidad' => $stockCantidad
                    ]);
                }
            }

            header("Location: " . self::$path . "index.php?url=admin/productos");
            exit();
        }
    }

    /* Eliminar un producto */
    public function actionEliminarProducto()
    {
        SessionController::onlyUsers();
        static::path();
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            DataBase::execute("DELETE FROM productos WHERE id = :id", [':id' => $id]);
        }

        header("Location: " . self::$path . "index.php?url=admin/productos");
        exit();
    }



   /* 1. Listar usuarios */
    public function actionUsuarios()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;

        $usuarios = DataBase::query("SELECT * FROM usuarios ORDER BY id DESC");

        $datos = [
            "titulo" => "Gestión de Usuarios",
            "usuarios" => $usuarios
        ];

        static::path();
        $nombre_de_archivoDeVista = 'usuarios';
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /* 2. Formulario para crear usuario */
    public function actionCrearUsuario()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;

        $datos = [
            "titulo" => "Nuevo Usuario"
        ];

        static::path();
        $nombre_de_archivoDeVista = 'form_usuario';
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /* 3. Formulario para editar usuario */
    public function actionEditarUsuario()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;
        $id = $_GET['id'] ?? null;
        $usuario = null;

        if ($id) {
            $resultado = DataBase::query("SELECT * FROM usuarios WHERE id = :id", [':id' => $id]);
            $usuario = $resultado[0] ?? null;
        }

        $datos = [
            "titulo" => "Editar Usuario",
            "usuario" => $usuario
        ];

        static::path();
        $nombre_de_archivoDeVista = 'form_usuario';
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /* 4. Guardar o actualizar usuario (La que ya tenías o adaptada a tus campos) */
    public function actionGuardarUsuario()
    {
        SessionController::onlyUsers();
        static::path();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $rol = trim($_POST['rol'] ?? 'cliente');

            if (!empty($id)) {
                if (!empty($password)) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, password = :password, direccion = :direccion, telefono = :telefono, rol = :rol WHERE id = :id";
                    DataBase::execute($sql, [':nombre' => $nombre, ':email' => $email, ':password' => $passwordHash, ':direccion' => $direccion, ':telefono' => $telefono, ':rol' => $rol, ':id' => $id]);
                } else {
                    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, direccion = :direccion, telefono = :telefono, rol = :rol WHERE id = :id";
                    DataBase::execute($sql, [':nombre' => $nombre, ':email' => $email, ':direccion' => $direccion, ':telefono' => $telefono, ':rol' => $rol, ':id' => $id]);
                }
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) VALUES (:nombre, :email, :password, :direccion, :telefono, :rol)";
                DataBase::execute($sql, [
                    ':nombre' => $nombre,
                    ':email' => $email,
                    ':password' => $passwordHash,
                    ':direccion' => $direccion,
                    ':telefono' => $telefono,
                    ':rol' => $rol
                ]);
            }

            header("Location: " . self::$path . "public/index.php?url=admin/usuarios");
            exit();
        }
    }

    /* 5. Eliminar usuario */
    public function actionEliminarUsuario()
    {
        SessionController::onlyUsers();
        static::path();
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            DataBase::execute("DELETE FROM usuarios WHERE id = :id", [':id' => $id]);
        }

        header("Location: " . self::$path . "public/index.php?url=admin/usuarios");
        exit();
    }

    /* 1. Listar todos los pedidos */
    public function actionPedidos()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;

        $sql = "SELECT p.*, u.nombre as cliente_nombre, m.nombre as medio_pago_nombre 
                FROM pedidos p 
                LEFT JOIN usuarios u ON p.usuario_id = u.id 
                LEFT JOIN medios_pago m ON p.medio_pago_id = m.id 
                ORDER BY p.id DESC";
        $pedidos = DataBase::query($sql);

        $datos = [
            "titulo" => "Gestión de Pedidos",
            "pedidos" => $pedidos
        ];

        static::path();
        $nombre_de_archivoDeVista = 'pedidos';
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /* 2. Ver el detalle específico de un pedido */
    public function actionDetallePedido()
    {
        SessionController::onlyUsers();
        $ruta = self::$path;
        $pedido_id = $_GET['id'] ?? null;

        $pedido = null;
        $detalles = [];

        if ($pedido_id) {
            // Datos principales del pedido, cliente y medio de pago
            $sqlPedido = "SELECT p.*, u.nombre as cliente_nombre, u.email as cliente_email, u.direccion as cliente_direccion, m.nombre as medio_pago_nombre 
                          FROM pedidos p 
                          LEFT JOIN usuarios u ON p.usuario_id = u.id 
                          LEFT JOIN medios_pago m ON p.medio_pago_id = m.id 
                          WHERE p.id = :id";
            $resPedido = DataBase::query($sqlPedido, [':id' => $pedido_id]);
            $pedido = $resPedido[0] ?? null;

            // Productos que componen el detalle del pedido uniendo con la tabla productos
            $sqlDetalle = "SELECT dp.*, pr.nombre as producto_nombre, pr.precio as producto_precio 
                           FROM detalle_producto dp 
                           LEFT JOIN productos pr ON dp.producto_id = pr.id 
                           WHERE dp.pedido_id = :pedido_id";
            $detalles = DataBase::query($sqlDetalle, [':pedido_id' => $pedido_id]);
        }

        $datos = [
            "titulo" => "Detalle del Pedido #" . ($pedido_id ?? ''),
            "pedido" => $pedido,
            "detalles" => $detalles
        ];

        static::path();
        $nombre_de_archivoDeVista = 'detallepedido';
        
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "datos" => $datos,
            "ruta" => $ruta
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /* Actualizar estado del pedido y enviar correo de notificación */
    public function actionActualizarEstadoPedido()
    {
        SessionController::onlyUsers();
        static::path();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pedido_id = $_POST['pedido_id'] ?? null;
            $nuevo_estado = $_POST['estado'] ?? 'Pendiente';

            if ($pedido_id) {
                // 1. Actualizar el estado en la base de datos
                $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
                DataBase::execute($sql, [':estado' => $nuevo_estado, ':id' => $pedido_id]);

                // 2. Obtener los datos del cliente y su email para enviarle el correo
                $sqlCliente = "SELECT p.*, u.nombre as cliente_nombre, u.email as cliente_email 
                               FROM pedidos p 
                               LEFT JOIN usuarios u ON p.usuario_id = u.id 
                               WHERE p.id = :id";
                $resultado = DataBase::query($sqlCliente, [':id' => $pedido_id]);
                $pedidoInfo = $resultado[0] ?? null;

                if ($pedidoInfo && !empty($pedidoInfo->cliente_email)) {
                    $para = $pedidoInfo->cliente_email;
                    $asunto = "Actualización de tu Pedido #" . $pedidoInfo->id;
                    $mensaje = "Hola " . $pedidoInfo->cliente_nombre . ",\n\n" .
                               "Te informamos que el estado de tu pedido #" . $pedidoInfo->id . " ha cambiado a: " . $nuevo_estado . ".\n\n" .
                               "Gracias por tu compra en nuestra tienda.";
                    $cabeceras = "From: no-reply@tu-tienda.com\r\n" .
                                 "Reply-To: soporte@tu-tienda.com\r\n" .
                                 "X-Mailer: PHP/" . phpversion();

                    // Enviar correo (Nota: En entorno local con XAMPP puede requerir configuración SMTP)
                    @mail($para, $asunto, $mensaje, $cabeceras);
                }
            }

            // Redirigir de vuelta al detalle del pedido
            header("Location: " . self::$path . "public/index.php?url=admin/detallePedido&id=" . $pedido_id);
            exit();
        }
    }




}