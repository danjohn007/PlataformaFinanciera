<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-chart-bar mr-2"></i>Centro de Reportes
        </h1>
        <p class="text-gray-600">Análisis y reportes del sistema financiero</p>
    </div>
    
    <!-- Grid de Reportes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Reporte de Cartera -->
        <a href="<?php echo BASE_URL; ?>/reportes/cartera" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border-l-4 border-blue-600">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-wallet text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Reporte de Cartera</h3>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Análisis completo de la cartera de créditos, distribución por producto y saldos pendientes
            </p>
            <div class="flex items-center text-sm text-blue-600 font-semibold">
                Ver Reporte <i class="fas fa-arrow-right ml-2"></i>
            </div>
        </a>
        
        <!-- Reporte de Cobranza -->
        <a href="<?php echo BASE_URL; ?>/reportes/cobranza" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border-l-4 border-red-600">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 p-3 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Reporte de Cobranza</h3>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Pagos vencidos, cartera en mora y seguimiento de cobranza
            </p>
            <div class="flex items-center text-sm text-red-600 font-semibold">
                Ver Reporte <i class="fas fa-arrow-right ml-2"></i>
            </div>
        </a>
        
        <!-- Reportes Regulatorios -->
        <a href="<?php echo BASE_URL; ?>/reportes/regulatorio" class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border-l-4 border-purple-600">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-file-contract text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Reportes Regulatorios</h3>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Reportes para CNBV, CONDUSEF y cumplimiento normativo
            </p>
            <div class="flex items-center text-sm text-purple-600 font-semibold">
                Ver Reporte <i class="fas fa-arrow-right ml-2"></i>
            </div>
        </a>
        
        <!-- Reporte de Ingresos -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-600">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-dollar-sign text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Reporte de Ingresos</h3>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Análisis de ingresos por intereses, comisiones y pagos recibidos
            </p>
            <div class="flex items-center text-sm text-gray-500 font-semibold">
                Próximamente <i class="fas fa-clock ml-2"></i>
            </div>
        </div>
        
        <!-- Reporte de Clientes -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-yellow-600">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <i class="fas fa-users text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Reporte de Clientes</h3>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Estadísticas de clientes, nuevos registros y análisis demográfico
            </p>
            <div class="flex items-center text-sm text-gray-500 font-semibold">
                Próximamente <i class="fas fa-clock ml-2"></i>
            </div>
        </div>
        
        <!-- Reporte de Morosidad -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-orange-600">
            <div class="flex items-center mb-4">
                <div class="bg-orange-100 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-3xl text-orange-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 ml-4">Reporte de Morosidad</h3>
            </div>
            <p class="text-gray-600 text-sm mb-3">
                Análisis de morosidad, días de atraso y proyecciones
            </p>
            <div class="flex items-center text-sm text-gray-500 font-semibold">
                Próximamente <i class="fas fa-clock ml-2"></i>
            </div>
        </div>
    </div>
    
    <!-- Información Adicional -->
    <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
        <h3 class="text-lg font-bold text-blue-800 mb-2">
            <i class="fas fa-info-circle mr-2"></i>Acerca de los Reportes
        </h3>
        <ul class="text-blue-700 text-sm space-y-2">
            <li><i class="fas fa-check mr-2"></i>Todos los reportes se actualizan en tiempo real</li>
            <li><i class="fas fa-check mr-2"></i>Puede exportar los reportes a PDF y Excel</li>
            <li><i class="fas fa-check mr-2"></i>Los reportes regulatorios cumplen con normativa mexicana</li>
            <li><i class="fas fa-check mr-2"></i>Acceso restringido según rol de usuario</li>
        </ul>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
