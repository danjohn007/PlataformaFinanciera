<?php
$stmt = Database::getInstance()->query("SELECT * FROM configuracion WHERE id = 1");
$config = $stmt->fetch() ?: [];
require_once VIEWS_PATH . 'layouts/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-lg w-full bg-white rounded-xl shadow-2xl p-8 text-center">
        <i class="fas fa-exclamation-triangle text-8xl text-yellow-500 mb-6"></i>
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Página No Encontrada</h2>
        <p class="text-gray-600 mb-8">
            <?php echo $message ?? 'La página que estás buscando no existe o ha sido movida.'; ?>
        </p>
        <div class="space-x-4">
            <a href="<?php echo BASE_URL; ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-home mr-2"></i>Ir al Inicio
            </a>
            <a href="javascript:history.back()" class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layouts/footer.php'; ?>
