<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-money-bill-wave mr-2"></i>Gestión de Créditos
            </h1>
            <p class="text-gray-600">Administración de cartera de créditos y préstamos</p>
        </div>
        <a href="<?php echo BASE_URL; ?>/creditos/solicitar" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition shadow-lg">
            <i class="fas fa-plus mr-2"></i>Nueva Solicitud
        </a>
    </div>
    
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="Solicitud">Solicitud</option>
                    <option value="En Revisión">En Revisión</option>
                    <option value="Aprobado">Aprobado</option>
                    <option value="En Pago">En Pago</option>
                    <option value="Vencido">Vencido</option>
                    <option value="Pagado">Pagado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input 
                    type="text" 
                    placeholder="No. crédito o cliente..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                <input 
                    type="date" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                <input 
                    type="date" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
    </div>
    
    <!-- Tabla de Créditos -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Crédito</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Saldo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plazo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($creditos)): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>No hay créditos registrados</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($creditos as $credito): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm font-semibold text-blue-600">
                                    <?php echo htmlspecialchars($credito['numero_credito']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($credito['nombre'] . ' ' . $credito['apellido_paterno']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($credito['producto_nombre']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    $<?php echo number_format($credito['monto_aprobado'] ?? $credito['monto_solicitado'], 2); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    $<?php echo number_format($credito['saldo_pendiente'] ?? 0, 2); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo $credito['plazo_meses']; ?> meses
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusColors = [
                                    'Solicitud' => 'bg-gray-100 text-gray-800',
                                    'En Revisión' => 'bg-yellow-100 text-yellow-800',
                                    'Aprobado' => 'bg-green-100 text-green-800',
                                    'Rechazado' => 'bg-red-100 text-red-800',
                                    'En Pago' => 'bg-blue-100 text-blue-800',
                                    'Vencido' => 'bg-red-100 text-red-800',
                                    'Pagado' => 'bg-green-100 text-green-800'
                                ];
                                $colorClass = $statusColors[$credito['estatus']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $colorClass; ?>">
                                    <?php echo htmlspecialchars($credito['estatus']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?php echo BASE_URL; ?>/creditos/ver/<?php echo $credito['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i> Ver
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
