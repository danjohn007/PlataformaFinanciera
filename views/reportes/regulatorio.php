<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-file-contract mr-2"></i>Reportes Regulatorios
            </h1>
            <p class="text-gray-600">Cumplimiento normativo y reportes a autoridades</p>
        </div>
        <button onclick="generarReporte()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition shadow-lg">
            <i class="fas fa-plus mr-2"></i>Generar Reporte
        </button>
    </div>
    
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm">Reportes Generados</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo count($reportes); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <p class="text-gray-600 text-sm">Este Mes</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                echo count(array_filter($reportes, fn($r) => date('Y-m', strtotime($r['created_at'])) === date('Y-m')));
                ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm">Enviados</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                echo count(array_filter($reportes, fn($r) => $r['estatus'] === 'Enviado'));
                ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <p class="text-gray-600 text-sm">Pendientes</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                echo count(array_filter($reportes, fn($r) => $r['estatus'] === 'Borrador'));
                ?>
            </p>
        </div>
    </div>
    
    <!-- Información Regulatoria -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-800 mb-2">
                <i class="fas fa-landmark mr-2"></i>CNBV
            </h3>
            <p class="text-sm text-gray-700 mb-3">Comisión Nacional Bancaria y de Valores</p>
            <div class="text-sm text-gray-600">
                <p><strong>Próximo reporte:</strong> <?php echo date('d/m/Y', strtotime('last day of this month')); ?></p>
            </div>
        </div>
        
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="font-bold text-green-800 mb-2">
                <i class="fas fa-balance-scale mr-2"></i>CONDUSEF
            </h3>
            <p class="text-sm text-gray-700 mb-3">Comisión Nacional para la Protección y Defensa de los Usuarios de Servicios Financieros</p>
            <div class="text-sm text-gray-600">
                <p><strong>Próximo reporte:</strong> Trimestral</p>
            </div>
        </div>
        
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="font-bold text-purple-800 mb-2">
                <i class="fas fa-shield-alt mr-2"></i>PLD
            </h3>
            <p class="text-sm text-gray-700 mb-3">Prevención de Lavado de Dinero</p>
            <div class="text-sm text-gray-600">
                <p><strong>Próximo reporte:</strong> Mensual</p>
            </div>
        </div>
    </div>
    
    <!-- Tabla de Reportes -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-list mr-2"></i>Historial de Reportes
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipo de Reporte</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Periodo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Generado Por</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha Generación</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estatus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($reportes)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>No se han generado reportes regulatorios</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($reportes as $reporte): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($reporte['tipo_reporte']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($reporte['periodo']); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($reporte['generado_por']); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?php echo date('d/m/Y H:i', strtotime($reporte['created_at'])); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClass = [
                                    'Enviado' => 'bg-green-100 text-green-800',
                                    'Borrador' => 'bg-yellow-100 text-yellow-800',
                                    'En Revisión' => 'bg-blue-100 text-blue-800'
                                ];
                                $class = $statusClass[$reporte['estatus']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $class; ?>">
                                    <?php echo htmlspecialchars($reporte['estatus']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo BASE_URL; ?>/reportes/ver/<?php echo $reporte['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/reportes/descargar/<?php echo $reporte['id']; ?>" class="text-green-600 hover:text-green-900 mr-3" title="Descargar">
                                    <i class="fas fa-download"></i>
                                </a>
                                <?php if ($reporte['estatus'] === 'Borrador'): ?>
                                <a href="<?php echo BASE_URL; ?>/reportes/enviar/<?php echo $reporte['id']; ?>" class="text-purple-600 hover:text-purple-900" title="Enviar">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function generarReporte() {
    alert('Esta funcionalidad permitirá generar nuevos reportes regulatorios.\nEn desarrollo.');
}
</script>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
