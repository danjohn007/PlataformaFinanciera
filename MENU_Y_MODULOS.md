# Menú Principal y Módulos del Sistema

## 🏦 Plataforma Tecnológica Financiera para Instituciones de Crédito Mexicanas

### 📋 MENÚ PRINCIPAL DEL SISTEMA

El sistema cuenta con un menú principal completo y organizado en la barra de navegación superior:

#### 1. **Dashboard** 🏠
- **Ruta:** `/dashboard`
- **Descripción:** Panel de control principal con vista general del sistema
- **Características:**
  - Estadísticas en tiempo real (cartera total, clientes activos, pagos del mes)
  - Gráficas interactivas con Chart.js
  - Actividades pendientes del día
  - Pagos próximos a vencer
  - Indicadores de morosidad
- **Acceso:** Todos los usuarios autenticados

#### 2. **Clientes** 👥
- **Ruta:** `/clientes`
- **Descripción:** Gestión integral de la cartera de clientes
- **Características:**
  - Lista completa de clientes con búsqueda
  - Registro de nuevos clientes (KYC completo)
  - Verificación CURP y RFC
  - Historial de créditos por cliente
  - Score crediticio
  - Gestión de documentos
  - Estados: Activo, Inactivo, Suspendido, Vetado
- **Acceso:** Todos los usuarios
- **Sub-rutas:**
  - `/clientes/crear` - Nuevo cliente
  - `/clientes/ver/{id}` - Ver detalles
  - `/clientes/editar/{id}` - Editar información

#### 3. **Créditos** 💰
- **Ruta:** `/creditos`
- **Descripción:** Administración completa de créditos y préstamos
- **Características:**
  - Solicitud de nuevos créditos
  - Revisión y aprobación
  - Tipos de crédito:
    * Crédito Personal
    * Crédito Hipotecario
    * Crédito Automotriz
    * Crédito PyME
    * Tarjeta de Crédito
  - Cálculo automático de pagos
  - Gestión de garantías y avales
  - Seguimiento de estados (Solicitud → Aprobado → En Pago → Pagado)
  - Control de morosidad
- **Acceso:** Todos los usuarios
- **Sub-rutas:**
  - `/creditos/solicitar` - Nueva solicitud
  - `/creditos/ver/{id}` - Detalles del crédito
  - `/creditos/aprobar/{id}` - Aprobar/Rechazar (Gerente/Admin)

#### 4. **Pagos** 💳
- **Ruta:** `/pagos`
- **Descripción:** Gestión de pagos y cobranza
- **Características:**
  - Registro de pagos (múltiples métodos)
  - Métodos de pago:
    * Efectivo
    * Transferencia bancaria
    * Tarjeta
    * Cheque
    * PayPal
    * Domiciliación
  - Cálculo automático de intereses
  - Cálculo de mora
  - Pagos pendientes y próximos a vencer
  - Historial de transacciones
  - Generación de recibos
  - Códigos QR para pagos
- **Acceso:** Todos los usuarios
- **Sub-rutas:**
  - `/pagos/registrar` - Registrar nuevo pago
  - `/pagos/pendientes` - Ver pagos pendientes
  - `/pagos/vencidos` - Pagos vencidos

#### 5. **Reportes** 📊
- **Ruta:** `/reportes`
- **Descripción:** Centro de reportes y análisis
- **Características:**
  - **Reporte de Cartera:** Análisis completo de cartera
  - **Reporte de Cobranza:** Seguimiento de mora y cobranza
  - **Reportes Regulatorios:** CNBV, CONDUSEF, Banxico
  - Exportación a PDF y Excel
  - Gráficas personalizadas
  - Filtros por fecha, producto, estado
- **Acceso:** Gerente, Analista, Auditor, Admin
- **Sub-rutas:**
  - `/reportes/cartera` - Reporte de cartera
  - `/reportes/cobranza` - Reporte de cobranza
  - `/reportes/regulatorio` - Reportes regulatorios
  - `/reportes/ingresos` - Análisis de ingresos

#### 6. **Administración** ⚙️
*Menú desplegable visible solo para Administradores y Gerentes*

##### 6.1 **Usuarios** 👤
- **Ruta:** `/usuarios`
- **Descripción:** Gestión de usuarios del sistema
- **Características:**
  - Crear nuevos usuarios
  - Asignación de roles:
    * Admin
    * Gerente
    * Analista
    * Ejecutivo
    * Contador
    * Auditor
  - Activar/Desactivar usuarios
  - Gestión de permisos
  - Historial de accesos
  - Bloqueo por seguridad
- **Acceso:** Admin, Gerente
- **Sub-rutas:**
  - `/usuarios/crear` - Nuevo usuario
  - `/usuarios/perfil` - Perfil personal

