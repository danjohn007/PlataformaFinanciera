<?php
/**
 * Controlador de Errores
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class ErrorController extends BaseController {
    
    public function notFound() {
        http_response_code(404);
        $data = [
            'title' => 'Página No Encontrada',
            'message' => 'La página que buscas no existe'
        ];
        $this->view('errors/404', $data);
    }
    
    public function forbidden() {
        http_response_code(403);
        $data = [
            'title' => 'Acceso Denegado',
            'message' => 'No tienes permisos para acceder a esta página'
        ];
        $this->view('errors/403', $data);
    }
    
    public function serverError() {
        http_response_code(500);
        $data = [
            'title' => 'Error del Servidor',
            'message' => 'Ocurrió un error inesperado'
        ];
        $this->view('errors/500', $data);
    }
}
