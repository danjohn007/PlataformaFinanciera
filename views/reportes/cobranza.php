<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-file-invoice-dollar mr-2"></i>Reporte de Cobranza
        </h1>
        <p class="text-gray-600">Seguimiento de pagos vencidos y gestión de cobranza</p>
    </div>
    
    <!-- Estadísticas de Cobranza -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <p class="text-gray-600 text-sm">Pagos Vencidos</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo count($pagos_vencidos); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <p class="text-gray-600 text-sm">Monto Total Vencido</p>
            <p class="text-3xl font-bold text-gray-800">
                $<?php 
                $total_vencido = array_reduce($pagos_vencidos, function($carry, $p) {
                    return $carry + $p['monto_pago'];
                }, 0);
                echo number_format($total_vencido, 2);
                ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <p class="text-gray-600 text-sm">Mora Promedio</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                if (count($pagos_vencidos) > 0) {
                    $dias_mora = 0;
                    foreach ($pagos_vencidos as $p) {
                        $fecha_venc = new DateTime($p['fecha_vencimiento']);
                        $hoy = new DateTime();
                        $dias_mora += $fecha_venc->diff($hoy)->days;
                    }
                    echo round($dias_mora / count($pagos_vencidos));
                } else {
                    echo '0';
                }
                ?> días
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm">Clientes en Mora</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                $clientes_unicos = array_unique(array_column($pagos_vencidos, 'nombre'));
                echo count($clientes_unicos);
                ?>
            </p>
        </div>
    </div>
    
    <!-- Tabla de Pagos Vencidos -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>Pagos Vencidos
                </h2>
                <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-print mr-2"></i>Imprimir
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Crédito</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha Vencimiento</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Días de Mora</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estatus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($pagos_vencidos)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-check-circle text-4xl text-green-500 mb-2"></i>
                                <p>No hay pagos vencidos</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pagos_vencidos as $pago): ?>
                        <?php
                        $fecha_venc = new DateTime($pago['fecha_vencimiento']);
                        $hoy = new DateTime();
                        $dias_mora = $fecha_venc->diff($hoy)->days;
                        
                        $clase_mora = $dias_mora > 60 ? 'bg-red-100' : ($dias_mora > 30 ? 'bg-orange-100' : 'bg-yellow-100');
                        ?>
                        <tr class="hover:bg-gray-50 transition <?php echo $clase_mora; ?>">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($pago['nombre'] . ' ' . $pago['apellido_paterno']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    <i class="fas fa-phone mr-1"></i><?php echo htmlspecialchars($pago['telefono']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($pago['numero_credito']); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">$<?php echo number_format($pago['monto_pago'], 2); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?php echo date('d/m/Y', strtotime($pago['fecha_vencimiento'])); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold <?php echo $dias_mora > 60 ? 'text-red-700' : ($dias_mora > 30 ? 'text-orange-700' : 'text-yellow-700'); ?>">
                                    <?php echo $dias_mora; ?> días
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Vencido
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="tel:<?php echo $pago['telefono']; ?>" class="text-green-600 hover:text-green-900 mr-3" title="Llamar">
                                    <i class="fas fa-phone"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/pagos/ver/<?php echo $pago['id']; ?>" class="text-blue-600 hover:text-blue-900" title="Ver Detalle">
                                    <i class="fas fa-eye"></i>
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
