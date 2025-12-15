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
            --color-primary: <?php echo htmlspecialchars($config['color_primario'] ?? '#1e40af'); ?>;
            --color-secondary: <?php echo htmlspecialchars($config['color_secundario'] ?? '#3b82f6'); ?>;
            --color-accent: <?php echo htmlspecialchars($config['color_acento'] ?? '#06b6d4'); ?>;
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
        
        /* Sidebar Styles */
        #sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        #sidebar.active {
            transform: translateX(0);
        }
        
        #sidebar-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }
        
        #sidebar-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        
        .submenu.active {
            max-height: 500px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Overlay para el sidebar -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40" onclick="toggleSidebar()"></div>
        
        <!-- Sidebar lateral -->
        <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-2xl z-50 overflow-y-auto">
            <div class="p-6 border-b flex items-center justify-between bg-primary text-white">
                <div class="flex items-center space-x-2">
                    <?php if (!empty($config['logo_url'])): ?>
                        <img src="<?php echo BASE_URL . $config['logo_url']; ?>" alt="Logo" class="h-8">
                    <?php else: ?>
                        <i class="fas fa-landmark text-2xl"></i>
                    <?php endif; ?>
                    <span class="font-bold text-lg"><?php echo $config['nombre_sitio'] ?? SITE_NAME; ?></span>
                </div>
                <button onclick="toggleSidebar()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Menú de navegación -->
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="<?php echo BASE_URL; ?>/dashboard" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            <i class="fas fa-home w-6 mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL; ?>/clientes" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            <i class="fas fa-users w-6 mr-3"></i>
                            <span>Clientes</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL; ?>/creditos" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            <i class="fas fa-money-bill-wave w-6 mr-3"></i>
                            <span>Créditos</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL; ?>/pagos" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            <i class="fas fa-credit-card w-6 mr-3"></i>
                            <span>Pagos</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL; ?>/reportes" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            <i class="fas fa-chart-bar w-6 mr-3"></i>
                            <span>Reportes</span>
                        </a>
                    </li>
                    
                    <?php if (in_array($_SESSION['user_role'], ['admin', 'gerente'])): ?>
                    <li class="border-t mt-2 pt-2">
                        <button onclick="toggleSubmenu('admin-submenu')" class="flex items-center justify-between w-full px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            <div class="flex items-center">
                                <i class="fas fa-cog w-6 mr-3"></i>
                                <span>Administración</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        <ul id="admin-submenu" class="submenu ml-8 space-y-1 mt-1">
                            <li>
                                <a href="<?php echo BASE_URL; ?>/usuarios" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 rounded-lg transition">
                                    <i class="fas fa-user-tie w-5 mr-2"></i>
                                    <span>Usuarios</span>
                                </a>
                            </li>
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/configuracion" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 rounded-lg transition">
                                    <i class="fas fa-sliders-h w-5 mr-2"></i>
                                    <span>Configuración</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/reportes/regulatorio" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 rounded-lg transition">
                                    <i class="fas fa-file-contract w-5 mr-2"></i>
                                    <span>Regulatorio</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <!-- Usuario info en el sidebar -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t bg-gray-50">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user-circle text-2xl text-gray-600"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate"><?php echo $_SESSION['nombre_completo'] ?? $_SESSION['username']; ?></p>
                            <p class="text-xs text-gray-600"><?php echo ucfirst($_SESSION['user_role']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo BASE_URL; ?>/usuarios/perfil" class="flex-1 text-center px-3 py-2 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        <i class="fas fa-user mr-1"></i>Perfil
                    </a>
                    <a href="<?php echo BASE_URL; ?>/auth/logout" class="flex-1 text-center px-3 py-2 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                        <i class="fas fa-sign-out-alt mr-1"></i>Salir
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- Barra superior con hamburguesa -->
        <nav class="bg-primary text-white shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleSidebar()" class="text-white hover:text-gray-200 focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                        <a href="<?php echo BASE_URL; ?>/dashboard" class="flex items-center space-x-2">
                            <?php if (!empty($config['logo_url'])): ?>
                                <img src="<?php echo BASE_URL . $config['logo_url']; ?>" alt="Logo" class="h-10">
                            <?php else: ?>
                                <i class="fas fa-landmark text-2xl"></i>
                            <?php endif; ?>
                            <span class="font-bold text-xl hidden sm:inline"><?php echo $config['nombre_sitio'] ?? SITE_NAME; ?></span>
                        </a>
                    </div>
                    
                    <!-- Notificaciones y usuario en barra superior -->
                    <div class="flex items-center space-x-4">
                        <button class="relative hover:text-gray-200 transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                        <div class="hidden md:flex items-center space-x-2">
                            <i class="fas fa-user-circle text-2xl"></i>
                            <span class="text-sm"><?php echo $_SESSION['nombre_completo'] ?? $_SESSION['username']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
            
            function toggleSubmenu(id) {
                const submenu = document.getElementById(id);
                submenu.classList.toggle('active');
            }
        </script>
    <?php endif; ?>
    
    <!-- Contenido Principal -->
    <main class="<?php echo isset($_SESSION['user_id']) ? 'py-8' : ''; ?>">
