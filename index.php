<?php
/**
 * Punto de Entrada Principal del Sistema
 * Plataforma Tecnológica Financiera para Instituciones de Crédito Mexicanas
 */

// Definir la ruta base del proyecto
define('BASE_PATH', __DIR__);

// Auto-detección de URL base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . $host . $script);

// Cargar configuración
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/config/database.php';

// Autoloader simple para clases
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/models/' . $class . '.php',
        BASE_PATH . '/controllers/' . $class . '.php',
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Obtener el controlador y acción de la URL
$request = isset($_GET['url']) ? $_GET['url'] : 'home/index';
$request = rtrim($request, '/');
$request = explode('/', $request);

$controllerName = !empty($request[0]) ? ucfirst($request[0]) . 'Controller' : 'HomeController';
$action = !empty($request[1]) ? $request[1] : 'index';
$params = array_slice($request, 2);

// Verificar si existe el controlador
$controllerPath = CONTROLLERS_PATH . $controllerName . '.php';
if (!file_exists($controllerPath)) {
    $controllerName = 'ErrorController';
    $action = 'notFound';
}

// Instanciar el controlador y ejecutar la acción
require_once CONTROLLERS_PATH . $controllerName . '.php';
$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    $action = 'index';
}

call_user_func_array([$controller, $action], $params);
