<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;


class AuthController extends Controller
{

    // Constructor
    public function __construct()
    {
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

    /*iniciar sesion*/
    public function actionLogin() {
        /*para que no vuelva a iniciar sesion*/
        if (self::$sessionStatus === "Online") {
            static::path();
            $ruta = self::$path.'index.php?url=home';
            header("Location: $ruta");
        }
        $error = null;
        $mensajeExito = isset($_GET['registrado']) ? "¡Registro exitoso! Ya puedes iniciar sesión." : null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($email) && !empty($password)) {
                $usuario = UserModel::login($email, $password);
                if ($usuario) {
                    /*guarda todos los datos de sesion*/
                    $logueo = SessionController::setSessionData($email);

                    if ($logueo === true) {
                        static::path();
                        $ruta = self::$path.'novavoid-new/app/views/home/home.php';
                        header("Location: $ruta");
                    }
                } else {
                    $error = "Correo electrónico o contraseña incorrectos.";
                }
            } else {
                $error = "Por favor completa todos los campos.";
            }
        }

        static::path();
        $nombre_de_archivoDeVista = 'login';
       $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "error" => $error,
            "ruta" => self::$path,
        ];
        
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /*registrar*/
    public function actionRegister() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmar_password = $_POST['confirmar_password'] ?? '';
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            if (!empty($nombre) && !empty($email) && !empty($password) && !empty($confirmar_password) && !empty($direccion) && !empty($telefono)) {
                
                // 1. Validar que las contraseñas coincidan
                if ($password !== $confirmar_password) {
                    $error = "Las contraseñas no coinciden.";
                } else {
                    // 2. Validar requisitos de seguridad (Mínimo 8 caracteres, 1 mayúscula, 1 número, 1 símbolo)
                    $patron_seguridad = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
                    if (!preg_match($patron_seguridad, $password)) {
                        $error = "La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un símbolo especial.";
                    } else {
                        // 3. Hashear contraseña de forma segura
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                        // 4. Registrar en el modelo (Asegúrate de que UserModel::registrar acepte estos parámetros)
                      // En AuthController.php (acción actionRegister)
                           $exito = UserModel::registrar($nombre, $email, $password, $direccion, $telefono);

                        if ($exito) {
                            static::path();
                            $ruta = self::$path.'auth/login?registrado=1';
                            header("Location: $ruta");
                            exit();
                        } else {
                            $error = "El correo electrónico ya está registrado o hubo un error.";
                        }
                    }
                }
            } else {
                $error = "Por favor completa todos los campos.";
            }
        }

        static::path();
        $nombre_de_archivoDeVista = 'registro';
       $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "error" => $error,
            "ruta" => self::$path,
        ];
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    /*cerrar sesion*/

    public function actionLogout(){
        session_destroy();
        static::path();
        $ruta = self::$path.'auth/login';
        $_SESSION['SESSION']['STATUS'] = false;
        header("Location: $ruta");
    
    }

    /*recuperar contraseña*/
    public function actionProcesarRecuperar() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $nueva_password = $_POST['nueva_password'] ?? '';
            $confirmar_password = $_POST['confirmar_password'] ?? '';

            if ($nueva_password !== $confirmar_password) {
                $error = "Las contraseñas no coinciden.";
            } else {
                $patron_seguridad = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
                if (!preg_match($patron_seguridad, $nueva_password)) {
                    $error = "La nueva contraseña no cumple con los requisitos de seguridad.";
                } else {
                    $passwordHash = password_hash($nueva_password, PASSWORD_DEFAULT);

                    // Actualizar contraseña en el modelo (asegúrate de crear este método en UserModel)
                    // UserModel::actualizarPasswordPorEmail($email, $passwordHash);

                   static::path();
                    $ruta = self::$path.'auth/login?recuperado=1';
                    header("Location: $ruta");
                    exit();
                }
            }
        }
         static::path();
        $nombre_de_archivoDeVista = 'recuperar';
       $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "error" => $error,
            "ruta" => self::$path,
        ];
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }
}