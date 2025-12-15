<?php
/**
 * Controlador de Configuración
 * MÓDULO DE CONFIGURACIONES del Sistema
 */

defined('BASE_PATH') or exit('Acceso denegado');

require_once CONTROLLERS_PATH . 'BaseController.php';

class ConfiguracionController extends BaseController {
    
    public function index() {
        $this->requireRole(['admin', 'gerente']);
        
        $user = $this->getCurrentUser();
        
        // Obtener configuración actual
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
        $config = $stmt->fetch();
        
        $data = [
            'title' => 'Configuración del Sistema',
            'user' => $user,
            'config' => $config,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('configuracion/index', $data);
    }
    
    public function general() {
        $this->requireRole(['admin']);
        
        $user = $this->getCurrentUser();
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
                $message = 'Token CSRF inválido';
                $messageType = 'error';
            } else {
                $nombre_sitio = $this->sanitize($_POST['nombre_sitio'] ?? '');
                $email_sistema = $this->sanitize($_POST['email_sistema'] ?? '');
                $telefono_contacto = $this->sanitize($_POST['telefono_contacto'] ?? '');
                $telefono_secundario = $this->sanitize($_POST['telefono_secundario'] ?? '');
                $horario_atencion = $this->sanitize($_POST['horario_atencion'] ?? '');
                $moneda_default = $this->sanitize($_POST['moneda_default'] ?? 'MXN');
                $tasa_interes_default = $this->sanitize($_POST['tasa_interes_default'] ?? 15.00);
                
                // Actualizar configuración
                $result = $this->db->query("
                    UPDATE configuracion SET 
                    nombre_sitio = ?,
                    email_sistema = ?,
                    telefono_contacto = ?,
                    telefono_secundario = ?,
                    horario_atencion = ?,
                    moneda_default = ?,
                    tasa_interes_default = ?
                    WHERE id = 1
                ", [
                    $nombre_sitio, 
                    $email_sistema, 
                    $telefono_contacto, 
                    $telefono_secundario,
                    $horario_atencion,
                    $moneda_default,
                    $tasa_interes_default
                ]);
                
                if ($result) {
                    // Registrar en auditoría
                    $this->db->query("
                        INSERT INTO auditoria (usuario_id, accion, tabla_afectada, registro_id) 
                        VALUES (?, 'Actualización configuración general', 'configuracion', 1)
                    ", [$user['id']]);
                    
                    $message = 'Configuración actualizada correctamente';
                    $messageType = 'success';
                } else {
                    $message = 'Error al actualizar la configuración';
                    $messageType = 'error';
                }
            }
        }
        
        // Obtener configuración actual
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
        $config = $stmt->fetch();
        
        $data = [
            'title' => 'Configuración General',
            'user' => $user,
            'config' => $config,
            'message' => $message,
            'messageType' => $messageType,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('configuracion/general', $data);
    }
    
