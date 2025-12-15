<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto text-center">
            <!-- Hero Section -->
            <div class="mb-12">
                <i class="fas fa-landmark text-8xl text-blue-600 mb-6"></i>
                <h1 class="text-5xl font-bold text-gray-800 mb-4">
                    <?php echo htmlspecialchars($config['nombre_sitio'] ?? SITE_NAME); ?>
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Plataforma Tecnológica Financiera para Instituciones de Crédito Mexicanas
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="<?php echo BASE_URL; ?>/auth/login" class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
                    </a>
                    <a href="<?php echo BASE_URL; ?>/test_connection.php" class="bg-gray-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-700 transition shadow-lg">
                        <i class="fas fa-cog mr-2"></i>Test de Conexión
                    </a>
                </div>
            </div>
            
            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Seguro y Confiable</h3>
                    <p class="text-gray-600">
                        Sistema con altos estándares de seguridad y cumplimiento regulatorio
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Análisis en Tiempo Real</h3>
                    <p class="text-gray-600">
                        Reportes y estadísticas actualizadas para mejor toma de decisiones
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Gestión Integral</h3>
                    <p class="text-gray-600">
                        Administración completa de clientes, créditos y pagos
                    </p>
                </div>
            </div>
            
            <!-- Regulatory Compliance -->
            <div class="mt-16 bg-white p-8 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                    Cumplimiento Regulatorio
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <i class="fas fa-university text-4xl text-blue-600 mb-2"></i>
                        <p class="font-semibold text-gray-800">CNBV</p>
                        <p class="text-sm text-gray-600">Comisión Nacional Bancaria</p>
                    </div>
                    <div>
                        <i class="fas fa-balance-scale text-4xl text-blue-600 mb-2"></i>
                        <p class="font-semibold text-gray-800">CONDUSEF</p>
                        <p class="text-sm text-gray-600">Protección al Usuario</p>
                    </div>
                    <div>
                        <i class="fas fa-coins text-4xl text-blue-600 mb-2"></i>
                        <p class="font-semibold text-gray-800">Banxico</p>
                        <p class="text-sm text-gray-600">Banco de México</p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info -->
            <?php if (!empty($config['telefono_contacto']) || !empty($config['email_sistema'])): ?>
            <div class="mt-12 text-gray-600">
                <p class="mb-2">
                    <i class="fas fa-envelope mr-2"></i>
                    <?php echo htmlspecialchars($config['email_sistema'] ?? ''); ?>
                </p>
                <?php if (!empty($config['telefono_contacto'])): ?>
                <p>
                    <i class="fas fa-phone mr-2"></i>
                    <?php echo htmlspecialchars($config['telefono_contacto']); ?>
                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
