<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-lg w-full bg-white rounded-xl shadow-2xl p-8 text-center">
        <i class="fas fa-ban text-8xl text-red-500 mb-6"></i>
        <h1 class="text-6xl font-bold text-gray-800 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Acceso Denegado</h2>
        <p class="text-gray-600 mb-8">
            <?php echo $message ?? 'No tienes permisos para acceder a esta página.'; ?>
        </p>
        <div class="space-x-4">
            <a href="<?php echo BASE_URL; ?>/dashboard" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-home mr-2"></i>Ir al Dashboard
            </a>
            <a href="javascript:history.back()" class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
