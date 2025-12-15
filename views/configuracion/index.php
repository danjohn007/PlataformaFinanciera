<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-cog mr-2"></i>Módulo de Configuraciones
        </h1>
        <p class="text-gray-600">Configure todos los aspectos del sistema</p>
    </div>
    
    <!-- Grid de Opciones de Configuración -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Configuración General -->
        <a href="<?php echo BASE_URL; ?>/configuracion/general" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-200 border-l-4 border-blue-600">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-building text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Configuración General</h3>
            </div>
            <p class="text-gray-600 text-sm">
                Nombre del sitio, correo del sistema, teléfonos de contacto y horarios de atención
            </p>
        </a>
        
        <!-- Logo del Sistema -->
        <a href="<?php echo BASE_URL; ?>/configuracion/logo" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-200 border-l-4 border-purple-600">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-image text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Logo del Sistema</h3>
            </div>
            <p class="text-gray-600 text-sm">
                Suba y configure el logotipo que se mostrará en el sistema
            </p>
        </a>
        
        <!-- Configuración de Colores -->
        <a href="<?php echo BASE_URL; ?>/configuracion/colores" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-200 border-l-4 border-pink-600">
            <div class="flex items-center mb-4">
                <div class="bg-pink-100 p-3 rounded-lg">
                    <i class="fas fa-palette text-3xl text-pink-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Colores del Sistema</h3>
            </div>
            <p class="text-gray-600 text-sm">
                Personalice los colores principales, secundarios y de acento del sistema
            </p>
        </a>
        
        <!-- Configuración de PayPal -->
        <a href="<?php echo BASE_URL; ?>/configuracion/paypal" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-200 border-l-4 border-yellow-600">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <i class="fab fa-paypal text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Configuración PayPal</h3>
            </div>
            <p class="text-gray-600 text-sm">
                Configure la cuenta principal de PayPal para procesar pagos
            </p>
        </a>
        
        <!-- API de Códigos QR -->
        <a href="<?php echo BASE_URL; ?>/configuracion/apiQr" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-200 border-l-4 border-green-600">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-qrcode text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">API de Códigos QR</h3>
            </div>
            <p class="text-gray-600 text-sm">
                Configure la API para generar códigos QR masivos para pagos
            </p>
        </a>
        
        <!-- Configuraciones Globales -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-gray-600">
            <div class="flex items-center mb-4">
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-sliders-h text-3xl text-gray-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Configuraciones Globales</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">
                Parámetros recomendados del sistema
            </p>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Moneda:</span>
                    <span class="font-semibold"><?php echo $config['moneda_default'] ?? 'MXN'; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tasa de Interés Base:</span>
                    <span class="font-semibold"><?php echo $config['tasa_interes_default'] ?? 15.00; ?>%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Idioma:</span>
                    <span class="font-semibold"><?php echo $config['idioma_default'] ?? 'es_MX'; ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información Actual del Sistema -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-info-circle mr-2"></i>Información Actual del Sistema
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Nombre del Sitio</p>
                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($config['nombre_sitio'] ?? SITE_NAME); ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Email del Sistema</p>
                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($config['email_sistema'] ?? SITE_EMAIL); ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Teléfono Principal</p>
                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($config['telefono_contacto'] ?? 'No configurado'); ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Color Primario</p>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded mr-2" style="background-color: <?php echo $config['color_primario'] ?? '#1e40af'; ?>"></div>
                    <span class="font-semibold text-gray-800"><?php echo $config['color_primario'] ?? '#1e40af'; ?></span>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Última Actualización</p>
                <p class="font-semibold text-gray-800">
                    <?php echo isset($config['updated_at']) ? date('d/m/Y H:i', strtotime($config['updated_at'])) : 'N/A'; ?>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Estado del Sistema</p>
                <p class="font-semibold text-green-600">
                    <i class="fas fa-check-circle mr-1"></i>Operacional
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
