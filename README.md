# Plataforma Tecnológica Financiera para Instituciones de Crédito Mexicanas

Sistema completo de gestión financiera desarrollado para instituciones de crédito mexicanas, cumpliendo con regulaciones de CNBV, CONDUSEF y Banxico.

## 🏦 Características Principales

### Módulos del Sistema

#### 📋 **MÓDULO DE CONFIGURACIONES**
✅ Nombre del sitio y logotipo personalizable  
✅ Configuración del correo principal del sistema  
✅ Teléfonos de contacto y horarios de atención  
✅ Personalización de colores del sistema  
✅ Configuración de cuenta PayPal principal  
✅ API para generar códigos QR masivos  
✅ Configuraciones globales recomendadas

#### 📊 **Dashboard Principal**
- Panel de control con estadísticas en tiempo real
- Gráficas interactivas (Chart.js)
- Indicadores de cartera total
- Alertas de pagos próximos
- Actividades pendientes

#### 👥 **Gestión de Clientes**
- Registro completo de clientes
- Verificación KYC (Know Your Customer)
- Score crediticio
- Historial de créditos
- Documentación digital

#### 💰 **Gestión de Créditos**
- Múltiples tipos de crédito (Personal, Hipotecario, Automotriz, PyME)
- Solicitud y aprobación de créditos
- Cálculo automático de pagos
- Seguimiento de estatus
- Control de garantías y avales

#### 💳 **Gestión de Pagos**
- Registro de pagos múltiples métodos
- Cálculo automático de intereses y mora
- Alertas de pagos vencidos
- Reconciliación bancaria
- Integración PayPal

#### 📈 **Reportes y Análisis**
- Reporte de cartera total
- Análisis de morosidad
- Reportes regulatorios (CNBV, CONDUSEF)
- Exportación a Excel/PDF
- Gráficas personalizadas

#### 📅 **Calendario de Actividades**
- Seguimiento de reuniones
- Recordatorios de cobranza
- Visitas programadas
- Integración FullCalendar.js

#### 🔐 **Sistema de Seguridad**
- Autenticación con password_hash()
- Protección CSRF
- Control de roles y permisos
- Auditoría completa de acciones
- Bloqueo por intentos fallidos

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP 7.4+ (sin framework, PHP puro)
- **Base de Datos:** MySQL 5.7
- **Frontend:** HTML5, CSS3, JavaScript
- **Estilos:** Tailwind CSS (diseño responsivo minimalista)
- **Gráficas:** Chart.js y ApexCharts
- **Calendario:** FullCalendar.js
- **Iconos:** Font Awesome 6
- **Arquitectura:** MVC (Model-View-Controller)

## 📋 Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor Apache con mod_rewrite habilitado
- Extensiones PHP:
  - PDO
  - PDO_MySQL
  - mbstring
  - json
  - fileinfo

## 🚀 Instalación

### 1. Clonar o Descargar el Repositorio

```bash
git clone https://github.com/danjohn007/PlataformaFinanciera.git
cd PlataformaFinanciera
```

### 2. Configurar el Servidor Apache

Copie todos los archivos al directorio de su servidor Apache:

**XAMPP (Windows):**
```
C:\xampp\htdocs\plataforma_financiera\
```

**XAMPP (Linux/Mac):**
```
/opt/lampp/htdocs/plataforma_financiera/
```

**WAMP:**
```
C:\wamp64\www\plataforma_financiera\
```

### 3. Crear la Base de Datos

Abra phpMyAdmin o MySQL desde la línea de comandos:

```bash
mysql -u root -p
```

Ejecute el archivo SQL:

```sql
source /ruta/completa/database.sql
```

O importe el archivo `database.sql` desde phpMyAdmin.

### 4. Configurar Credenciales de Base de Datos

Edite el archivo `config/config.php`:

```php
// Configuración de Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'plataforma_financiera');
define('DB_USER', 'root');          // Su usuario de MySQL
define('DB_PASS', '');              // Su contraseña de MySQL
define('DB_CHARSET', 'utf8mb4');
```

### 5. Configurar Permisos de Escritura

En Linux/Mac, asegúrese de que el directorio `uploads/` tenga permisos de escritura:

```bash
chmod -R 755 uploads/
chmod -R 755 uploads/logos/
chmod -R 755 uploads/documents/
chmod -R 755 uploads/qr_codes/
```

### 6. Acceder al Sistema

El sistema detecta automáticamente la URL base. Puede acceder a:

```
http://localhost/plataforma_financiera/
```

