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
            <i class="fas fa-image mr-2"></i>Configuración de Logo del Sistema
        </h2>
        
        <?php if (!empty($message)): ?>
        <div class="mb-6 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <!-- Logo Actual -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Logo Actual</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50">
                <?php if (!empty($config['logo_url'])): ?>
                    <img src="<?php echo BASE_URL . $config['logo_url']; ?>" alt="Logo actual" class="max-h-40 mx-auto">
                <?php else: ?>
                    <i class="fas fa-image text-6xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">No hay logo configurado</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Formulario de Subida -->
        <form method="POST" action="<?php echo BASE_URL; ?>/configuracion/logo" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-upload mr-1"></i>Seleccionar Nuevo Logo
                </label>
                <input 
                    type="file" 
                    name="logo" 
                    accept="image/jpeg,image/png,image/gif,image/svg+xml"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    required
                >
                <p class="text-sm text-gray-600 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Formatos permitidos: JPG, PNG, GIF, SVG | Tamaño recomendado: 200x60 píxeles
                </p>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-800">
                    <i class="fas fa-lightbulb mr-2"></i>
                    <strong>Recomendaciones:</strong>
                </p>
                <ul class="list-disc list-inside text-blue-700 text-sm mt-2 ml-4">
                    <li>Utilice un logo con fondo transparente (PNG o SVG)</li>
                    <li>Mantenga proporciones horizontales para mejor visualización</li>
                    <li>El logo se mostrará en la barra de navegación</li>
                    <li>Tamaño máximo de archivo: 2MB</li>
                </ul>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="<?php echo BASE_URL; ?>/configuracion" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-upload mr-2"></i>Subir Logo
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