    public function logo() {
        $this->requireRole(['admin']);
        
        $user = $this->getCurrentUser();
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
                $message = 'Token CSRF inválido';
                $messageType = 'error';
            } else {
                // Manejar subida de archivo
                if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
                    $fileType = $_FILES['logo']['type'];
                    
                    if (!in_array($fileType, $allowedTypes)) {
                        $message = 'Tipo de archivo no permitido. Solo se permiten JPG, PNG, GIF y SVG';
                        $messageType = 'error';
                    } else {
                        $uploadDir = UPLOADS_PATH . 'logos/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        
                        $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                        $filename = 'logo_' . time() . '.' . $extension;
                        $uploadPath = $uploadDir . $filename;
                        
                        if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
                            $logoUrl = '/uploads/logos/' . $filename;
                            
                            // Actualizar en base de datos
                            $this->db->query("UPDATE configuracion SET logo_url = ? WHERE id = 1", [$logoUrl]);
                            
                            // Registrar en auditoría
                            $this->db->query("
                                INSERT INTO auditoria (usuario_id, accion, tabla_afectada, registro_id) 
                                VALUES (?, 'Actualización de logo', 'configuracion', 1)
                            ", [$user['id']]);
                            
                            $message = 'Logo actualizado correctamente';
                            $messageType = 'success';
                        } else {
                            $message = 'Error al subir el archivo';
                            $messageType = 'error';
                        }
                    }
                } else {
                    $message = 'No se seleccionó ningún archivo o hubo un error en la subida';
                    $messageType = 'error';
                }
            }
        }
        
        // Obtener configuración actual
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
        $config = $stmt->fetch();
        
        $data = [
            'title' => 'Configuración de Logo',
            'user' => $user,
            'config' => $config,
            'message' => $message,
            'messageType' => $messageType,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('configuracion/logo', $data);
    }
    
    public function colores() {
        $this->requireRole(['admin']);
        
        $user = $this->getCurrentUser();
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
                $message = 'Token CSRF inválido';
                $messageType = 'error';
            } else {
                $color_primario = $this->sanitize($_POST['color_primario'] ?? '#1e40af');
                $color_secundario = $this->sanitize($_POST['color_secundario'] ?? '#3b82f6');
                $color_acento = $this->sanitize($_POST['color_acento'] ?? '#06b6d4');
                
                // Actualizar colores
                $this->db->query("
                    UPDATE configuracion SET 
                    color_primario = ?,
                    color_secundario = ?,
                    color_acento = ?
                    WHERE id = 1
                ", [$color_primario, $color_secundario, $color_acento]);
                
                // Registrar en auditoría
                $this->db->query("
                    INSERT INTO auditoria (usuario_id, accion, tabla_afectada, registro_id) 
                    VALUES (?, 'Actualización de colores del sistema', 'configuracion', 1)
                ", [$user['id']]);
                
                $message = 'Colores actualizados correctamente';
                $messageType = 'success';
            }
        }
        
        // Obtener configuración actual
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
        $config = $stmt->fetch();
        
        $data = [
            'title' => 'Configuración de Colores',
            'user' => $user,
            'config' => $config,
            'message' => $message,
            'messageType' => $messageType,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('configuracion/colores', $data);
    }
    
    public function paypal() {
        $this->requireRole(['admin']);
        
        $user = $this->getCurrentUser();
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
                $message = 'Token CSRF inválido';
                $messageType = 'error';
            } else {
                $paypal_email = $this->sanitize($_POST['paypal_email'] ?? '');
                $paypal_client_id = $this->sanitize($_POST['paypal_client_id'] ?? '');
                $paypal_secret = $this->sanitize($_POST['paypal_secret'] ?? '');
                
                // Actualizar PayPal
                $this->db->query("
                    UPDATE configuracion SET 
                    paypal_email = ?,
                    paypal_client_id = ?,
                    paypal_secret = ?
                    WHERE id = 1
                ", [$paypal_email, $paypal_client_id, $paypal_secret]);
                
                // Registrar en auditoría
                $this->db->query("
                    INSERT INTO auditoria (usuario_id, accion, tabla_afectada, registro_id) 
                    VALUES (?, 'Actualización configuración PayPal', 'configuracion', 1)
                ", [$user['id']]);
                
                $message = 'Configuración de PayPal actualizada correctamente';
                $messageType = 'success';
            }
        }
        
        // Obtener configuración actual
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
        $config = $stmt->fetch();
        
        $data = [
            'title' => 'Configuración de PayPal',
            'user' => $user,
            'config' => $config,
            'message' => $message,
            'messageType' => $messageType,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('configuracion/paypal', $data);
    }
    
    public function apiQr() {
        $this->requireRole(['admin']);
        
        $user = $this->getCurrentUser();
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
                $message = 'Token CSRF inválido';
                $messageType = 'error';
            } else {
                $api_qr_url = $this->sanitize($_POST['api_qr_url'] ?? '');
                $api_qr_key = $this->sanitize($_POST['api_qr_key'] ?? '');
                
                // Actualizar API QR
                $this->db->query("
                    UPDATE configuracion SET 
                    api_qr_url = ?,
                    api_qr_key = ?
                    WHERE id = 1
                ", [$api_qr_url, $api_qr_key]);
                
                // Registrar en auditoría
                $this->db->query("
                    INSERT INTO auditoria (usuario_id, accion, tabla_afectada, registro_id) 
                    VALUES (?, 'Actualización configuración API QR', 'configuracion', 1)
                ", [$user['id']]);
                
                $message = 'Configuración de API QR actualizada correctamente';
                $messageType = 'success';
            }
        }
        
        // Obtener configuración actual
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE id = 1");
        $config = $stmt->fetch();
        
        $data = [
            'title' => 'Configuración de API QR',
            'user' => $user,
            'config' => $config,
            'message' => $message,
            'messageType' => $messageType,
            'csrf_token' => $this->generateCSRF()
        ];
        
        $this->view('configuracion/api_qr', $data);
    }
}
