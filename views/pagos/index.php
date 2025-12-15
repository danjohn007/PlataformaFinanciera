<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-credit-card mr-2"></i>Gestión de Pagos
            </h1>
            <p class="text-gray-600">Administración y seguimiento de pagos</p>
        </div>
        <a href="<?php echo BASE_URL; ?>/pagos/registrar" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition shadow-lg">
            <i class="fas fa-plus mr-2"></i>Registrar Pago
        </a>
    </div>
    
    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <p class="text-gray-600 text-sm">Pagos del Mes</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                $pagos_mes = array_filter($pagos, function($p) {
                    return date('Y-m', strtotime($p['created_at'])) === date('Y-m');
                });
                echo count($pagos_mes);
                ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm">Total Recaudado</p>
            <p class="text-3xl font-bold text-gray-800">
                $<?php 
                $total = array_reduce($pagos_mes, function($carry, $p) {
                    return $carry + $p['monto'];
                }, 0);
                echo number_format($total, 2);
                ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm">Total Pagos</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo count($pagos); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <p class="text-gray-600 text-sm">Pagos Hoy</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                echo count(array_filter($pagos, fn($p) => date('Y-m-d', strtotime($p['created_at'])) === date('Y-m-d')));
                ?>
            </p>
        </div>
    </div>
    
    <!-- Tabla de Pagos -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-list mr-2"></i>Registro de Pagos
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Crédito</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Método</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estatus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($pagos)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>No se encontraron pagos registrados</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pagos as $pago): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?php echo date('d/m/Y', strtotime($pago['created_at'])); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($pago['nombre'] . ' ' . $pago['apellido_paterno']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($pago['numero_credito']); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">$<?php echo number_format($pago['monto'], 2); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($pago['metodo_pago'] ?? 'N/A'); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClass = [
                                    'Completado' => 'bg-green-100 text-green-800',
                                    'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                    'Rechazado' => 'bg-red-100 text-red-800'
                                ];
                                $class = $statusClass[$pago['estatus']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $class; ?>">
                                    <?php echo htmlspecialchars($pago['estatus']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo BASE_URL; ?>/pagos/ver/<?php echo $pago['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/pagos/recibo/<?php echo $pago['id']; ?>" class="text-green-600 hover:text-green-900" title="Descargar Recibo">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
