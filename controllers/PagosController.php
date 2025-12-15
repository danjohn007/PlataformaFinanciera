<?php
/**
 * Controlador de Pagos
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class PagosController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener pagos recientes
        $stmt = $this->db->query("
            SELECT p.*, c.numero_credito, cl.nombre, cl.apellido_paterno
            FROM pagos p
            INNER JOIN creditos c ON p.credito_id = c.id
            INNER JOIN clientes cl ON c.cliente_id = cl.id
            ORDER BY p.created_at DESC
            LIMIT 100
        ");
        $pagos = $stmt->fetchAll();
        
        $data = [
            'title' => 'Gestión de Pagos',
            'user' => $user,
            'pagos' => $pagos
        ];
        
        $this->view('pagos/index', $data);
    }
    
    public function registrar() {
        $this->requireRole(['admin', 'gerente', 'ejecutivo', 'contador']);
        
        $user = $this->getCurrentUser();
        
        // Obtener créditos activos
        $stmt = $this->db->query("
            SELECT c.id, c.numero_credito, cl.nombre, cl.apellido_paterno, c.saldo_pendiente
            FROM creditos c
            INNER JOIN clientes cl ON c.cliente_id = cl.id
            WHERE c.estatus = 'En Pago'
            ORDER BY c.numero_credito ASC
        ");
        $creditos = $stmt->fetchAll();
        
        $data = [
            'title' => 'Registrar Pago',
            'user' => $user,
            'creditos' => $creditos,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('pagos/registrar', $data);
    }
    
    public function pendientes() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener pagos pendientes
        $stmt = $this->db->query("SELECT * FROM v_pagos_proximos LIMIT 50");
        $pagosPendientes = $stmt->fetchAll();
        
        $data = [
            'title' => 'Pagos Pendientes',
            'user' => $user,
            'pagos_pendientes' => $pagosPendientes
        ];
        
        $this->view('pagos/pendientes', $data);
    }
}
