<?php
/**
 * Controlador de Autenticación
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class AuthController extends BaseController {
    
    public function login() {
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('dashboard');
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->sanitize($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $error = 'Por favor, complete todos los campos';
            } else {
                // Buscar usuario
                $stmt = $this->db->query(
                    "SELECT * FROM usuarios WHERE (username = ? OR email = ?) AND activo = 1",
                    [$username, $username]
                );
                $user = $stmt->fetch();
                
                if ($user) {
                    // Verificar si está bloqueado
                    if ($user['bloqueado_hasta'] && strtotime($user['bloqueado_hasta']) > time()) {
                        $error = 'Usuario bloqueado temporalmente. Intente más tarde.';
                    } else {
                        // Verificar contraseña
                        if (password_verify($password, $user['password_hash'])) {
                            // Login exitoso
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['username'] = $user['username'];
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['nombre_completo'] = $user['nombre_completo'];
                            $_SESSION['user_role'] = $user['rol'];
                            
                            // Actualizar último acceso y resetear intentos fallidos
                            $this->db->query(
                                "UPDATE usuarios SET ultimo_acceso = NOW(), intentos_fallidos = 0, bloqueado_hasta = NULL WHERE id = ?",
                                [$user['id']]
                            );
                            
                            // Registrar en auditoría
                            $this->db->query(
                                "INSERT INTO auditoria (usuario_id, accion, ip_address, user_agent) VALUES (?, 'Login exitoso', ?, ?)",
                                [$user['id'], $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '']
                            );
                            
                            $this->redirect('dashboard');
                        } else {
                            // Contraseña incorrecta
                            $intentos = $user['intentos_fallidos'] + 1;
                            
                            if ($intentos >= 5) {
                                // Bloquear por 30 minutos
                                $this->db->query(
                                    "UPDATE usuarios SET intentos_fallidos = ?, bloqueado_hasta = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE id = ?",
                                    [$intentos, $user['id']]
                                );
                                $error = 'Demasiados intentos fallidos. Usuario bloqueado por 30 minutos.';
                            } else {
                                $this->db->query(
                                    "UPDATE usuarios SET intentos_fallidos = ? WHERE id = ?",
                                    [$intentos, $user['id']]
                                );
                                $error = 'Credenciales incorrectas';
                            }
                        }
                    }
                } else {
                    $error = 'Credenciales incorrectas';
                }
            }
        }
        
        $data = [
            'title' => 'Iniciar Sesión',
            'error' => $error
        ];
        
        $this->view('auth/login', $data);
    }
    
    public function logout() {
        // Registrar en auditoría
        if (isset($_SESSION['user_id'])) {
            $this->db->query(
                "INSERT INTO auditoria (usuario_id, accion, ip_address) VALUES (?, 'Logout', ?)",
                [$_SESSION['user_id'], $_SERVER['REMOTE_ADDR'] ?? '']
            );
        }
        
        // Destruir sesión
        session_destroy();
        $this->redirect('auth/login');
    }
}
