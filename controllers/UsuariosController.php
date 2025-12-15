<?php
/**
 * Controlador de Usuarios
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class UsuariosController extends BaseController {
    
    public function index() {
        $this->requireRole(['admin', 'gerente']);
        
        $user = $this->getCurrentUser();
        
        // Obtener lista de usuarios
        $stmt = $this->db->query("
            SELECT id, username, email, nombre_completo, rol, telefono, activo, ultimo_acceso, created_at
            FROM usuarios
            ORDER BY created_at DESC
        ");
        $usuarios = $stmt->fetchAll();
        
        $data = [
            'title' => 'Gestión de Usuarios',
            'user' => $user,
            'usuarios' => $usuarios
        ];
        
        $this->view('usuarios/index', $data);
    }
    
    public function crear() {
        $this->requireRole(['admin']);
        
        $user = $this->getCurrentUser();
        
        $data = [
            'title' => 'Crear Usuario',
            'user' => $user,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('usuarios/crear', $data);
    }
    
    public function perfil() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener datos completos del usuario
        $stmt = $this->db->query("SELECT * FROM usuarios WHERE id = ?", [$user['id']]);
        $userData = $stmt->fetch();
        
        $data = [
            'title' => 'Mi Perfil',
            'user' => $user,
            'userData' => $userData,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('usuarios/perfil', $data);
    }
}
