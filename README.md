# ProviEmplea EVA3

## Descripción

ProviEmplea es una API REST desarrollada en Laravel para la gestión de una plataforma de búsqueda inversa de empleo, donde las empresas pueden buscar candidatos según sus habilidades, experiencia laboral y nivel educacional.

La plataforma implementa el concepto de **CV Ciego**, ocultando información sociodemográfica sensible de los candidatos para evitar discriminación durante los procesos de selección.

---

## Tecnologías Utilizadas

* PHP 8.4
* Laravel 12
* MySQL 8
* Docker
* Nginx
* Swagger / OpenAPI
* Laravel Sanctum

---

## Arquitectura

El proyecto utiliza una arquitectura basada en contenedores Docker:

* **app:** Laravel + PHP-FPM
* **nginx:** Servidor web
* **mysql:** Base de datos MySQL

---

## Instalación

### Configurar variables de entorno

Copia el archivo de ejemplo y genera la clave de aplicación:

```bash
cp .env.example .env
docker compose run --rm app php artisan key:generate
```

> Las credenciales de la base de datos ya están configuradas en `.env.example`.

### Levantar contenedores

```bash
docker compose up -d --build
```

### Ejecutar migraciones

```bash
docker exec -it proviemplea_app php artisan migrate:fresh
```

### Limpiar caché

```bash
docker exec -it proviemplea_app php artisan optimize:clear
```

### Generar documentación Swagger

```bash
docker exec -it proviemplea_app php artisan l5-swagger:generate
```

---

## URLs del Proyecto

### Aplicación

```text
http://localhost:8000
```

### Health Check

```text
http://localhost:8000/api/documentation#/Health
```

### Swagger UI disponibilizando endpoints

```text
http://localhost:8000/api/documentation
```

---

## Endpoints Disponibles

### Health

| Método | Endpoint    |
| ------ | ----------- |
| GET    | /api/health |

---

### Candidatos

| Método | Endpoint                    |
| ------ | --------------------------- |
| GET    | /api/candidatos             |
| POST   | /api/candidatos             |
| GET    | /api/candidatos/{id}        |
| PUT    | /api/candidatos/{id}        |
| PATCH  | /api/candidatos/{id}/estado |
| DELETE | /api/candidatos/{id}        |

---

### Empresas

| Método | Endpoint                  |
| ------ | ------------------------- |
| GET    | /api/empresas             |
| POST   | /api/empresas             |
| GET    | /api/empresas/{id}        |
| PUT    | /api/empresas/{id}        |
| PATCH  | /api/empresas/{id}/estado |
| DELETE | /api/empresas/{id}        |

---

### Empresa-Candidatos

| Método | Endpoint                     |
| ------ | ---------------------------- |
| GET    | /api/empresa-candidatos      |
| POST   | /api/empresa-candidatos      |
| GET    | /api/empresa-candidatos/{id} |
| PUT    | /api/empresa-candidatos/{id} |
| DELETE | /api/empresa-candidatos/{id} |

---

## Modelo de Datos

### Candidatos

Información privada almacenada:

* Nombre
* Email
* Teléfono
* Edad
* Género
* Comuna de residencia

Información visible para empresas:

* Nivel educacional
* Experiencia laboral
* Habilidades
* Certificaciones
* Referencias
* Estado

### Empresas

* RUT empresa
* Nombre empresa
* Rubro
* Email de contacto
* Teléfono
* Beneficios
* Estado

### Empresa-Candidato

Permite relacionar empresas con candidatos de interés.

Campos principales:

* Empresa
* Candidato
* Cargo buscado
* Estado del proceso
* Observaciones

---

## CV Ciego

La API implementa el concepto de CV Ciego utilizando la propiedad `$hidden` de Eloquent.

Los siguientes campos se almacenan en la base de datos, pero no son visibles en las respuestas públicas:

```php
protected $hidden = [
    'nombre',
    'email',
    'telefono',
    'edad',
    'genero',
    'comuna_residencia'
];
```

---

## Ejemplo Crear Candidato

```json
{
  "nombre": "Juan Pérez",
  "email": "juan@test.cl",
  "telefono": "+56911111111",
  "edad": 28,
  "genero": "Masculino",
  "comuna_residencia": "Providencia",
  "nivel_educacional": "Universitario Completo",
  "experiencia_laboral": "3 años como desarrollador backend",
  "habilidades": "PHP, Laravel, MySQL",
  "certificaciones": "AWS Practitioner",
  "referencias": "Empresa ABC"
}
```

---

## Ejemplo Crear Empresa

```json
{
  "rut_empresa": "76.123.456-8",
  "nombre_empresa": "Tech Solutions",
  "rubro": "Tecnología",
  "email_contacto": "rrhh@techsolutions.cl",
  "telefono": "+56222222222",
  "beneficios": "Seguro complementario y trabajo remoto"
}
```

---

## Rendimiento y Optimización

La documentación OpenAPI incluye recomendaciones de optimización:

* Caché para operaciones GET.
* Límite sugerido de 60 solicitudes por minuto.
* Tiempo esperado para GET menor a 200 ms.
* Tiempo esperado para POST, PUT y PATCH menor a 500 ms.
* Tiempo esperado para DELETE menor a 300 ms.

---

## Pruebas Realizadas

Se verificaron las siguientes operaciones mediante Swagger UI:

* Estado de salud de la API.
* Creación de candidatos.
* Consulta de candidatos utilizando CV ciego.
* Creación de empresas.
* Relación empresa-candidato.
* Actualización de registros.
* Activación y desactivación de registros.
* Eliminación de registros.

---


