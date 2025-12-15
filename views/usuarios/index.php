<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <i class="fas fa-user-tie mr-2"></i>Gestión de Usuarios
            </h1>
            <p class="text-gray-600">Administración de usuarios del sistema</p>
        </div>
        <a href="<?php echo BASE_URL; ?>/usuarios/crear" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition shadow-lg">
            <i class="fas fa-plus mr-2"></i>Nuevo Usuario
        </a>
    </div>
    
    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm">Total Usuarios</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo count($usuarios); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <p class="text-gray-600 text-sm">Activos</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php echo count(array_filter($usuarios, fn($u) => $u['activo'] == 1)); ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm">Administradores</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php echo count(array_filter($usuarios, fn($u) => $u['rol'] === 'admin')); ?>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <p class="text-gray-600 text-sm">Conectados Hoy</p>
            <p class="text-3xl font-bold text-gray-800">
                <?php 
                echo count(array_filter($usuarios, function($u) {
                    return $u['ultimo_acceso'] && date('Y-m-d', strtotime($u['ultimo_acceso'])) === date('Y-m-d');
                }));
                ?>
            </p>
        </div>
    </div>
    
    <!-- Tabla de Usuarios -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-list mr-2"></i>Listado de Usuarios
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nombre Completo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Último Acceso</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estatus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>No se encontraron usuarios</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-user-circle text-2xl text-gray-400 mr-2"></i>
                                    <span class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($usuario['username']); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($usuario['nombre_completo']); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($usuario['email']); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($usuario['telefono'] ?? 'N/A'); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $rolClass = [
                                    'admin' => 'bg-red-100 text-red-800',
                                    'gerente' => 'bg-purple-100 text-purple-800',
                                    'ejecutivo' => 'bg-blue-100 text-blue-800',
                                    'analista' => 'bg-green-100 text-green-800',
                                    'contador' => 'bg-yellow-100 text-yellow-800',
                                    'auditor' => 'bg-orange-100 text-orange-800'
                                ];
                                $class = $rolClass[$usuario['rol']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $class; ?>">
                                    <?php echo ucfirst($usuario['rol']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php 
                                if ($usuario['ultimo_acceso']) {
                                    echo date('d/m/Y H:i', strtotime($usuario['ultimo_acceso']));
                                } else {
                                    echo 'Nunca';
                                }
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($usuario['activo']): ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo BASE_URL; ?>/usuarios/editar/<?php echo $usuario['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($usuario['activo']): ?>
                                    <a href="<?php echo BASE_URL; ?>/usuarios/desactivar/<?php echo $usuario['id']; ?>" class="text-red-600 hover:text-red-900" title="Desactivar">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo BASE_URL; ?>/usuarios/activar/<?php echo $usuario['id']; ?>" class="text-green-600 hover:text-green-900" title="Activar">
                                        <i class="fas fa-check-circle"></i>
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

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
