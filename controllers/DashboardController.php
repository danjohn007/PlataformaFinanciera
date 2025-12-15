<?php
/**
 * Controlador de Dashboard
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class DashboardController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener estadísticas
        $stats = $this->getStatistics();
        
        // Obtener actividades recientes
        $actividades = $this->getRecentActivities();
        
        // Obtener pagos próximos
        $pagosProximos = $this->getUpcomingPayments();
        
        $data = [
            'title' => 'Dashboard',
            'user' => $user,
            'stats' => $stats,
            'actividades' => $actividades,
            'pagos_proximos' => $pagosProximos
        ];
        
        $this->view('dashboard/index', $data);
    }
    
    private function getStatistics() {
        // Cartera total
        $stmt = $this->db->query("SELECT * FROM v_cartera_total");
        $cartera = $stmt->fetch();
        
        // Total clientes activos
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM clientes WHERE estatus = 'Activo'");
        $clientes = $stmt->fetch();
        
        // Pagos del mes
        $stmt = $this->db->query("
            SELECT COUNT(*) as total, SUM(monto_pago) as monto_total 
            FROM pagos 
            WHERE estatus = 'Pagado' 
            AND MONTH(fecha_pago) = MONTH(CURRENT_DATE())
            AND YEAR(fecha_pago) = YEAR(CURRENT_DATE())
        ");
        $pagosMes = $stmt->fetch();
        
        // Créditos solicitados este mes
        $stmt = $this->db->query("
            SELECT COUNT(*) as total 
            FROM creditos 
            WHERE MONTH(fecha_solicitud) = MONTH(CURRENT_DATE())
            AND YEAR(fecha_solicitud) = YEAR(CURRENT_DATE())
        ");
        $solicitudesMes = $stmt->fetch();
        
        return [
            'cartera' => $cartera,
            'clientes' => $clientes,
            'pagos_mes' => $pagosMes,
            'solicitudes_mes' => $solicitudesMes
        ];
    }
    
    private function getRecentActivities() {
        $stmt = $this->db->query("
            SELECT a.*, c.nombre, c.apellido_paterno, u.nombre_completo as responsable
            FROM actividades a
            LEFT JOIN clientes c ON a.cliente_id = c.id
            INNER JOIN usuarios u ON a.usuario_responsable_id = u.id
            WHERE a.completada = 0
            AND a.fecha_inicio >= CURDATE()
            ORDER BY a.fecha_inicio ASC
            LIMIT 5
        ");
        
        return $stmt->fetchAll();
    }
    
    private function getUpcomingPayments() {
        $stmt = $this->db->query("
            SELECT * FROM v_pagos_proximos
            LIMIT 10
        ");
        
        return $stmt->fetchAll();
    }
}
