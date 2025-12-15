<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-user-circle mr-2"></i>Mi Perfil
        </h1>
        <p class="text-gray-600">Información personal y configuración de cuenta</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tarjeta de Perfil -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center mb-6">
                    <div class="inline-block bg-blue-100 rounded-full p-6 mb-4">
                        <i class="fas fa-user-circle text-6xl text-blue-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($userData['nombre_completo']); ?></h2>
                    <p class="text-gray-600">@<?php echo htmlspecialchars($userData['username']); ?></p>
                    <span class="inline-block px-4 py-1 mt-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        <?php echo ucfirst($userData['rol']); ?>
                    </span>
                </div>
                
                <div class="border-t pt-4 space-y-3">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-envelope w-6 text-gray-500"></i>
                        <span class="text-sm"><?php echo htmlspecialchars($userData['email']); ?></span>
                    </div>
                    <?php if ($userData['telefono']): ?>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-phone w-6 text-gray-500"></i>
                        <span class="text-sm"><?php echo htmlspecialchars($userData['telefono']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-calendar w-6 text-gray-500"></i>
                        <span class="text-sm">Miembro desde <?php echo date('d/m/Y', strtotime($userData['created_at'])); ?></span>
                    </div>
                    <?php if ($userData['ultimo_acceso']): ?>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-clock w-6 text-gray-500"></i>
                        <span class="text-sm">Último acceso: <?php echo date('d/m/Y H:i', strtotime($userData['ultimo_acceso'])); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Estadísticas de Usuario -->
            <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-chart-bar mr-2"></i>Actividad
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Sesiones totales</span>
                        <span class="font-bold text-gray-800">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Acciones este mes</span>
                        <span class="font-bold text-gray-800">-</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formularios de Edición -->
        <div class="lg:col-span-2">
            <!-- Información Personal -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-user-edit mr-2"></i>Información Personal
                </h3>
                
                <form method="POST" action="<?php echo BASE_URL; ?>/usuarios/actualizar-perfil">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nombre Completo</label>
                            <input 
                                type="text" 
                                name="nombre_completo" 
                                value="<?php echo htmlspecialchars($userData['nombre_completo']); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                value="<?php echo htmlspecialchars($userData['email']); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Teléfono</label>
                            <input 
                                type="tel" 
                                name="telefono" 
                                value="<?php echo htmlspecialchars($userData['telefono'] ?? ''); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Usuario</label>
                            <input 
                                type="text" 
                                value="<?php echo htmlspecialchars($userData['username']); ?>"
                                class="w-full px-4 py-2 border rounded-lg bg-gray-100"
                                disabled
                            >
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Cambiar Contraseña -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-key mr-2"></i>Cambiar Contraseña
                </h3>
                
                <form method="POST" action="<?php echo BASE_URL; ?>/usuarios/cambiar-password">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Contraseña Actual</label>
                            <input 
                                type="password" 
                                name="password_actual" 
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nueva Contraseña</label>
                            <input 
                                type="password" 
                                name="password_nueva" 
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres, incluir mayúsculas, minúsculas y números</p>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Confirmar Nueva Contraseña</label>
                            <input 
                                type="password" 
                                name="password_confirmar" 
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-lock mr-2"></i>Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
