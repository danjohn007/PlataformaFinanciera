-- =====================================================
-- Base de Datos: Plataforma Financiera Mexicana
-- Para Instituciones de Crédito Mexicanas
-- Versión: 1.0.0
-- =====================================================

CREATE DATABASE IF NOT EXISTS plataforma_financiera CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE plataforma_financiera;

-- =====================================================
-- TABLA: Configuración del Sistema
-- =====================================================
CREATE TABLE IF NOT EXISTS configuracion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_sitio VARCHAR(255) DEFAULT 'Plataforma Financiera Mexicana',
    logo_url VARCHAR(500) DEFAULT NULL,
    email_sistema VARCHAR(255) DEFAULT 'info@plataformafinanciera.mx',
    telefono_contacto VARCHAR(50) DEFAULT NULL,
    telefono_secundario VARCHAR(50) DEFAULT NULL,
    horario_atencion TEXT DEFAULT NULL,
    color_primario VARCHAR(7) DEFAULT '#1e40af',
    color_secundario VARCHAR(7) DEFAULT '#3b82f6',
    color_acento VARCHAR(7) DEFAULT '#06b6d4',
    paypal_email VARCHAR(255) DEFAULT NULL,
    paypal_client_id VARCHAR(500) DEFAULT NULL,
    paypal_secret VARCHAR(500) DEFAULT NULL,
    api_qr_key VARCHAR(500) DEFAULT NULL,
    api_qr_url VARCHAR(500) DEFAULT NULL,
    moneda_default VARCHAR(3) DEFAULT 'MXN',
    idioma_default VARCHAR(5) DEFAULT 'es_MX',
    tasa_interes_default DECIMAL(5,2) DEFAULT 15.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar configuración por defecto
INSERT INTO configuracion (nombre_sitio, email_sistema, telefono_contacto, horario_atencion, moneda_default) 
VALUES (
    'Institución Financiera Querétaro',
    'contacto@ifqueretaro.mx',
    '442-123-4567',
    'Lunes a Viernes: 9:00 AM - 6:00 PM, Sábados: 9:00 AM - 2:00 PM',
    'MXN'
);

-- =====================================================
-- TABLA: Usuarios del Sistema
-- =====================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'gerente', 'analista', 'ejecutivo', 'contador', 'auditor') DEFAULT 'ejecutivo',
    telefono VARCHAR(20) DEFAULT NULL,
    activo TINYINT(1) DEFAULT 1,
    ultimo_acceso DATETIME DEFAULT NULL,
    intentos_fallidos INT DEFAULT 0,
    bloqueado_hasta DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar usuarios de ejemplo (password: admin123)
INSERT INTO usuarios (username, email, password_hash, nombre_completo, rol, telefono) VALUES
('admin', 'admin@ifqueretaro.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador del Sistema', 'admin', '442-123-4567'),
('gerente', 'gerente@ifqueretaro.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Juan Carlos Pérez González', 'gerente', '442-123-4568'),
('analista', 'analista@ifqueretaro.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'María Elena Ramírez Torres', 'analista', '442-123-4569');

-- =====================================================
-- TABLA: Clientes
-- =====================================================
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_cliente VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido_paterno VARCHAR(100) NOT NULL,
    apellido_materno VARCHAR(100) DEFAULT NULL,
    curp VARCHAR(18) UNIQUE DEFAULT NULL,
    rfc VARCHAR(13) UNIQUE DEFAULT NULL,
    fecha_nacimiento DATE NOT NULL,
    genero ENUM('M', 'F', 'Otro') DEFAULT NULL,
    estado_civil ENUM('Soltero', 'Casado', 'Divorciado', 'Viudo', 'Union Libre') DEFAULT NULL,
    email VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    telefono_alternativo VARCHAR(20) DEFAULT NULL,
    direccion TEXT NOT NULL,
    colonia VARCHAR(100) DEFAULT NULL,
    ciudad VARCHAR(100) DEFAULT 'Querétaro',
    estado VARCHAR(100) DEFAULT 'Querétaro',
    codigo_postal VARCHAR(10) DEFAULT NULL,
    ocupacion VARCHAR(100) DEFAULT NULL,
    empresa_trabajo VARCHAR(255) DEFAULT NULL,
    ingreso_mensual DECIMAL(15,2) DEFAULT NULL,
    kyc_verificado TINYINT(1) DEFAULT 0,
    kyc_fecha_verificacion DATETIME DEFAULT NULL,
    score_crediticio INT DEFAULT NULL,
    estatus ENUM('Activo', 'Inactivo', 'Suspendido', 'Vetado') DEFAULT 'Activo',
    notas TEXT DEFAULT NULL,
    usuario_registro_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_registro_id) REFERENCES usuarios(id),
    INDEX idx_numero_cliente (numero_cliente),
    INDEX idx_curp (curp),
    INDEX idx_rfc (rfc),
    INDEX idx_estatus (estatus)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar clientes de ejemplo de Querétaro
