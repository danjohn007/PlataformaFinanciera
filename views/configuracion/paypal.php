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
            <i class="fab fa-paypal mr-2"></i>Configuración de PayPal
        </h2>
        
        <?php if (!empty($message)): ?>
        <div class="mb-6 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>/configuracion/paypal">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-envelope mr-1"></i>Email de Cuenta PayPal
                </label>
                <input 
                    type="email" 
                    name="paypal_email" 
                    value="<?php echo htmlspecialchars($config['paypal_email'] ?? ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="tu-cuenta@empresa.com"
                >
                <p class="text-sm text-gray-600 mt-1">Email de la cuenta principal de PayPal para recibir pagos</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-key mr-1"></i>Client ID de PayPal
                </label>
                <input 
                    type="text" 
                    name="paypal_client_id" 
                    value="<?php echo htmlspecialchars($config['paypal_client_id'] ?? ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm"
                    placeholder="Ej: AeXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
                >
                <p class="text-sm text-gray-600 mt-1">Obtenga este ID desde el dashboard de desarrolladores de PayPal</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-lock mr-1"></i>Secret de PayPal
                </label>
                <input 
                    type="password" 
                    name="paypal_secret" 
                    value="<?php echo htmlspecialchars($config['paypal_secret'] ?? ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm"
                    placeholder="Ej: EXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
                >
                <p class="text-sm text-gray-600 mt-1">Clave secreta de la aplicación PayPal (mantenga confidencial)</p>
            </div>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                <p class="text-yellow-800">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Importante:</strong>
                </p>
                <ul class="list-disc list-inside text-yellow-700 text-sm mt-2 ml-4">
                    <li>Asegúrese de usar las credenciales de producción en ambiente productivo</li>
                    <li>Las credenciales de sandbox solo deben usarse para pruebas</li>
                    <li>Nunca comparta su Secret con terceros</li>
                    <li>Puede obtener estas credenciales en: developer.paypal.com</li>
                </ul>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>¿Cómo obtener las credenciales?</strong>
                </p>
                <ol class="list-decimal list-inside text-blue-700 text-sm mt-2 ml-4">
                    <li>Inicie sesión en developer.paypal.com</li>
                    <li>Vaya a "My Apps & Credentials"</li>
                    <li>Cree una nueva aplicación o seleccione una existente</li>
                    <li>Copie el Client ID y Secret</li>
                </ol>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="<?php echo BASE_URL; ?>/configuracion" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar Configuración
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
