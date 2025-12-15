<?php
/**
 * Controlador Base
 * Todos los controladores heredan de esta clase
 */

defined('BASE_PATH') or exit('Acceso denegado');

class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Renderizar una vista
     */
    protected function view($viewName, $data = []) {
        extract($data);
        $viewPath = VIEWS_PATH . str_replace('.', '/', $viewName) . '.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vista no encontrada: $viewPath");
        }
    }
    
    /**
     * Redirigir a una URL
     */
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit;
    }
    
    /**
     * Verificar si el usuario está autenticado
     */
    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
    }
    
    /**
     * Verificar rol de usuario
     */
    protected function requireRole($roles = []) {
        $this->requireAuth();
        
        if (!in_array($_SESSION['user_role'], $roles)) {
            $this->redirect('error/forbidden');
        }
    }
    
    /**
     * Obtener usuario actual
     */
    protected function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'] ?? '',
                'email' => $_SESSION['email'] ?? '',
                'nombre_completo' => $_SESSION['nombre_completo'] ?? '',
                'rol' => $_SESSION['user_role'] ?? 'ejecutivo'
            ];
        }
        return null;
    }
    
    /**
     * Retornar JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Sanitizar entrada
     */
    protected function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitize($value);
            }
        } else {
            $data = htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }
    
    /**
     * Validar token CSRF
     */
    protected function validateCSRF($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
    
    /**
     * Generar token CSRF
     */
    protected function generateCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
