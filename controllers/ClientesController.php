<?php
/**
 * Controlador de Clientes
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class ClientesController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener lista de clientes
        $stmt = $this->db->query("
            SELECT * FROM v_clientes_activos
            ORDER BY created_at DESC
        ");
        $clientes = $stmt->fetchAll();
        
        $data = [
            'title' => 'Gestión de Clientes',
            'user' => $user,
            'clientes' => $clientes
        ];
        
        $this->view('clientes/index', $data);
    }
    
    public function ver($id) {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener información del cliente
        $stmt = $this->db->query("SELECT * FROM clientes WHERE id = ?", [$id]);
        $cliente = $stmt->fetch();
        
        if (!$cliente) {
            $this->redirect('error/notFound');
        }
        
        // Obtener créditos del cliente
        $stmt = $this->db->query("
            SELECT c.*, p.nombre as producto_nombre
            FROM creditos c
            INNER JOIN productos_financieros p ON c.producto_id = p.id
            WHERE c.cliente_id = ?
            ORDER BY c.created_at DESC
        ", [$id]);
        $creditos = $stmt->fetchAll();
        
        $data = [
            'title' => 'Detalles del Cliente',
            'user' => $user,
            'cliente' => $cliente,
            'creditos' => $creditos
        ];
        
        $this->view('clientes/ver', $data);
    }
    
    public function crear() {
        $this->requireRole(['admin', 'gerente', 'ejecutivo']);
        
        $user = $this->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar creación de cliente
            // (Código simplificado, se expandiría en producción)
            $this->redirect('clientes');
        }
        
        $data = [
            'title' => 'Nuevo Cliente',
            'user' => $user,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('clientes/crear', $data);
    }
}
