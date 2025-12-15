<?php
// Obtener configuración para el header
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <!-- Header del Dashboard -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-chart-line mr-2"></i>Dashboard
        </h1>
        <p class="text-gray-600">Panel de control y estadísticas generales</p>
    </div>
    
    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Cartera Total -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-600">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm">Cartera Total</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        $<?php echo number_format($stats['cartera']['monto_total'] ?? 0, 2); ?>
                    </h3>
                </div>
                <i class="fas fa-wallet text-4xl text-blue-600 opacity-20"></i>
            </div>
            <p class="text-sm text-gray-600">
                <i class="fas fa-file-invoice-dollar mr-1"></i>
                <?php echo $stats['cartera']['total_creditos'] ?? 0; ?> créditos activos
            </p>
        </div>
        
        <!-- Clientes Activos -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-600">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm">Clientes Activos</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        <?php echo number_format($stats['clientes']['total'] ?? 0); ?>
                    </h3>
                </div>
                <i class="fas fa-users text-4xl text-green-600 opacity-20"></i>
            </div>
            <p class="text-sm text-gray-600">
                <i class="fas fa-user-check mr-1"></i>
                Total de clientes
            </p>
        </div>
        
        <!-- Pagos del Mes -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-purple-600">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm">Pagos del Mes</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        $<?php echo number_format($stats['pagos_mes']['monto_total'] ?? 0, 2); ?>
                    </h3>
                </div>
                <i class="fas fa-credit-card text-4xl text-purple-600 opacity-20"></i>
            </div>
            <p class="text-sm text-gray-600">
                <i class="fas fa-check-circle mr-1"></i>
                <?php echo $stats['pagos_mes']['total'] ?? 0; ?> pagos recibidos
            </p>
        </div>
        
        <!-- Solicitudes del Mes -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-orange-600">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm">Solicitudes del Mes</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        <?php echo $stats['solicitudes_mes']['total'] ?? 0; ?>
                    </h3>
                </div>
                <i class="fas fa-file-alt text-4xl text-orange-600 opacity-20"></i>
            </div>
            <p class="text-sm text-gray-600">
                <i class="fas fa-calendar-alt mr-1"></i>
                Nuevas solicitudes
            </p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Gráfica de Cartera -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-pie mr-2"></i>Distribución de Cartera
            </h3>
            <canvas id="carteraChart" height="250"></canvas>
        </div>
        
        <!-- Gráfica de Morosidad -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-bar mr-2"></i>Estado de Cartera
            </h3>
            <canvas id="morosidadChart" height="250"></canvas>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Actividades Pendientes -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-tasks mr-2"></i>Actividades Pendientes
            </h3>
            <?php if (empty($actividades)): ?>
                <p class="text-gray-600 text-center py-4">No hay actividades pendientes</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($actividades as $act): ?>
                    <div class="border-l-4 border-blue-600 bg-blue-50 p-4 rounded">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($act['titulo']); ?></h4>
                            <span class="text-xs px-2 py-1 rounded <?php 
                                echo $act['prioridad'] === 'Urgente' ? 'bg-red-100 text-red-800' : 
                                    ($act['prioridad'] === 'Alta' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800');
                            ?>">
                                <?php echo $act['prioridad']; ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2"><?php echo htmlspecialchars($act['descripcion']); ?></p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span><i class="fas fa-user mr-1"></i><?php echo htmlspecialchars($act['responsable']); ?></span>
                            <span><i class="fas fa-clock mr-1"></i><?php echo date('d/m/Y H:i', strtotime($act['fecha_inicio'])); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagos Próximos -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-calendar-check mr-2"></i>Pagos Próximos
            </h3>
            <?php if (empty($pagos_proximos)): ?>
                <p class="text-gray-600 text-center py-4">No hay pagos próximos</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach (array_slice($pagos_proximos, 0, 5) as $pago): ?>
                    <div class="flex justify-between items-center border-b pb-3">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">
                                <?php echo htmlspecialchars($pago['nombre'] . ' ' . $pago['apellido_paterno']); ?>
                            </p>
                            <p class="text-sm text-gray-600">
                                <?php echo htmlspecialchars($pago['numero_credito']); ?>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">$<?php echo number_format($pago['monto_pago'], 2); ?></p>
                            <p class="text-xs text-gray-600"><?php echo date('d/m/Y', strtotime($pago['fecha_vencimiento'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?php echo BASE_URL; ?>/pagos/pendientes" class="block text-center mt-4 text-blue-600 hover:text-blue-800">
                    Ver todos <i class="fas fa-arrow-right ml-1"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Gráfica de Cartera
const ctxCartera = document.getElementById('carteraChart').getContext('2d');
new Chart(ctxCartera, {
    type: 'doughnut',
    data: {
        labels: ['Créditos Activos', 'Créditos Vencidos', 'Saldo Pendiente'],
        datasets: [{
            data: [
                <?php echo $stats['cartera']['creditos_activos'] ?? 0; ?>,
                <?php echo $stats['cartera']['creditos_vencidos'] ?? 0; ?>,
                <?php echo $stats['cartera']['creditos_mora'] ?? 0; ?>
            ],
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfica de Morosidad
const ctxMorosidad = document.getElementById('morosidadChart').getContext('2d');
new Chart(ctxMorosidad, {
    type: 'bar',
    data: {
        labels: ['Al Corriente', 'Mora 1-30 días', 'Mora 31-60 días', 'Mora +60 días'],
        datasets: [{
            label: 'Número de Créditos',
            data: [
                <?php echo ($stats['cartera']['creditos_activos'] ?? 0) - ($stats['cartera']['creditos_mora'] ?? 0); ?>,
                <?php echo floor(($stats['cartera']['creditos_mora'] ?? 0) * 0.5); ?>,
                <?php echo floor(($stats['cartera']['creditos_mora'] ?? 0) * 0.3); ?>,
                <?php echo floor(($stats['cartera']['creditos_mora'] ?? 0) * 0.2); ?>
            ],
            backgroundColor: ['#10b981', '#f59e0b', '#f97316', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
