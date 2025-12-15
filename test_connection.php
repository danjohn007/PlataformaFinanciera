<?php
/**
 * Test de Conexión y Verificación de Configuración
 * Este archivo verifica la conectividad a la base de datos y la configuración de URL base
 */

define('BASE_PATH', __DIR__);

// Auto-detección de URL base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script = str_replace('/test_connection.php', '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . $host . $script);

require_once BASE_PATH . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Conexión - Plataforma Financiera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">🔧 Test de Conexión del Sistema</h1>
            
            <!-- Verificación de URL Base -->
            <div class="mb-6 p-4 border-l-4 border-blue-500 bg-blue-50">
                <h2 class="text-xl font-semibold text-blue-800 mb-2">✅ Configuración de URL Base</h2>
                <p class="text-gray-700"><strong>URL Base:</strong> <?php echo BASE_URL; ?></p>
                <p class="text-gray-700"><strong>Protocolo:</strong> <?php echo $protocol; ?></p>
                <p class="text-gray-700"><strong>Host:</strong> <?php echo $host; ?></p>
                <p class="text-gray-700"><strong>Directorio:</strong> <?php echo $script; ?></p>
            </div>

            <!-- Verificación de PHP -->
            <div class="mb-6 p-4 border-l-4 border-green-500 bg-green-50">
                <h2 class="text-xl font-semibold text-green-800 mb-2">✅ Configuración de PHP</h2>
                <p class="text-gray-700"><strong>Versión PHP:</strong> <?php echo phpversion(); ?></p>
                <p class="text-gray-700"><strong>PDO Disponible:</strong> <?php echo extension_loaded('pdo') ? 'Sí' : 'No'; ?></p>
                <p class="text-gray-700"><strong>PDO MySQL:</strong> <?php echo extension_loaded('pdo_mysql') ? 'Sí' : 'No'; ?></p>
            </div>

            <!-- Verificación de Base de Datos -->
            <div class="mb-6 p-4 border-l-4 <?php 
                try {
                    require_once BASE_PATH . '/config/database.php';
                    $db = Database::getInstance();
                    $connection = $db->getConnection();
                    echo 'border-green-500 bg-green-50';
                    $connected = true;
                } catch (Exception $e) {
                    echo 'border-red-500 bg-red-50';
                    $connected = false;
                    $error = $e->getMessage();
                }
            ?>">
                <h2 class="text-xl font-semibold <?php echo $connected ? 'text-green-800' : 'text-red-800'; ?> mb-2">
                    <?php echo $connected ? '✅' : '❌'; ?> Conexión a Base de Datos
                </h2>
                <?php if ($connected): ?>
                    <p class="text-gray-700"><strong>Estado:</strong> Conectado exitosamente</p>
                    <p class="text-gray-700"><strong>Host:</strong> <?php echo DB_HOST; ?></p>
                    <p class="text-gray-700"><strong>Base de Datos:</strong> <?php echo DB_NAME; ?></p>
                    <p class="text-gray-700"><strong>Usuario:</strong> <?php echo DB_USER; ?></p>
                    <?php
                    // Verificar versión de MySQL
                    $version = $connection->query('SELECT VERSION()')->fetchColumn();
                    ?>
                    <p class="text-gray-700"><strong>Versión MySQL:</strong> <?php echo $version; ?></p>
                <?php else: ?>
                    <p class="text-red-700"><strong>Error:</strong> No se pudo conectar a la base de datos</p>
                    <p class="text-red-700 text-sm mt-2"><?php echo $error; ?></p>
                    <div class="mt-4 p-3 bg-yellow-100 rounded">
                        <p class="text-sm text-yellow-800"><strong>Solución:</strong></p>
                        <ol class="list-decimal list-inside text-sm text-yellow-800 mt-2">
                            <li>Verifica que MySQL esté corriendo</li>
                            <li>Revisa las credenciales en config/config.php</li>
                            <li>Ejecuta el archivo database.sql para crear la base de datos</li>
                        </ol>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Verificación de Directorios -->
            <div class="mb-6 p-4 border-l-4 border-purple-500 bg-purple-50">
                <h2 class="text-xl font-semibold text-purple-800 mb-2">📁 Estructura de Directorios</h2>
                <?php
                $directories = ['config', 'models', 'views', 'controllers', 'assets', 'uploads'];
                foreach ($directories as $dir) {
                    $exists = is_dir(BASE_PATH . '/' . $dir);
                    $writable = is_writable(BASE_PATH . '/' . $dir);
                    echo '<p class="text-gray-700">';
                    echo $exists ? '✅' : '❌';
                    echo " <strong>/$dir</strong> - ";
                    echo $exists ? 'Existe' : 'No existe';
                    if ($exists && in_array($dir, ['uploads'])) {
                        echo $writable ? ' (escribible)' : ' (no escribible - ⚠️)';
                    }
                    echo '</p>';
                }
                ?>
            </div>

            <!-- Enlaces de Navegación -->
            <div class="mt-8 flex gap-4">
                <a href="<?php echo BASE_URL; ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Ir al Sistema
                </a>
                <a href="<?php echo BASE_URL; ?>/auth/login" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    Iniciar Sesión
                </a>
            </div>
        </div>
        
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><?php echo SITE_NAME; ?> v<?php echo SITE_VERSION; ?></p>
            <p class="mt-1">⚠️ Este archivo debe ser eliminado en producción por seguridad</p>
        </div>
    </div>
</body>
</html>
