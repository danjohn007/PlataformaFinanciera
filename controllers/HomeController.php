<?php
/**
 * Controlador de Inicio
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class HomeController extends BaseController {
    
    public function index() {
        // Si el usuario está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('dashboard');
        }
        
        // Obtener configuración del sitio
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
        $config = $stmt->fetch();
        
        $data = [
            'title' => 'Inicio',
            'config' => $config
        ];
        
        $this->view('home/index', $data);
    }
}