INSERT INTO clientes (numero_cliente, nombre, apellido_paterno, apellido_materno, curp, rfc, fecha_nacimiento, genero, estado_civil, email, telefono, direccion, colonia, ciudad, estado, codigo_postal, ocupacion, ingreso_mensual, usuario_registro_id) VALUES
('CLI-00001', 'Roberto', 'Hernández', 'López', 'HELR850615HQTPRB01', 'HELR850615XY9', '1985-06-15', 'M', 'Casado', 'roberto.hernandez@email.com', '442-234-5678', 'Av. 5 de Febrero 101', 'Centro', 'Querétaro', 'Querétaro', '76000', 'Ingeniero', 35000.00, 1),
('CLI-00002', 'Ana', 'Martínez', 'Sánchez', 'MASA901020MQTRNNA08', 'MASA901020HG5', '1990-10-20', 'F', 'Soltera', 'ana.martinez@email.com', '442-345-6789', 'Blvd. Bernardo Quintana 200', 'Carretas', 'Querétaro', 'Querétaro', '76050', 'Contador', 28000.00, 1),
('CLI-00003', 'Luis', 'García', 'Ramírez', 'GARL880312HQTRMS09', 'GARL880312RK2', '1988-03-12', 'M', 'Casado', 'luis.garcia@email.com', '442-456-7890', 'Av. Universidad 305', 'Centro Sur', 'Querétaro', 'Querétaro', '76090', 'Comerciante', 42000.00, 1),
('CLI-00004', 'Carmen', 'López', 'Fernández', 'LOFC920805MQTPRR02', 'LOFC920805TY4', '1992-08-05', 'F', 'Soltera', 'carmen.lopez@email.com', '442-567-8901', 'Paseo de la República 150', 'Jurica', 'Querétaro', 'Querétaro', '76100', 'Médico', 55000.00, 1),
('CLI-00005', 'Pedro', 'Flores', 'Morales', 'FOMP870918HQTLRR08', 'FOMP870918LK6', '1987-09-18', 'M', 'Divorciado', 'pedro.flores@email.com', '442-678-9012', 'Av. Zaragoza 420', 'San Pablo', 'Querétaro', 'Querétaro', '76125', 'Abogado', 48000.00, 1);

