# Sistema de Gestión para Lavado de Vehículos

![Banner Lavado de Vehículos](https://via.placeholder.com/1200x300/0083B0/ffffff?text=Sistema+de+Lavado+de+Veh%C3%ADculos)

## 📋 Descripción

Este sistema de gestión para lavado de vehículos es una aplicación web desarrollada con Laravel 11 que permite administrar de manera eficiente todos los aspectos del negocio: desde la recepción de vehículos hasta la entrega final, incluyendo gestión de inventario de insumos, asignación de turnos a empleados, y generación de reportes.

La aplicación simplifica la operación diaria del negocio de lavado de vehículos, mejorando la eficiencia y brindando información valiosa para la toma de decisiones.

## ✨ Características Principales

- **Registro de Vehículos**: Control de entrada y salida de vehículos con toda su información.
- **Gestión de Clientes**: Base de datos completa de clientes y su historial de servicios.
- **Asignación de Servicios**: Selección automática del tipo de lavado según características del vehículo.
- **Control de Insumos**: Seguimiento en tiempo real del inventario con alertas de stock bajo.
- **Gestión de Empleados**: Administración de personal, turnos y carga de trabajo.
- **Reportes Detallados**: Análisis de ingresos, tiempos promedio y eficiencia operativa.
- **Interfaz Intuitiva**: Diseño responsive y amigable para facilitar su uso.

## 🚀 Requisitos del Sistema

- PHP 8.2 o superior
- Composer
- MySQL 8.0 o superior
- Node.js y NPM (para assets)
- Servidor web compatible con Laravel (Apache, Nginx)

## ⚙️ Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/carlosaugustocue/sistema-lavado-laravel
   cd lavado-vehiculos
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Configuración del entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**
   
   Edita el archivo `.env` con los datos de conexión a tu base de datos
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lavado_vehiculos
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

5. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Iniciar servidor de desarrollo**
   ```bash
   php artisan serve
   ```

7. **Acceder a la aplicación**
   
   Visita `http://localhost:8000` en tu navegador

## 📸 Capturas de Pantalla

<div align="center">
  <img src="https://via.placeholder.com/400x225/3498db/ffffff?text=Dashboard" alt="Dashboard" width="45%">
  <img src="https://via.placeholder.com/400x225/2ecc71/ffffff?text=Registro+de+Veh%C3%ADculos" alt="Registro de Vehículos" width="45%">
  <img src="https://via.placeholder.com/400x225/e74c3c/ffffff?text=Control+de+Insumos" alt="Control de Insumos" width="45%">
  <img src="https://via.placeholder.com/400x225/f39c12/ffffff?text=Reportes" alt="Reportes" width="45%">
</div>

## 📊 Módulos del Sistema

### 1. Gestión de Clientes y Vehículos
- Registro completo de datos del cliente
- Historial de visitas y servicios
- Búsqueda rápida por nombre o placa
- Registro de múltiples vehículos por cliente

### 2. Administración de Servicios
- Catálogo personalizable de servicios
- Precios configurables por tipo de vehículo
- Tiempos estimados de servicio
- Estadísticas de rendimiento por servicio

### 3. Control de Insumos
- Inventario detallado de productos
- Alertas automáticas de stock bajo
- Registro de consumo por servicio
- Historial de uso de insumos

### 4. Gestión de Personal
- Registro de empleados y sus competencias
- Asignación de turnos de trabajo
- Monitoreo de carga laboral
- Estadísticas de rendimiento por empleado

### 5. Dashboard y Reportes
- Panel principal con información en tiempo real
- Reportes de ingresos diarios, semanales y mensuales
- Estadísticas de tiempos promedio por servicio
- Exportación de datos a Excel/PDF

## 🔧 Tecnologías Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Bootstrap 5, jQuery
- **Base de Datos**: MySQL 8
- **Estilos**: SASS/CSS3
- **JavaScript**: ES6+
- **Reportes**: Laravel Excel, DomPDF

## 🛣️ Roadmap de Funcionalidades Futuras

- [ ] Aplicación móvil para clientes
- [ ] Sistema de citas en línea
- [ ] Integración con pasarelas de pago
- [ ] Sistema de lealtad y promociones
- [ ] Notificaciones por SMS y correo electrónico
- [ ] Módulo de marketing y campañas

## 👥 Contribuciones

Las contribuciones son bienvenidas. Por favor, sigue estos pasos para contribuir:

1. Haz un Fork del proyecto
2. Crea una rama para tu característica (`git checkout -b feature/amazing-feature`)
3. Realiza tus cambios
4. Realiza commit de tus cambios (`git commit -m 'Add some amazing feature'`)
5. Sube la rama (`git push origin feature/amazing-feature`)
6. Abre un Pull Request

## 📝 Licencia

Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo `LICENSE` para más información.

## 📧 Contacto

Si tienes preguntas sobre el proyecto, no dudes en contactarme:

- Email: [caaranzazu_230@cue.edu.co](mailto:caaranzazu_230@cue.edu.co)
- LinkedIn: [Carlos Augusto Aranzazu](https://www.linkedin.com/in/carlos-augusto-aranzazu-a5a566224/)

---

<div align="center">
  <p>Desarrollado con ❤️ para optimizar tu negocio de lavado de vehículos</p>
  <p>© 2025 . Todos los derechos reservados.</p>
</div>