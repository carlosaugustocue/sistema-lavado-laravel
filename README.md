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


## Consultas para Clientes

### Listar todos los clientes ordenados por apellido y nombre
```sql
SELECT * FROM clientes ORDER BY apellido, nombre;
```

### Buscar un cliente por nombre o apellido
```sql
SELECT * FROM clientes 
WHERE nombre LIKE '%término_búsqueda%' 
OR apellido LIKE '%término_búsqueda%';
```

### Obtener un cliente específico con sus vehículos
```sql
SELECT c.*, v.* 
FROM clientes c
LEFT JOIN vehiculos v ON c.id = v.cliente_id
WHERE c.id = 1;
```

## Consultas para Vehículos

### Listar todos los vehículos con información del cliente
```sql
SELECT v.*, c.nombre, c.apellido
FROM vehiculos v
JOIN clientes c ON v.cliente_id = c.id
ORDER BY v.placa;
```

### Buscar vehículo por placa
```sql
SELECT v.*, c.nombre, c.apellido
FROM vehiculos v
JOIN clientes c ON v.cliente_id = c.id
WHERE v.placa = 'ABC123';
```

### Historial de lavados de un vehículo específico
```sql
SELECT l.*, s.nombre as servicio_nombre, s.precio
FROM lavados l
JOIN servicios s ON l.servicio_id = s.id
WHERE l.vehiculo_id = 1
ORDER BY l.created_at DESC;
```

## Consultas para Empleados

### Listar todos los empleados activos
```sql
SELECT * FROM empleados WHERE activo = 1 ORDER BY apellido, nombre;
```

### Obtener lavados recibidos por un empleado
```sql
SELECT l.*, v.placa, s.nombre as servicio_nombre
FROM lavados l
JOIN vehiculos v ON l.vehiculo_id = v.id
JOIN servicios s ON l.servicio_id = s.id
WHERE l.empleado_id = 1;
```

### Obtener lavados asignados a un empleado
```sql
SELECT l.*, v.placa, s.nombre as servicio_nombre
FROM lavados l
JOIN vehiculos v ON l.vehiculo_id = v.id
JOIN servicios s ON l.servicio_id = s.id
WHERE l.empleado_asignado_id = 1;
```

### Obtener carga de trabajo por empleado (lavados pendientes)
```sql
SELECT e.id, e.nombre, e.apellido, COUNT(l.id) as lavados_pendientes
FROM empleados e
LEFT JOIN lavados l ON e.id = l.empleado_asignado_id
WHERE e.activo = 1 AND (l.estado = 'pendiente' OR l.estado = 'en_proceso')
GROUP BY e.id, e.nombre, e.apellido;
```

## Consultas para Turnos

### Listar turnos por fecha
```sql
SELECT t.*, e.nombre, e.apellido 
FROM turnos t
JOIN empleados e ON t.empleado_id = e.id
WHERE DATE(t.fecha) = '2023-04-02'
ORDER BY t.hora_inicio;
```

### Obtener todos los turnos del mes actual
```sql
SELECT t.*, e.nombre, e.apellido 
FROM turnos t
JOIN empleados e ON t.empleado_id = e.id
WHERE t.fecha BETWEEN '2023-04-01' AND '2023-04-30'
ORDER BY t.fecha, t.hora_inicio;
```

## Consultas para Lavados

### Listar todos los lavados con información relacionada
```sql
SELECT l.*, v.placa, s.nombre as servicio, 
       c.nombre as cliente_nombre, c.apellido as cliente_apellido,
       e1.nombre as recibido_por, e2.nombre as asignado_a
FROM lavados l
JOIN vehiculos v ON l.vehiculo_id = v.id
JOIN servicios s ON l.servicio_id = s.id
JOIN clientes c ON v.cliente_id = c.id
JOIN empleados e1 ON l.empleado_id = e1.id
LEFT JOIN empleados e2 ON l.empleado_asignado_id = e2.id
ORDER BY l.created_at DESC;
```

