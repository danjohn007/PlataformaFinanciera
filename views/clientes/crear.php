<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="container mx-auto px-4">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-user-plus mr-2"></i>Nuevo Cliente
                </h1>
                <p class="text-gray-600">Registro de nuevo cliente en el sistema</p>
            </div>
            <a href="<?php echo BASE_URL; ?>/clientes" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>Regresar
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-8">
        <form method="POST" action="<?php echo BASE_URL; ?>/clientes/store" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <!-- Información Personal -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-user mr-2"></i>Información Personal
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nombre(s) *</label>
                        <input type="text" name="nombre" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">RFC *</label>
                        <input type="text" name="rfc" required maxlength="13" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">CURP *</label>
                        <input type="text" name="curp" required maxlength="18" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Fecha de Nacimiento *</label>
                        <input type="date" name="fecha_nacimiento" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Sexo *</label>
                        <select name="sexo" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Estado Civil *</label>
                        <select name="estado_civil" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="Soltero">Soltero(a)</option>
                            <option value="Casado">Casado(a)</option>
                            <option value="Divorciado">Divorciado(a)</option>
                            <option value="Viudo">Viudo(a)</option>
                            <option value="Union Libre">Unión Libre</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nacionalidad *</label>
                        <input type="text" name="nacionalidad" value="Mexicana" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            
            <!-- Información de Contacto -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-address-book mr-2"></i>Información de Contacto
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email *</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Teléfono *</label>
                        <input type="tel" name="telefono" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Teléfono Alternativo</label>
                        <input type="tel" name="telefono_alternativo" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            
            <!-- Dirección -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Dirección
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">Calle *</label>
                        <input type="text" name="calle" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Número Exterior *</label>
                        <input type="text" name="numero_exterior" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Número Interior</label>
                        <input type="text" name="numero_interior" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Colonia *</label>
                        <input type="text" name="colonia" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Código Postal *</label>
                        <input type="text" name="codigo_postal" required maxlength="5" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Ciudad *</label>
                        <input type="text" name="ciudad" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Estado *</label>
                        <input type="text" name="estado" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            
            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4">
                <a href="<?php echo BASE_URL; ?>/clientes" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
