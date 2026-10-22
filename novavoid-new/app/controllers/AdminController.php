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

    /*recibo el id del producto mediante el parametro*/
    public function actionpanel()
    {
        SessionController::onlyUsers();
        /*sirve para no usar tantos ../ */
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
            "datos"=>$datos,
            "ruta"=>$ruta
        ];
        
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }
}