O si lo instaló en un subdirectorio diferente:

```
http://localhost/su-directorio/
```

### 7. Probar la Conexión

Antes de usar el sistema, verifique la configuración:

```
http://localhost/plataforma_financiera/test_connection.php
```

Este archivo verifica:
- ✅ Detección automática de URL base
- ✅ Versión de PHP y extensiones
- ✅ Conexión a la base de datos
- ✅ Estructura de directorios

**⚠️ IMPORTANTE:** Elimine `test_connection.php` en producción por seguridad.

## 👤 Credenciales de Acceso

### Usuario Administrador
```
Usuario: admin
Contraseña: admin123
```

### Usuario Gerente
```
Usuario: gerente
Contraseña: admin123
```

### Usuario Analista
```
Usuario: analista
Contraseña: admin123
```

**⚠️ IMPORTANTE:** Cambie estas contraseñas inmediatamente en producción.

## 📁 Estructura del Proyecto

```
PlataformaFinanciera/
├── config/
│   ├── config.php          # Configuración principal
│   └── database.php        # Clase de conexión a BD
├── controllers/            # Controladores MVC
│   ├── BaseController.php
│   ├── HomeController.php
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── ConfiguracionController.php
│   ├── ClientesController.php
│   ├── CreditosController.php
│   ├── PagosController.php
│   ├── ReportesController.php
│   └── UsuariosController.php
├── models/                 # Modelos de datos
├── views/                  # Vistas (HTML/PHP)
│   ├── layouts/
│   ├── auth/
│   ├── dashboard/
│   ├── configuracion/
│   ├── clientes/
│   ├── creditos/
│   ├── pagos/
│   ├── reportes/
│   └── usuarios/
├── assets/                 # Recursos estáticos
│   ├── css/
│   ├── js/
│   └── images/
├── uploads/                # Archivos subidos
│   ├── logos/
│   ├── documents/
│   └── qr_codes/
├── .htaccess              # Configuración Apache
├── index.php              # Punto de entrada
├── test_connection.php    # Test de conexión
├── database.sql           # Script de base de datos
└── README.md              # Este archivo
```

## 🎨 Personalización

### Cambiar Colores del Sistema

1. Inicie sesión como administrador
2. Vaya a **Administración → Configuración**
3. Seleccione **Colores del Sistema**
4. Elija sus colores personalizados
5. Guarde los cambios

### Cambiar Logo

1. Vaya a **Configuración → Logo del Sistema**
2. Suba su logo (JPG, PNG, GIF o SVG)
3. El logo se mostrará automáticamente

## 🔒 Seguridad

- ✅ Todas las contraseñas se almacenan con `password_hash()`
- ✅ Protección contra SQL Injection (PDO con prepared statements)
- ✅ Protección CSRF en todos los formularios
- ✅ Sanitización de entradas
- ✅ Control de roles y permisos
- ✅ Bloqueo automático tras intentos fallidos
- ✅ Auditoría completa de acciones
- ✅ Headers de seguridad HTTP
- ✅ Archivos sensibles protegidos

## 📝 Datos de Ejemplo

El sistema incluye datos de ejemplo del estado de **Querétaro**:

- 5 clientes de ejemplo
- 5 créditos en diferentes estados
- Productos financieros configurados
- Pagos registrados
- Actividades de seguimiento

## 🐛 Solución de Problemas

### Error de Conexión a Base de Datos
- Verifique las credenciales en `config/config.php`
- Asegúrese de que MySQL esté corriendo
- Verifique que la base de datos exista

### URLs no funcionan (404)
- Verifique que mod_rewrite esté habilitado en Apache
- Revise que el archivo `.htaccess` exista
- Verifique permisos del archivo

### No se suben archivos
- Verifique permisos del directorio `uploads/`
- Revise la configuración de `upload_max_filesize` en php.ini

### Sesión no inicia
- Verifique que las sesiones estén habilitadas en PHP
- Revise permisos del directorio de sesiones

## 📞 Soporte

Para soporte técnico o preguntas:
- Email: contacto@plataformafinanciera.mx
- Issues: GitHub Issues

## 📄 Licencia

Este proyecto es para uso de instituciones financieras mexicanas reguladas.

## 🏗️ Desarrollo

### Desarrollado con:
- ❤️ y ☕ 
- Cumplimiento regulatorio mexicano
- Best practices de seguridad
- Diseño UX/UI profesional

---

**Versión:** 1.0.0  
**Última Actualización:** Diciembre 2024  
**Estado:** Producción Ready ✅