-- =====================================================
-- TABLA: Productos Financieros
-- =====================================================
CREATE TABLE IF NOT EXISTS productos_financieros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_producto VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    tipo_producto ENUM('Crédito Personal', 'Crédito Hipotecario', 'Crédito Automotriz', 'Crédito PyME', 'Tarjeta Crédito', 'Inversión', 'Ahorro') NOT NULL,
    tasa_interes_anual DECIMAL(5,2) NOT NULL,
    plazo_minimo_meses INT DEFAULT 6,
    plazo_maximo_meses INT DEFAULT 60,
    monto_minimo DECIMAL(15,2) DEFAULT 5000.00,
    monto_maximo DECIMAL(15,2) DEFAULT 500000.00,
    comision_apertura DECIMAL(5,2) DEFAULT 0.00,
    requiere_aval TINYINT(1) DEFAULT 0,
    requiere_garantia TINYINT(1) DEFAULT 0,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_tipo (tipo_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar productos financieros
INSERT INTO productos_financieros (codigo_producto, nombre, descripcion, tipo_producto, tasa_interes_anual, plazo_minimo_meses, plazo_maximo_meses, monto_minimo, monto_maximo, comision_apertura) VALUES
('CRED-PER-01', 'Crédito Personal Express', 'Crédito personal sin garantía para necesidades inmediatas', 'Crédito Personal', 18.50, 6, 36, 5000.00, 100000.00, 3.00),
('CRED-PER-02', 'Crédito Personal Premium', 'Crédito personal con mejores tasas para clientes preferenciales', 'Crédito Personal', 15.00, 12, 48, 20000.00, 250000.00, 2.50),
('CRED-HIP-01', 'Crédito Hipotecario Tradicional', 'Financiamiento para compra de vivienda nueva o usada', 'Crédito Hipotecario', 10.50, 60, 240, 300000.00, 3000000.00, 1.50),
('CRED-AUT-01', 'Crédito Automotriz', 'Financiamiento para compra de vehículo nuevo o seminuevo', 'Crédito Automotriz', 12.00, 12, 60, 50000.00, 800000.00, 2.00),
('CRED-PYM-01', 'Crédito PyME Impulso', 'Financiamiento para pequeñas y medianas empresas', 'Crédito PyME', 16.00, 12, 60, 50000.00, 1000000.00, 3.50);

-- =====================================================
-- TABLA: Créditos/Préstamos
-- =====================================================
CREATE TABLE IF NOT EXISTS creditos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_credito VARCHAR(20) UNIQUE NOT NULL,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    monto_solicitado DECIMAL(15,2) NOT NULL,
    monto_aprobado DECIMAL(15,2) DEFAULT NULL,
    tasa_interes DECIMAL(5,2) NOT NULL,
    plazo_meses INT NOT NULL,
    pago_mensual DECIMAL(15,2) DEFAULT NULL,
    fecha_solicitud DATE NOT NULL,
    fecha_aprobacion DATE DEFAULT NULL,
    fecha_desembolso DATE DEFAULT NULL,
    fecha_vencimiento DATE DEFAULT NULL,
    estatus ENUM('Solicitud', 'En Revisión', 'Aprobado', 'Rechazado', 'Desembolsado', 'En Pago', 'Pagado', 'Vencido', 'Cancelado') DEFAULT 'Solicitud',
    saldo_pendiente DECIMAL(15,2) DEFAULT NULL,
    pagos_realizados INT DEFAULT 0,
    pagos_atrasados INT DEFAULT 0,
    dias_mora INT DEFAULT 0,
    garantia_descripcion TEXT DEFAULT NULL,
    aval_nombre VARCHAR(255) DEFAULT NULL,
    aval_telefono VARCHAR(20) DEFAULT NULL,
    observaciones TEXT DEFAULT NULL,
    usuario_analista_id INT DEFAULT NULL,
    usuario_aprobador_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (producto_id) REFERENCES productos_financieros(id),
    FOREIGN KEY (usuario_analista_id) REFERENCES usuarios(id),
    FOREIGN KEY (usuario_aprobador_id) REFERENCES usuarios(id),
    INDEX idx_numero_credito (numero_credito),
    INDEX idx_cliente (cliente_id),
    INDEX idx_estatus (estatus),
    INDEX idx_fecha_vencimiento (fecha_vencimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar créditos de ejemplo
INSERT INTO creditos (numero_credito, cliente_id, producto_id, monto_solicitado, monto_aprobado, tasa_interes, plazo_meses, pago_mensual, fecha_solicitud, fecha_aprobacion, fecha_desembolso, estatus, saldo_pendiente, usuario_analista_id, usuario_aprobador_id) VALUES
('CRED-2024-001', 1, 1, 50000.00, 50000.00, 18.50, 24, 2500.00, '2024-01-15', '2024-01-20', '2024-01-25', 'En Pago', 35000.00, 3, 2),
('CRED-2024-002', 2, 2, 80000.00, 75000.00, 15.00, 36, 2600.00, '2024-02-10', '2024-02-15', '2024-02-20', 'En Pago', 65000.00, 3, 2),
('CRED-2024-003', 3, 4, 150000.00, 150000.00, 12.00, 48, 3950.00, '2024-03-05', '2024-03-12', '2024-03-15', 'En Pago', 140000.00, 3, 2),
('CRED-2024-004', 4, 3, 850000.00, NULL, 10.50, 180, NULL, '2024-11-20', NULL, NULL, 'En Revisión', NULL, 3, NULL),
('CRED-2024-005', 5, 5, 200000.00, 200000.00, 16.00, 48, 6100.00, '2024-10-01', '2024-10-10', '2024-10-15', 'En Pago', 185000.00, 3, 2);

-- =====================================================
-- TABLA: Pagos
-- =====================================================
CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    credito_id INT NOT NULL,
    numero_pago INT NOT NULL,
    monto_pago DECIMAL(15,2) NOT NULL,
    monto_capital DECIMAL(15,2) NOT NULL,
    monto_interes DECIMAL(15,2) NOT NULL,
    monto_mora DECIMAL(15,2) DEFAULT 0.00,
    fecha_vencimiento DATE NOT NULL,
    fecha_pago DATE DEFAULT NULL,
    metodo_pago ENUM('Efectivo', 'Transferencia', 'Tarjeta', 'Cheque', 'PayPal', 'Domiciliación') DEFAULT NULL,
    referencia_pago VARCHAR(100) DEFAULT NULL,
    estatus ENUM('Pendiente', 'Pagado', 'Parcial', 'Vencido', 'Condonado') DEFAULT 'Pendiente',
    dias_atraso INT DEFAULT 0,
    usuario_registro_id INT DEFAULT NULL,
    observaciones TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (credito_id) REFERENCES creditos(id),
    FOREIGN KEY (usuario_registro_id) REFERENCES usuarios(id),
    INDEX idx_credito (credito_id),
    INDEX idx_estatus (estatus),
    INDEX idx_fecha_vencimiento (fecha_vencimiento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar pagos de ejemplo
INSERT INTO pagos (credito_id, numero_pago, monto_pago, monto_capital, monto_interes, fecha_vencimiento, fecha_pago, metodo_pago, referencia_pago, estatus, usuario_registro_id) VALUES
(1, 1, 2500.00, 1800.00, 700.00, '2024-02-25', '2024-02-25', 'Transferencia', 'TRX-001-2024', 'Pagado', 1),
(1, 2, 2500.00, 1850.00, 650.00, '2024-03-25', '2024-03-26', 'Transferencia', 'TRX-002-2024', 'Pagado', 1),
(1, 3, 2500.00, 1900.00, 600.00, '2024-04-25', NULL, NULL, NULL, 'Pendiente', NULL),
(2, 1, 2600.00, 1900.00, 700.00, '2024-03-20', '2024-03-20', 'Domiciliación', 'DOM-001-2024', 'Pagado', 1),
(2, 2, 2600.00, 1950.00, 650.00, '2024-04-20', NULL, NULL, NULL, 'Pendiente', NULL);

-- =====================================================
-- TABLA: Transacciones
-- =====================================================
CREATE TABLE IF NOT EXISTS transacciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_transaccion ENUM('Desembolso', 'Pago', 'Comisión', 'Interés', 'Mora', 'Ajuste', 'Devolución') NOT NULL,
    credito_id INT DEFAULT NULL,
    cliente_id INT DEFAULT NULL,
    monto DECIMAL(15,2) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    referencia VARCHAR(100) DEFAULT NULL,
    metodo_pago VARCHAR(50) DEFAULT NULL,
    fecha_transaccion DATETIME NOT NULL,
    usuario_registro_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (credito_id) REFERENCES creditos(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (usuario_registro_id) REFERENCES usuarios(id),
    INDEX idx_tipo (tipo_transaccion),
    INDEX idx_fecha (fecha_transaccion),
    INDEX idx_credito (credito_id),
    INDEX idx_cliente (cliente_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLA: Documentos
-- =====================================================
CREATE TABLE IF NOT EXISTS documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_documento ENUM('INE', 'Comprobante Domicilio', 'Comprobante Ingresos', 'Estado Cuenta', 'Contrato', 'Pagaré', 'Otro') NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(500) NOT NULL,
    cliente_id INT DEFAULT NULL,
    credito_id INT DEFAULT NULL,
    tamanio_bytes INT DEFAULT NULL,
    mime_type VARCHAR(100) DEFAULT NULL,
    descripcion TEXT DEFAULT NULL,
    usuario_subida_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (credito_id) REFERENCES creditos(id),
    FOREIGN KEY (usuario_subida_id) REFERENCES usuarios(id),
    INDEX idx_cliente (cliente_id),
    INDEX idx_credito (credito_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLA: Notificaciones
-- =====================================================
CREATE TABLE IF NOT EXISTS notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    mensaje TEXT NOT NULL,
    tipo ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    leida TINYINT(1) DEFAULT 0,
    url_accion VARCHAR(500) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    INDEX idx_usuario (usuario_id),
    INDEX idx_leida (leida)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLA: Auditoría
-- =====================================================
CREATE TABLE IF NOT EXISTS auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT DEFAULT NULL,
    accion VARCHAR(100) NOT NULL,
    tabla_afectada VARCHAR(50) DEFAULT NULL,
    registro_id INT DEFAULT NULL,
    datos_anteriores TEXT DEFAULT NULL,
    datos_nuevos TEXT DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    INDEX idx_usuario (usuario_id),
    INDEX idx_tabla (tabla_afectada),
    INDEX idx_fecha (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLA: Actividades/Eventos
-- =====================================================
CREATE TABLE IF NOT EXISTS actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    tipo_actividad ENUM('Reunión', 'Llamada', 'Visita', 'Seguimiento', 'Cobranza', 'Otro') NOT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME DEFAULT NULL,
    cliente_id INT DEFAULT NULL,
    credito_id INT DEFAULT NULL,
    usuario_responsable_id INT NOT NULL,
    completada TINYINT(1) DEFAULT 0,
    prioridad ENUM('Baja', 'Media', 'Alta', 'Urgente') DEFAULT 'Media',
    observaciones TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (credito_id) REFERENCES creditos(id),
    FOREIGN KEY (usuario_responsable_id) REFERENCES usuarios(id),
    INDEX idx_fecha_inicio (fecha_inicio),
    INDEX idx_usuario (usuario_responsable_id),
    INDEX idx_completada (completada)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar actividades de ejemplo
INSERT INTO actividades (titulo, descripcion, tipo_actividad, fecha_inicio, cliente_id, usuario_responsable_id, prioridad) VALUES
('Seguimiento pago vencido', 'Contactar al cliente para recordar pago pendiente', 'Seguimiento', '2024-12-20 10:00:00', 1, 3, 'Alta'),
('Reunión análisis crédito', 'Revisar solicitud de crédito hipotecario', 'Reunión', '2024-12-18 14:00:00', 4, 2, 'Media'),
('Visita domiciliaria', 'Verificación de domicilio para nuevo crédito', 'Visita', '2024-12-22 09:00:00', 5, 3, 'Media');

-- =====================================================
-- TABLA: Reportes Regulatorios
-- =====================================================
CREATE TABLE IF NOT EXISTS reportes_regulatorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_reporte ENUM('R01', 'R04', 'R06', 'Circular Única', 'CNBV', 'CONDUSEF', 'Otro') NOT NULL,
    periodo VARCHAR(20) NOT NULL,
    fecha_generacion DATE NOT NULL,
    archivo_reporte VARCHAR(500) DEFAULT NULL,
    estatus ENUM('Generado', 'Enviado', 'Aceptado', 'Rechazado') DEFAULT 'Generado',
    observaciones TEXT DEFAULT NULL,
    usuario_genera_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_genera_id) REFERENCES usuarios(id),
    INDEX idx_tipo (tipo_reporte),
    INDEX idx_periodo (periodo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLA: Tasas de Interés Históricas
-- =====================================================
CREATE TABLE IF NOT EXISTS tasas_historicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_tasa VARCHAR(50) NOT NULL,
    valor_tasa DECIMAL(5,2) NOT NULL,
    fecha_vigencia DATE NOT NULL,
    activa TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tipo (tipo_tasa),
    INDEX idx_fecha (fecha_vigencia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar tasas históricas
INSERT INTO tasas_historicas (tipo_tasa, valor_tasa, fecha_vigencia) VALUES
('TIIE_28', 11.25, '2024-01-01'),
('Crédito Personal', 18.50, '2024-01-01'),
('Crédito Hipotecario', 10.50, '2024-01-01'),
('Crédito Automotriz', 12.00, '2024-01-01');

-- =====================================================
-- VISTAS ÚTILES
-- =====================================================

-- Vista de cartera total
CREATE OR REPLACE VIEW v_cartera_total AS
SELECT 
    COUNT(*) as total_creditos,
    SUM(monto_aprobado) as monto_total,
    SUM(saldo_pendiente) as saldo_pendiente_total,
    AVG(tasa_interes) as tasa_promedio,
    COUNT(CASE WHEN estatus = 'En Pago' THEN 1 END) as creditos_activos,
    COUNT(CASE WHEN estatus = 'Vencido' THEN 1 END) as creditos_vencidos,
    COUNT(CASE WHEN dias_mora > 0 THEN 1 END) as creditos_mora
FROM creditos
WHERE estatus IN ('En Pago', 'Vencido');

-- Vista de clientes activos
CREATE OR REPLACE VIEW v_clientes_activos AS
SELECT 
    c.*,
    COUNT(cr.id) as total_creditos,
    SUM(cr.monto_aprobado) as monto_total_creditos,
    SUM(cr.saldo_pendiente) as saldo_pendiente_total
FROM clientes c
LEFT JOIN creditos cr ON c.id = cr.cliente_id
WHERE c.estatus = 'Activo'
GROUP BY c.id;

-- Vista de pagos pendientes próximos
CREATE OR REPLACE VIEW v_pagos_proximos AS
SELECT 
    p.*,
    c.numero_credito,
    cl.nombre,
    cl.apellido_paterno,
    cl.telefono,
    c.tasa_interes
FROM pagos p
INNER JOIN creditos c ON p.credito_id = c.id
INNER JOIN clientes cl ON c.cliente_id = cl.id
WHERE p.estatus = 'Pendiente'
AND p.fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
ORDER BY p.fecha_vencimiento ASC;

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================
