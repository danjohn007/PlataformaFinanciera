<?php
/**
 * Configuración Principal del Sistema
 * Plataforma Tecnológica Financiera para Instituciones de Crédito Mexicanas
 */

// Prevenir acceso directo
defined('BASE_PATH') or exit('Acceso denegado');

// Configuración de Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'plataforma_financiera');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración de Zona Horaria
date_default_timezone_set('America/Mexico_City');

// Configuración de Sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en producción con HTTPS
session_start();

// Configuración de Errores (Cambiar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de Sistema
define('SITE_NAME', 'Plataforma Financiera Mexicana');
define('SITE_VERSION', '1.0.0');
define('SITE_EMAIL', 'info@plataformafinanciera.mx');

// Rutas del Sistema
define('MODELS_PATH', BASE_PATH . '/models/');
define('VIEWS_PATH', BASE_PATH . '/views/');
define('CONTROLLERS_PATH', BASE_PATH . '/controllers/');
define('UPLOADS_PATH', BASE_PATH . '/uploads/');
define('ASSETS_PATH', BASE_PATH . '/assets/');
