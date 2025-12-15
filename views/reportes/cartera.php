<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="mb-8">
        <a href="<?php echo BASE_URL; ?>/reportes" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Volver a Reportes
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-wallet mr-2"></i>Reporte de Cartera
        </h1>
        <p class="text-gray-600">Análisis completo de la cartera de créditos</p>
    </div>
    
    <!-- Estadísticas Principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-600">
            <p class="text-gray-600 text-sm">Total Créditos</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo $cartera['total_creditos'] ?? 0; ?></p>
            <p class="text-sm text-gray-500 mt-1">Activos</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-600">
            <p class="text-gray-600 text-sm">Monto Total</p>
            <p class="text-3xl font-bold text-gray-800">
                $<?php echo number_format($cartera['monto_total'] ?? 0, 0); ?>
            </p>
            <p class="text-sm text-gray-500 mt-1">MXN</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-orange-600">
            <p class="text-gray-600 text-sm">Saldo Pendiente</p>
            <p class="text-3xl font-bold text-gray-800">
                $<?php echo number_format($cartera['saldo_pendiente_total'] ?? 0, 0); ?>
            </p>
            <p class="text-sm text-gray-500 mt-1">Por cobrar</p>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-red-600">
            <p class="text-gray-600 text-sm">En Mora</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo $cartera['creditos_mora'] ?? 0; ?></p>
            <p class="text-sm text-gray-500 mt-1">Créditos</p>
        </div>
    </div>
    
    <!-- Distribución por Producto -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            <i class="fas fa-chart-pie mr-2"></i>Distribución por Producto
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Créditos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Saldo Pendiente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">% Cartera</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($cartera_por_producto)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No hay datos disponibles
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($cartera_por_producto as $producto): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-800">
                                    <?php echo htmlspecialchars($producto['producto']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($producto['tipo_producto']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?php echo $producto['total_creditos']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                                $<?php echo number_format($producto['monto_total'], 2); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                                $<?php echo number_format($producto['saldo_pendiente'], 2); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php 
                                $porcentaje = ($cartera['monto_total'] > 0) 
                                    ? ($producto['monto_total'] / $cartera['monto_total']) * 100 
                                    : 0;
                                ?>
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo $porcentaje; ?>%"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">
                                        <?php echo number_format($porcentaje, 1); ?>%
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Gráfica de Distribución -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            <i class="fas fa-chart-bar mr-2"></i>Gráfica de Distribución de Cartera
        </h2>
        <canvas id="carteraDistribucionChart" height="100"></canvas>
    </div>
</div>

<script>
// Gráfica de distribución
const ctx = document.getElementById('carteraDistribucionChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            <?php foreach ($cartera_por_producto as $p): ?>
                '<?php echo addslashes($p['producto']); ?>',
            <?php endforeach; ?>
        ],
        datasets: [{
            label: 'Monto Total',
            data: [
                <?php foreach ($cartera_por_producto as $p): ?>
                    <?php echo $p['monto_total']; ?>,
                <?php endforeach; ?>
            ],
            backgroundColor: '#3b82f6'
        }, {
            label: 'Saldo Pendiente',
            data: [
                <?php foreach ($cartera_por_producto as $p): ?>
                    <?php echo $p['saldo_pendiente']; ?>,
                <?php endforeach; ?>
            ],
            backgroundColor: '#f59e0b'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
