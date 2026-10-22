<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;
use app\models\ProductoModel;
use app\models\CategoriaModel;

class CarritoController extends Controller
{

    // Constructor
    public function __construct()
    {
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

    public function actionIndex($var = null)
    {
        SessionController::onlyUsers();
        /*sirve para no usar tantos ../ */
        $ruta = self::$path;

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        static::path();
        $nombre_de_archivoDeVista = 'carrito';
       $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "ruta"=>$ruta,
            "total"=>$total,
            // jquery
            "js" => self::loadJS(["path" => self::$path], 'carrito'),
        ];
        
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /*agregar producto carrito mediante jquery*/
    public function actionagregar_producto_lista()
    {    
        $idProducto_para_agregar = $_POST['id_producto'];
        $cantidad_enviada = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

        // Obtenemos los datos del producto por si necesitamos agregarlo por primera vez
        $producto = ProductoModel::obtenerPorId($idProducto_para_agregar);

        if (!$producto) {
            echo json_encode(['status' => false, 'mensaje' => 'Producto no encontrado']);
            return;
        }

        // Si ya existe en el carrito, sumamos a la cantidad actual
        if (isset($_SESSION['carrito'][$idProducto_para_agregar])) {
            $_SESSION['carrito'][$idProducto_para_agregar]['cantidad'] += $cantidad_enviada;
        } else {
            // Si no existe, lo creamos desde cero
            $_SESSION['carrito'][$idProducto_para_agregar] = [
                'id'       => $idProducto_para_agregar,
                'nombre'   => $producto[0]->nombre,
                'precio'   => $producto[0]->precio,
                'cantidad' => $cantidad_enviada
            ];
        }

        $resultado['status'] = true;
        echo json_encode($resultado);
    }

    /*eliminar producto del carrito*/
    public function actioneliminar_lista(){
        // $_SESSION['sub_compra']['productos']
        $idProducto_para_eliminar = $_POST['id_producto'];

        unset($_SESSION['carrito'][$idProducto_para_eliminar]);

        $resultado['status'] = true;

        echo json_encode($resultado);
    }
}