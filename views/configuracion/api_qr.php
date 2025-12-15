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
            <i class="fas fa-qrcode mr-2"></i>Configuración de API para Códigos QR
        </h2>
        
        <?php if (!empty($message)): ?>
        <div class="mb-6 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>/configuracion/apiQr">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-link mr-1"></i>URL de API QR
                </label>
                <input 
                    type="url" 
                    name="api_qr_url" 
                    value="<?php echo htmlspecialchars($config['api_qr_url'] ?? ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                    placeholder="https://api.qrcode-generator.com/v1/create"
                >
                <p class="text-sm text-gray-600 mt-1">Endpoint de la API para generar códigos QR</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fas fa-key mr-1"></i>API Key
                </label>
                <input 
                    type="text" 
                    name="api_qr_key" 
                    value="<?php echo htmlspecialchars($config['api_qr_key'] ?? ''); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm"
                    placeholder="Ingrese su clave API para generación de códigos QR"
                >
                <p class="text-sm text-gray-600 mt-1">Clave de autenticación de la API</p>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Casos de Uso:</strong>
                </p>
                <ul class="list-disc list-inside text-blue-700 text-sm mt-2 ml-4">
                    <li><strong>Pagos:</strong> Generar QR para cada pago que los clientes puedan escanear</li>
                    <li><strong>Recibos:</strong> Códigos QR en recibos para verificación rápida</li>
                    <li><strong>Referencias:</strong> QR con referencias de pago únicas</li>
                    <li><strong>Documentos:</strong> QR en contratos y documentos para acceso digital</li>
                </ul>
            </div>
            
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                <p class="text-green-800">
                    <i class="fas fa-lightbulb mr-2"></i>
                    <strong>APIs Recomendadas:</strong>
                </p>
                <ul class="text-green-700 text-sm mt-2 ml-4 space-y-1">
                    <li>• <strong>QR Code Generator API:</strong> https://www.qr-code-generator.com/</li>
                    <li>• <strong>QRServer:</strong> https://goqr.me/api/</li>
                    <li>• <strong>QR Code Monkey:</strong> https://www.qrcode-monkey.com/</li>
                    <li>• <strong>API Gratuita:</strong> https://api.qrserver.com/v1/create-qr-code/</li>
                </ul>
            </div>
            
            <div class="bg-gray-50 border border-gray-300 rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">
                    <i class="fas fa-flask mr-2"></i>Prueba de Generación de QR
                </h3>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Genere un QR de prueba con la configuración actual</p>
                        <button type="button" onclick="generarQRPrueba()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm">
                            <i class="fas fa-magic mr-1"></i>Generar QR de Prueba
                        </button>
                    </div>
                    <div id="qr-preview" class="text-center">
                        <p class="text-sm text-gray-500 italic">El QR aparecerá aquí</p>
                    </div>
                </div>
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

<script>
function generarQRPrueba() {
    const preview = document.getElementById('qr-preview');
    const apiUrl = document.querySelector('input[name="api_qr_url"]').value || 'https://api.qrserver.com/v1/create-qr-code/';
    
    // Usar API gratuita para demostración
    const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent('Plataforma Financiera - Pago de Prueba');
    
    preview.innerHTML = '<img src="' + qrUrl + '" alt="QR de Prueba" class="border-2 border-gray-300 rounded">';
}
</script>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
