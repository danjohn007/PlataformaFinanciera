<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Plataforma Financiera'; ?> - <?php echo SITE_NAME; ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <!-- FullCalendar -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    
    <!-- Custom Styles -->
    <style>
        :root {
            --color-primary: <?php echo $config['color_primario'] ?? '#1e40af'; ?>;
            --color-secondary: <?php echo $config['color_secundario'] ?? '#3b82f6'; ?>;
            --color-accent: <?php echo $config['color_acento'] ?? '#06b6d4'; ?>;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
        .text-primary {
            color: var(--color-primary);
        }
        .bg-primary {
            background-color: var(--color-primary);
        }
        .border-primary {
            border-color: var(--color-primary);
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Navegación Principal -->
        <nav class="bg-primary text-white shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-8">
                        <a href="<?php echo BASE_URL; ?>/dashboard" class="flex items-center space-x-2">
                            <?php if (!empty($config['logo_url'])): ?>
                                <img src="<?php echo BASE_URL . $config['logo_url']; ?>" alt="Logo" class="h-10">
                            <?php else: ?>
                                <i class="fas fa-landmark text-2xl"></i>
                            <?php endif; ?>
                            <span class="font-bold text-xl"><?php echo $config['nombre_sitio'] ?? SITE_NAME; ?></span>
                        </a>
                        
                        <!-- Menú Principal -->
                        <div class="hidden md:flex space-x-6">
                            <a href="<?php echo BASE_URL; ?>/dashboard" class="hover:text-blue-200 transition">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                            <a href="<?php echo BASE_URL; ?>/clientes" class="hover:text-blue-200 transition">
                                <i class="fas fa-users mr-1"></i> Clientes
                            </a>
                            <a href="<?php echo BASE_URL; ?>/creditos" class="hover:text-blue-200 transition">
                                <i class="fas fa-money-bill-wave mr-1"></i> Créditos
                            </a>
                            <a href="<?php echo BASE_URL; ?>/pagos" class="hover:text-blue-200 transition">
                                <i class="fas fa-credit-card mr-1"></i> Pagos
                            </a>
                            <a href="<?php echo BASE_URL; ?>/reportes" class="hover:text-blue-200 transition">
                                <i class="fas fa-chart-bar mr-1"></i> Reportes
                            </a>
                            
                            <?php if (in_array($_SESSION['user_role'], ['admin', 'gerente'])): ?>
                            <div class="relative group">
                                <button class="hover:text-blue-200 transition flex items-center">
                                    <i class="fas fa-cog mr-1"></i> Administración
                                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>
                                <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-lg shadow-lg mt-2 py-2 w-48 z-50">
                                    <a href="<?php echo BASE_URL; ?>/usuarios" class="block px-4 py-2 hover:bg-gray-100">
                                        <i class="fas fa-user-tie mr-2"></i> Usuarios
                                    </a>
                                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                    <a href="<?php echo BASE_URL; ?>/configuracion" class="block px-4 py-2 hover:bg-gray-100">
                                        <i class="fas fa-sliders-h mr-2"></i> Configuración
                                    </a>
                                    <?php endif; ?>
                                    <a href="<?php echo BASE_URL; ?>/reportes/regulatorio" class="block px-4 py-2 hover:bg-gray-100">
                                        <i class="fas fa-file-contract mr-2"></i> Regulatorio
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Usuario y Notificaciones -->
                    <div class="flex items-center space-x-4">
                        <button class="relative hover:text-blue-200 transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                        
                        <div class="relative group">
                            <button class="flex items-center space-x-2 hover:text-blue-200 transition">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span class="hidden md:inline"><?php echo $_SESSION['nombre_completo'] ?? $_SESSION['username']; ?></span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 hidden group-hover:block bg-white text-gray-800 rounded-lg shadow-lg mt-2 py-2 w-48 z-50">
                                <div class="px-4 py-2 border-b">
                                    <p class="font-semibold"><?php echo $_SESSION['nombre_completo']; ?></p>
                                    <p class="text-sm text-gray-600"><?php echo ucfirst($_SESSION['user_role']); ?></p>
                                </div>
                                <a href="<?php echo BASE_URL; ?>/usuarios/perfil" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Mi Perfil
                                </a>
                                <a href="<?php echo BASE_URL; ?>/auth/logout" class="block px-4 py-2 hover:bg-gray-100 text-red-600">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    <?php endif; ?>
    
    <!-- Contenido Principal -->
    <main class="<?php echo isset($_SESSION['user_id']) ? 'py-8' : ''; ?>">
