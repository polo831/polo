<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\ProductoModel;

class ProductosController extends Controller
{

    // Constructor
    public function __construct()
    {
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

    /*recibo el id del producto mediante el parametro*/
    public function actiondetalle($id_producto)
    {
        SessionController::onlyUsers();
        /*sirve para no usar tantos ../ */
        $ruta = self::$path;

        $producto = ProductoModel::obtenerPorId($id_producto);

        /*if (empty($producto)) {
            $ruta = self::$path.'home';
            header("Location: $ruta");
        }*/

        static::path();
        $nombre_de_archivoDeVista = 'detalle';
       $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "producto"=>$producto,
            "ruta"=>$ruta
        ];
        
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }
}