<?php
/**
 * Controlador de Reportes
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class ReportesController extends BaseController {
    
    public function index() {
        $this->requireRole(['admin', 'gerente', 'analista', 'auditor']);
        
        $user = $this->getCurrentUser();
        
        $data = [
            'title' => 'Centro de Reportes',
            'user' => $user
        ];
        
        $this->view('reportes/index', $data);
    }
    
    public function cartera() {
        $this->requireRole(['admin', 'gerente', 'analista', 'auditor']);
        
        $user = $this->getCurrentUser();
        
        // Obtener estadísticas de cartera
        $stmt = $this->db->query("SELECT * FROM v_cartera_total");
        $cartera = $stmt->fetch();
        
        // Cartera por producto
        $stmt = $this->db->query("
            SELECT p.nombre as producto, p.tipo_producto,
                   COUNT(c.id) as total_creditos,
                   SUM(c.monto_aprobado) as monto_total,
                   SUM(c.saldo_pendiente) as saldo_pendiente
            FROM creditos c
            INNER JOIN productos_financieros p ON c.producto_id = p.id
            WHERE c.estatus IN ('En Pago', 'Vencido')
            GROUP BY p.id
        ");
        $carteraPorProducto = $stmt->fetchAll();
        
        $data = [
            'title' => 'Reporte de Cartera',
            'user' => $user,
            'cartera' => $cartera,
            'cartera_por_producto' => $carteraPorProducto
        ];
        
        $this->view('reportes/cartera', $data);
    }
    
    public function cobranza() {
        $this->requireRole(['admin', 'gerente', 'analista']);
        
        $user = $this->getCurrentUser();
        
        // Pagos vencidos
        $stmt = $this->db->query("
            SELECT p.*, c.numero_credito, cl.nombre, cl.apellido_paterno, cl.telefono
            FROM pagos p
            INNER JOIN creditos c ON p.credito_id = c.id
            INNER JOIN clientes cl ON c.cliente_id = cl.id
            WHERE p.estatus IN ('Vencido', 'Pendiente')
            AND p.fecha_vencimiento < CURDATE()
            ORDER BY p.fecha_vencimiento ASC
        ");
        $pagosVencidos = $stmt->fetchAll();
        
        $data = [
            'title' => 'Reporte de Cobranza',
            'user' => $user,
            'pagos_vencidos' => $pagosVencidos
        ];
        
        $this->view('reportes/cobranza', $data);
    }
    
    public function regulatorio() {
        $this->requireRole(['admin', 'gerente', 'auditor']);
        
        $user = $this->getCurrentUser();
        
        // Obtener reportes regulatorios
        $stmt = $this->db->query("
            SELECT r.*, u.nombre_completo as generado_por
            FROM reportes_regulatorios r
            INNER JOIN usuarios u ON r.usuario_genera_id = u.id
            ORDER BY r.created_at DESC
            LIMIT 50
        ");
        $reportes = $stmt->fetchAll();
        
        $data = [
            'title' => 'Reportes Regulatorios',
            'user' => $user,
            'reportes' => $reportes
        ];
        
        $this->view('reportes/regulatorio', $data);
    }
}
