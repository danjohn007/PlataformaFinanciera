<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$configData = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="mb-6">
        <a href="<?php echo BASE_URL; ?>/configuracion" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Volver a Configuraciones
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-palette mr-2"></i>Personalización de Colores del Sistema
        </h2>
        
        <?php if (!empty($message)): ?>
        <div class="mb-6 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>/configuracion/colores">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-paint-brush mr-1"></i>Color Primario
                    </label>
                    <div class="flex items-center space-x-4">
                        <input 
                            type="color" 
                            name="color_primario" 
                            value="<?php echo $config['color_primario'] ?? '#1e40af'; ?>"
                            class="w-20 h-20 rounded cursor-pointer"
                        >
                        <div>
                            <p class="text-sm text-gray-600">Color principal del sistema</p>
                            <p class="text-xs text-gray-500 mt-1">Usado en navegación y botones principales</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-paint-brush mr-1"></i>Color Secundario
                    </label>
                    <div class="flex items-center space-x-4">
                        <input 
                            type="color" 
                            name="color_secundario" 
                            value="<?php echo $config['color_secundario'] ?? '#3b82f6'; ?>"
                            class="w-20 h-20 rounded cursor-pointer"
                        >
                        <div>
                            <p class="text-sm text-gray-600">Color secundario</p>
                            <p class="text-xs text-gray-500 mt-1">Usado en elementos de apoyo</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-paint-brush mr-1"></i>Color de Acento
                    </label>
                    <div class="flex items-center space-x-4">
                        <input 
                            type="color" 
                            name="color_acento" 
                            value="<?php echo $config['color_acento'] ?? '#06b6d4'; ?>"
                            class="w-20 h-20 rounded cursor-pointer"
                        >
                        <div>
                            <p class="text-sm text-gray-600">Color de acento</p>
                            <p class="text-xs text-gray-500 mt-1">Usado para destacar elementos</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-gray-800 mb-4">Vista Previa</h3>
                <div class="space-y-4">
                    <button type="button" class="px-6 py-3 text-white rounded-lg" style="background-color: <?php echo $config['color_primario'] ?? '#1e40af'; ?>">
                        Botón Primario
                    </button>
                    <button type="button" class="ml-4 px-6 py-3 text-white rounded-lg" style="background-color: <?php echo $config['color_secundario'] ?? '#3b82f6'; ?>">
                        Botón Secundario
                    </button>
                    <button type="button" class="ml-4 px-6 py-3 text-white rounded-lg" style="background-color: <?php echo $config['color_acento'] ?? '#06b6d4'; ?>">
                        Botón de Acento
                    </button>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-4">
                <a href="<?php echo BASE_URL; ?>/configuracion" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar Colores
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
