    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">
                        <?php echo $config['nombre_sitio'] ?? SITE_NAME; ?>
                    </h3>
                    <p class="text-gray-400 text-sm">
                        Plataforma Tecnológica Financiera para Instituciones de Crédito Mexicanas
                    </p>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Contacto</h3>
                    <p class="text-gray-400 text-sm">
                        <i class="fas fa-envelope mr-2"></i>
                        <?php echo $config['email_sistema'] ?? SITE_EMAIL; ?>
                    </p>
                    <?php if (!empty($config['telefono_contacto'])): ?>
                    <p class="text-gray-400 text-sm mt-2">
                        <i class="fas fa-phone mr-2"></i>
                        <?php echo $config['telefono_contacto']; ?>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($config['horario_atencion'])): ?>
                    <p class="text-gray-400 text-sm mt-2">
                        <i class="fas fa-clock mr-2"></i>
                        <?php echo nl2br($config['horario_atencion']); ?>
                    </p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Enlaces</h3>
                    <ul class="text-gray-400 text-sm space-y-2">
                        <li><a href="<?php echo BASE_URL; ?>" class="hover:text-white transition">Inicio</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/dashboard" class="hover:text-white transition">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/reportes" class="hover:text-white transition">Reportes</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4">Información</h3>
                    <p class="text-gray-400 text-sm">
                        Sistema desarrollado conforme a regulaciones de:
                    </p>
                    <ul class="text-gray-400 text-sm mt-2 space-y-1">
                        <li>• CNBV</li>
                        <li>• CONDUSEF</li>
                        <li>• Banxico</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $config['nombre_sitio'] ?? SITE_NAME; ?>. Todos los derechos reservados.</p>
                <p class="mt-2">Versión <?php echo SITE_VERSION; ?></p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts adicionales -->
    <script>
        // Configuración global
        const BASE_URL = '<?php echo BASE_URL; ?>';
        
        // Auto-cerrar alertas
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-auto-close');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
