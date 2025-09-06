# API Empresas - Laravel 12

API REST desarrollada en **Laravel 12** para la gestión de empresas.  
Incluye **CRUD completo**, validaciones, y una funcionalidad para **eliminar en lote todas las empresas inactivas**.  
El proyecto cuenta con **tests unitarios y de integración**.

---

## 🚀 Requisitos

- PHP >= 8.2
- Composer
- MySQL
- Laravel 12
- Extensiones de PHP: `pdo_mysql`

---

## ⚙️ Instalación
f
Clonar el repositorio:

```bash
git clone https://github.com/martingabrielgimenez/empresas-api.git
cd empresas-api


🧪 Tests

El proyecto cuenta con pruebas unitarias y de características.

Ejecutar:

php artisan test

📌 Endpoints principales
Empresas

GET /api/empresas → Lista todas las empresas

GET /api/empresas/{nit} → Ver detalle de una empresa por NIT

POST /api/empresas → Crear una empresa

PUT /api/empresas/{nit} → Actualizar una empresa existente

PATCH /api/empresas/{nit} → Actualizar parcialmente una empresa

DELETE /api/empresas/{nit} → Eliminar una empresa por NIT

Eliminación masiva

DELETE /api/empresas/inactivas → Elimina todas las empresas con estado Inactivo

📄 Ejemplos de uso
Crear empresa

Request (POST /api/empresas):

{
  "nit": "123456789",
  "nombre": "Empresa Demo",
  "direccion": "Calle Falsa 123",
  "telefono": "555-1234",
  "estado": "Activo"
}


Response:

{
  "id": 1,
  "nit": "123456789",
  "nombre": "Empresa Demo",
  "direccion": "Calle Falsa 123",
  "telefono": "555-1234",
  "estado": "Activo",
  "created_at": "2025-09-06T15:30:00.000000Z",
  "updated_at": "2025-09-06T15:30:00.000000Z"
}

Eliminar empresas inactivas

Request (DELETE /api/empresas/inactivas):

Response:

{
  "success": true,
  "message": "3 empresas eliminadas"
}

📚 Tecnologías utilizadas

Laravel 12
 – Framework PHP

MySQL
 – Base de datos

PHPUnit
 – Pruebas

✨ Autor

Desarrollado por Martín Gimenez