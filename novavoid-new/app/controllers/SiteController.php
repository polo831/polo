<?php 
namespace app\controllers;
use \Controller;

class SiteController extends Controller
{
    // Constructor
    public function __construct(){
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

	public static function head(){
		static::ruta();
		$camino = self::$ruta;
		$camino = str_replace('&', '', $camino);
		$head = file_get_contents(APP_PATH.'/views/inc/head.php');
		$head = str_replace('#PATH#', $camino, $head);
		return $head;
	}

	public static function menu() {
	    static::path();
	    $menu = file_get_contents(APP_PATH . '/views/inc/menu-usuario.php');

	    // Obtener el número del mes actual
	    $numero_mes = date('n'); // 1-12
	    $arr = array(
	        "#PATH#" => self::$path,
	        "#MES_NUMERO#" => $numero_mes, // Agregar el número del mes
	    );

	    $menu = strtr($menu, $arr);
	    return $menu;
	}


    public static function menu_res(){
		static::path();
	    $menu = file_get_contents(APP_PATH.'/views/inc/menu-usuario-res.php');
		
		$arr = array(
		    "#PATH#" 	=> self::$path,
		);
		$menu = strtr($menu,$arr);
		return $menu;
	}


	public static function header($from_request = null){
	}

	public static function topbar() {
	    static::path();
	    
	    $filePath = APP_PATH . '/views/inc/topbar.php';
	    if (!file_exists($filePath)) {
	        return '';
	    }
	    
	    $topbar = file_get_contents($filePath);
	    
	    // Obtener los datos de sesión de forma segura
	    $nombreUsuario = isset($_SESSION['USER']['name']) ? htmlspecialchars($_SESSION['USER']['name']) : 'Usuario';
	    
	    // Construir dinámicamente el fragmento HTML según la sesión
	 if (isset($_SESSION['USER']['id_usuario'])) {
            $authSection = '
                <li class="nav-item">
                    <span class="navbar-text fw-semibold text-light me-1">Hola, ' . $nombreUsuario . '</span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm px-3" href="' . static::$path . 'index.php?url=auth/logout">Cerrar Sesión</a>
                </li>';
        } else {
            $authSection = '
                <li class="nav-item">
                    <a class="btn btn-light btn-sm px-3 fw-bold" href="' . static::$path . 'index.php?url=auth/login">Iniciar Sesión</a>
                </li>';
        }

	    // Array de reemplazo para strtr manteniendo tu estructura original
	    $arr = array(
	        "#PATH#"         => static::$path,
	        "#AUTH_SECTION#" => $authSection,
	        "#USER_NAME#"    => $nombreUsuario
	    );
	    
	    $topbar = strtr($topbar, $arr);
	    return $topbar;
	}

	public static function footer(){
		static::path();
		$var = '';
		$footer = file_get_contents(APP_PATH.'/views/inc/footer.php');
		$footer_registro = 'un dato';
		$arr = array(
		    "#var#"		=> $var,
		    "#FOOTER_DATO#" => $footer_registro,
		    "#PATH#" 			=> self::$path);
		$footer = strtr($footer,$arr);
		return $footer;
	}

}
