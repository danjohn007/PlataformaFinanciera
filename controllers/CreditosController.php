<?php
/**
 * Controlador de Créditos
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class CreditosController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener lista de créditos
        $stmt = $this->db->query("
            SELECT c.*, cl.nombre, cl.apellido_paterno, p.nombre as producto_nombre
            FROM creditos c
            INNER JOIN clientes cl ON c.cliente_id = cl.id
            INNER JOIN productos_financieros p ON c.producto_id = p.id
            ORDER BY c.created_at DESC
            LIMIT 50
        ");
        $creditos = $stmt->fetchAll();
        
        $data = [
            'title' => 'Gestión de Créditos',
            'user' => $user,
            'creditos' => $creditos
        ];
        
        $this->view('creditos/index', $data);
    }
    
    public function ver($id) {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener información del crédito
        $stmt = $this->db->query("
            SELECT c.*, cl.nombre, cl.apellido_paterno, cl.email, cl.telefono,
                   p.nombre as producto_nombre, p.tipo_producto
            FROM creditos c
            INNER JOIN clientes cl ON c.cliente_id = cl.id
            INNER JOIN productos_financieros p ON c.producto_id = p.id
            WHERE c.id = ?
        ", [$id]);
        $credito = $stmt->fetch();
        
        if (!$credito) {
            $this->redirect('error/notFound');
        }
        
        // Obtener pagos del crédito
        $stmt = $this->db->query("
            SELECT * FROM pagos 
            WHERE credito_id = ?
            ORDER BY numero_pago ASC
        ", [$id]);
        $pagos = $stmt->fetchAll();
        
        $data = [
            'title' => 'Detalles del Crédito',
            'user' => $user,
            'credito' => $credito,
            'pagos' => $pagos
        ];
        
        $this->view('creditos/ver', $data);
    }
    
    public function solicitar() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener clientes activos
        $stmt = $this->db->query("
            SELECT id, numero_cliente, nombre, apellido_paterno, apellido_materno
            FROM clientes
            WHERE estatus = 'Activo'
            ORDER BY nombre ASC
        ");
        $clientes = $stmt->fetchAll();
        
        // Obtener productos activos
        $stmt = $this->db->query("
            SELECT * FROM productos_financieros
            WHERE activo = 1
            ORDER BY tipo_producto, nombre ASC
        ");
        $productos = $stmt->fetchAll();
        
        $data = [
            'title' => 'Nueva Solicitud de Crédito',
            'user' => $user,
            'clientes' => $clientes,
            'productos' => $productos,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('creditos/solicitar', $data);
    }
}
