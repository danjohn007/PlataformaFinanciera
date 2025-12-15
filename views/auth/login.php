<?php
// Obtener configuración para el header
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<style>
    .login-gradient {
        background: linear-gradient(135deg, <?php echo htmlspecialchars($config['color_primario'] ?? '#1e40af'); ?>, <?php echo htmlspecialchars($config['color_secundario'] ?? '#3b82f6'); ?>);
    }
    
    .login-btn {
        background-color: <?php echo htmlspecialchars($config['color_primario'] ?? '#1e40af'); ?>;
    }
    
    .login-btn:hover {
        background-color: <?php echo htmlspecialchars($config['color_secundario'] ?? '#3b82f6'); ?>;
    }
    
    .login-focus:focus {
        border-color: <?php echo htmlspecialchars($config['color_primario'] ?? '#1e40af'); ?>;
        ring-color: <?php echo htmlspecialchars($config['color_primario'] ?? '#1e40af'); ?>;
    }
</style>

<div class="min-h-screen flex items-center justify-center login-gradient">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <?php if (!empty($config['logo_url'])): ?>
                <img src="<?php echo BASE_URL . $config['logo_url']; ?>" alt="Logo" class="h-20 mx-auto mb-4">
            <?php else: ?>
                <i class="fas fa-landmark text-6xl mb-4" style="color: <?php echo htmlspecialchars($config['color_primario'] ?? '#1e40af'); ?>;"></i>
            <?php endif; ?>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido</h1>
            <p class="text-gray-600"><?php echo htmlspecialchars($config['nombre_sitio'] ?? SITE_NAME); ?></p>
        </div>
        
        <?php if (!empty($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>/auth/login">
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="username">
                    <i class="fas fa-user mr-2"></i>Usuario o Email
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 login-focus focus:border-transparent"
                    placeholder="Ingrese su usuario o email"
                >
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="password">
                    <i class="fas fa-lock mr-2"></i>Contraseña
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 login-focus focus:border-transparent"
                    placeholder="Ingrese su contraseña"
                >
            </div>
            
            <button 
                type="submit" 
                class="w-full login-btn text-white font-bold py-3 px-4 rounded-lg transition duration-200"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                ¿Problemas para acceder? Contacte al administrador
            </p>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-xs text-gray-500 text-center">
                Credenciales de prueba:<br>
                Usuario: <strong>admin</strong> | Contraseña: <strong>admin123</strong>
            </p>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
