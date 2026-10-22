<?php 
namespace app\controllers;
use \Controller;
use app\models\UserModel;


class SessionController extends Controller
{
   
    private static function setSession(){
        #SC-01 Al primer ingreso de un usuario al sistema asigna un estado de FALSE a la variable de control STATUS
        if (!isset($_SESSION['SESSION']['STATUS'])) {
            $_SESSION['SESSION']['STATUS'] = false;
        }
    }

    public static function sessionVerificacion(){
        self::setSession();

        #SC-02 Devuelve el estado de session (Logueado o No) del usuario como un string "OnLine" o "OffLine"
        if ($_SESSION['SESSION']['STATUS']) {
            $status = 'Online';
        }else{
            $status = 'OffLine';
        }
        
        return $status;
    }

    public static function setSessionData($userEmailOrID){

        $usuario = UserModel::getUserByEmail($userEmailOrID);
        if (isset($usuario[0]->nombre) && isset($usuario[0]->email)  && isset($usuario[0]->id)) {
            $_SESSION['SESSION']['STATUS'] = true;
            $_SESSION['USER']['name']       = $usuario[0]->nombre;
            $_SESSION['USER']['mail']   = $usuario[0]->email;     
            $_SESSION['USER']['id_usuario'] = $usuario[0]->id;
            $_SESSION['USER']['rol'] = $usuario[0]->rol;
            $result = true;
        }else{
            $result = false;
        }

        return $result;
     }

     public static function getType(){
         return  $_SESSION['USER']['type'];
     }


    public static function onlyAdmins(){
        static::path();
        $continuar = false;
        $ruta = self::$path.'home/404';
        if (self::$sessionStatus === 'OffLine') {
            header("Location: $ruta");
        }elseif(self::$sessionStatus === 'Online'){
            if ($_SESSION['USER']['type'] !=  'administrador') {
                header("Location: $ruta");
            }else{
                $continuar = true;
            }
        }
        return $continuar;

        
    }

    public static function onlyUsers(){
        static::path();
        $continuar = false;

        if(!isset(self::$sessionStatus)){
            echo 'Error en verificacion de sesiones';
        }  
    }

    public static function onlyLogin(){
        static::path();
        $continuar = false;

        if(!isset(self::$sessionStatus)){
            echo 'Error en verificacion de sesiones';
        }else{
            $ruta = self::$path.'account/login/';
            if (self::$sessionStatus === 'OffLine') {
                header("Location: $ruta");
            }elseif(self::$sessionStatus === 'Online'){
                $continuar = true;
            }
            return $continuar;
        }   
    }
}