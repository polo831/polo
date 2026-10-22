<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;
use app\models\ProductoModel;
use app\models\CategoriaModel;

class HomeController extends Controller
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

        /*traer categorias de bd para no hardcodear*/
        $categorias = CategoriaModel::obtenerTodasCategorias();

        // 1. Capturamos la categoría seleccionada desde la URL (ej: ?categoria=remeras)
        $categoriaSeleccionada = $_GET['categoria'] ?? null;

        // 2. Evaluamos si hay un filtro activo o traemos todos los productos
        if ($categoriaSeleccionada) {
            $productos = ProductoModel::obtenerPorCategoria($categoriaSeleccionada);
        } else {
            $productos = ProductoModel::obtenerTodos();
        }

        static::path();
        $nombre_de_archivoDeVista = 'home';
       $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "productos" => $productos,
            "ruta"=>$ruta,
            "categorias"=>$categorias,
            "js" => self::loadJS(["path" => self::$path], 'carrito'),
        ];
        
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }
}