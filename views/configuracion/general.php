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
            <i class="fas fa-building mr-2"></i>Configuración General del Sistema
        </h2>
        
        <?php if (!empty($message)): ?>
        <div class="mb-6 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>/configuracion/general">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-signature mr-1"></i>Nombre del Sitio
                    </label>
                    <input 
                        type="text" 
                        name="nombre_sitio" 
                        value="<?php echo htmlspecialchars($config['nombre_sitio'] ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-1"></i>Email del Sistema
                    </label>
                    <input 
                        type="email" 
                        name="email_sistema" 
                        value="<?php echo htmlspecialchars($config['email_sistema'] ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-phone mr-1"></i>Teléfono Principal
                    </label>
                    <input 
                        type="text" 
                        name="telefono_contacto" 
                        value="<?php echo htmlspecialchars($config['telefono_contacto'] ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="442-123-4567"
                    >
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-phone-square mr-1"></i>Teléfono Secundario
                    </label>
                    <input 
                        type="text" 
                        name="telefono_secundario" 
                        value="<?php echo htmlspecialchars($config['telefono_secundario'] ?? ''); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="442-123-4568"
                    >
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-clock mr-1"></i>Horarios de Atención
                    </label>
                    <textarea 
                        name="horario_atencion" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Lunes a Viernes: 9:00 AM - 6:00 PM&#10;Sábados: 9:00 AM - 2:00 PM"
                    ><?php echo htmlspecialchars($config['horario_atencion'] ?? ''); ?></textarea>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-dollar-sign mr-1"></i>Moneda Predeterminada
                    </label>
                    <select 
                        name="moneda_default"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="MXN" <?php echo ($config['moneda_default'] ?? 'MXN') === 'MXN' ? 'selected' : ''; ?>>MXN - Peso Mexicano</option>
                        <option value="USD" <?php echo ($config['moneda_default'] ?? '') === 'USD' ? 'selected' : ''; ?>>USD - Dólar Americano</option>
                        <option value="EUR" <?php echo ($config['moneda_default'] ?? '') === 'EUR' ? 'selected' : ''; ?>>EUR - Euro</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-percentage mr-1"></i>Tasa de Interés Base (%)
                    </label>
                    <input 
                        type="number" 
                        name="tasa_interes_default" 
                        step="0.01"
                        value="<?php echo $config['tasa_interes_default'] ?? 15.00; ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    >
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-4">
                <a href="<?php echo BASE_URL; ?>/configuracion" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