### Listar servicios pendientes
```sql
SELECT l.*, v.placa, s.nombre as servicio, 
       c.nombre as cliente_nombre, c.apellido as cliente_apellido
FROM lavados l
JOIN vehiculos v ON l.vehiculo_id = v.id
JOIN servicios s ON l.servicio_id = s.id
JOIN clientes c ON v.cliente_id = c.id
WHERE l.estado IN ('pendiente', 'en_proceso')
ORDER BY l.hora_entrada ASC;
```

### Obtener insumos utilizados en un lavado específico
```sql
SELECT u.*, i.nombre, i.unidad_medida, i.costo
FROM uso_insumos u
JOIN insumos i ON u.insumo_id = i.id
WHERE u.lavado_id = 1;
```

## Consultas para Servicios

### Listar todos los servicios activos
```sql
SELECT * FROM servicios WHERE activo = 1 ORDER BY nombre;
```

### Calcular tiempo promedio por tipo de servicio
```sql
SELECT s.id, s.nombre, 
       AVG(TIMESTAMPDIFF(MINUTE, l.hora_entrada, l.hora_salida)) as promedio_minutos,
       COUNT(l.id) as total_lavados
FROM lavados l
JOIN servicios s ON l.servicio_id = s.id
WHERE l.hora_salida IS NOT NULL AND l.estado = 'completado'
GROUP BY s.id, s.nombre;
```

## Consultas para Insumos

### Listar todos los insumos ordenados por nombre
```sql
SELECT * FROM insumos ORDER BY nombre;
```

### Identificar insumos con stock bajo
```sql
SELECT * FROM insumos 
WHERE stock_actual <= stock_minimo
ORDER BY stock_actual / stock_minimo ASC;
```

### Historial de uso de un insumo específico
```sql
SELECT u.*, l.id as lavado_id, v.placa, u.cantidad, u.created_at
FROM uso_insumos u
JOIN lavados l ON u.lavado_id = l.id
JOIN vehiculos v ON l.vehiculo_id = v.id
WHERE u.insumo_id = 1
ORDER BY u.created_at DESC;
```

## Consultas para Reportes

### Reporte de ingresos diarios
```sql
SELECT 
    DATE(created_at) as fecha,
    COUNT(*) as total_servicios,
    SUM(costo_total) as total_ingresos
FROM lavados
WHERE estado IN ('completado', 'entregado')
GROUP BY DATE(created_at)
ORDER BY fecha DESC;
```

### Ingresos por tipo de servicio en una fecha específica
```sql
SELECT 
    s.nombre as servicio,
    COUNT(l.id) as cantidad,
    SUM(l.costo_total) as total
FROM lavados l
JOIN servicios s ON l.servicio_id = s.id
WHERE DATE(l.created_at) = '2023-04-02'
    AND l.estado IN ('completado', 'entregado')
GROUP BY s.nombre;
```

### Consumo de insumos en un período
```sql
SELECT 
    i.nombre,
    i.unidad_medida,
    SUM(u.cantidad) as cantidad_total,
    SUM(u.cantidad * i.costo) as costo_total
FROM uso_insumos u
JOIN insumos i ON u.insumo_id = i.id
JOIN lavados l ON u.lavado_id = l.id
WHERE l.created_at BETWEEN '2023-04-01' AND '2023-04-30'
GROUP BY i.nombre, i.unidad_medida;
```

### Rendimiento de empleados (lavados completados)
```sql
SELECT 
    e.nombre,
    e.apellido,
    COUNT(l.id) as lavados_completados,
    AVG(TIMESTAMPDIFF(MINUTE, l.hora_entrada, l.hora_salida)) as tiempo_promedio
FROM lavados l
JOIN empleados e ON l.empleado_asignado_id = e.id
WHERE l.estado = 'completado'
    AND l.created_at BETWEEN '2023-04-01' AND '2023-04-30'
GROUP BY e.nombre, e.apellido
ORDER BY lavados_completados DESC;
```

Estas consultas SQL representan las principales operaciones de la aplicación de lavado de vehículos. Pueden servir como referencia para entender la estructura de datos y también para realizar consultas directas a la base de datos si fuera necesario.