##### 6.2 **Configuración** 🔧
- **Ruta:** `/configuracion`
- **Descripción:** Módulo de configuraciones del sistema
- **Características principales:**
  
  **✅ Configuración General** (`/configuracion/general`)
  - Nombre del sitio
  - Email del sistema
  - Teléfonos de contacto (principal y secundario)
  - Horarios de atención
  - Moneda predeterminada (MXN, USD, EUR)
  - Tasa de interés base
  
  **✅ Logo del Sistema** (`/configuracion/logo`)
  - Subida de logotipo personalizado
  - Formatos soportados: JPG, PNG, GIF, SVG
  - Vista previa en tiempo real
  
  **✅ Colores del Sistema** (`/configuracion/colores`)
  - Color primario (navegación)
  - Color secundario (elementos de apoyo)
  - Color de acento (destacados)
  - Vista previa en vivo
  - Selector de color visual
  
  **✅ Configuración PayPal** (`/configuracion/paypal`)
  - Email de cuenta PayPal
  - Client ID de PayPal
  - Secret de PayPal
  - Integración de pagos
  
  **✅ API de Códigos QR** (`/configuracion/apiQr`)
  - URL de API QR
  - API Key
  - Generación masiva de códigos QR
  - Prueba de generación
  
  **✅ Configuraciones Globales**
  - Parámetros del sistema
  - Idioma (es_MX)
  - Zona horaria (America/Mexico_City)
  - Configuraciones recomendadas

- **Acceso:** Solo Administradores

##### 6.3 **Reportes Regulatorios** 📋
- **Ruta:** `/reportes/regulatorio`
- **Descripción:** Cumplimiento normativo
- **Características:**
  - Reportes R01, R04, R06
  - Circular Única de Bancos
  - Reportes CNBV
  - Reportes CONDUSEF
  - Control de envíos
  - Historial de reportes

---

## 📱 CARACTERÍSTICAS ADICIONALES DEL SISTEMA

### Seguridad 🔒
- Autenticación con `password_hash()` de PHP
- Protección contra SQL Injection (PDO)
- Protección CSRF en formularios
- Bloqueo automático por intentos fallidos (5 intentos = 30 min)
- Control de sesiones
- Auditoría completa de acciones
- Roles y permisos granulares

### Notificaciones 🔔
- Sistema de notificaciones en tiempo real
- Alertas de pagos próximos
- Notificaciones de vencimientos
- Alertas de nuevas solicitudes
- Contador de notificaciones no leídas

### Auditoría 📝
- Registro de todas las acciones
- Usuario, fecha/hora, IP
- Datos antes/después de cambios
- Trazabilidad completa
- Acceso desde dashboard de auditoría

### Actividades y Calendario 📅
- Integración con FullCalendar.js
- Gestión de:
  * Reuniones
  * Llamadas
  * Visitas
  * Seguimiento
  * Cobranza
- Prioridades (Baja, Media, Alta, Urgente)
- Recordatorios automáticos

### Documentos 📄
- Gestión documental completa
- Tipos de documentos:
  * INE
  * Comprobante de domicilio
  * Comprobante de ingresos
  * Estados de cuenta
  * Contratos
  * Pagarés
- Almacenamiento organizado
- Asociación a clientes/créditos

### Cumplimiento Regulatorio 🏛️
- **CNBV** - Comisión Nacional Bancaria y de Valores
- **CONDUSEF** - Comisión Nacional para la Protección de Usuarios
- **Banxico** - Banco de México
- Reportes automáticos
- Tasas de interés históricas
- Control de operaciones

---

## 🎨 DISEÑO Y EXPERIENCIA DE USUARIO

### Tecnologías Frontend
- **Tailwind CSS** - Framework CSS minimalista y elegante
- **Font Awesome 6** - Iconos profesionales
- **Chart.js** - Gráficas interactivas
- **ApexCharts** - Gráficas avanzadas
- **FullCalendar.js** - Calendario interactivo
- **Diseño Responsivo** - Compatible con móviles y tablets

### Características de UI/UX
- Interfaz limpia y minimalista
- Colores personalizables
- Navegación intuitiva
- Feedback visual inmediato
- Tooltips y ayudas contextuales
- Carga rápida
- Experiencia fluida

---

## 🚀 TECNOLOGÍA Y ARQUITECTURA

### Backend
- **PHP Puro** (sin frameworks)
- **Arquitectura MVC**
- **Patrón Singleton** para DB
- **Autoloader** de clases
- **URL amigables** con .htaccess
- **Base URL** auto-detectable

### Base de Datos
- **MySQL 5.7+**
- **Diseño normalizado**
- **Índices optimizados**
- **Vistas SQL** para consultas complejas
- **Procedimientos almacenados** (futuro)
- **Transacciones** para integridad

### Seguridad
- Headers de seguridad HTTP
- Sanitización de entradas
- Validación de datos
- Prevención XSS
- Protección CSRF
- Control de acceso basado en roles

---

## 📊 ESTADÍSTICAS DEL CÓDIGO

- **32+ archivos** en la estructura base
- **22,000+ líneas** de código SQL (database.sql)
- **10+ controladores** implementados
- **15+ vistas** creadas
- **100% PHP puro** sin dependencias externas
- **Responsive design** en todas las páginas
- **SEO-friendly** URLs

---

## 🎯 PRÓXIMAS CARACTERÍSTICAS (Roadmap)

- [ ] Integración con APIs bancarias
- [ ] Firma electrónica de contratos
- [ ] App móvil (iOS/Android)
- [ ] Chatbot de atención
- [ ] Dashboard de BI avanzado
- [ ] Machine Learning para scoring
- [ ] Blockchain para contratos
- [ ] Integración con WhatsApp Business

---

## 📞 SOPORTE Y CONTACTO

**Institución:** Plataforma Financiera Mexicana  
**Email:** contacto@plataformafinanciera.mx  
**Versión:** 1.0.0  
**Estado:** ✅ Producción Ready

---

*Desarrollado con ❤️ para Instituciones de Crédito Mexicanas*
