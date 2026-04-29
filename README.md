# Guía de Instalación y Configuración del Proyecto

Esta guía detalla los pasos necesarios para desplegar la aplicación en un entorno local utilizando **Docker**. Este método garantiza que todas las dependencias (PHP, MySQL, Servidor Web) se configuren automáticamente de forma idéntica al entorno de desarrollo original.

---

## 1. Requisitos Previos

Antes de comenzar, asegúrese de tener instalados los siguientes componentes en su equipo:

* **Docker Desktop** (incluye Docker Compose).
* **Git** (para la gestión del código fuente).
* Un navegador web actualizado.

---

## 2. Preparación del Entorno

### 2.1. Clonar el repositorio
Abra una terminal y ejecute el siguiente comando para descargar el proyecto:
```bash
git clone https://github.com/irammar747/edukey.git
cd edukey
```

### 2.2. Configuración de Variables de Entorno
El proyecto utiliza un archivo de configuración para la base de datos. Asegúrese de que su archivo `.env` o contenga la cadena de conexión configurada para los contenedores de Docker:

```env
DATABASE_URL="mysql://edukey_user:edukey_password@database:3316/edukey_db?serverVersion=8.0&charset=utf8mb4"
```

## 3. Puesta en Marcha con Docker
El proyecto está diseñado para automatizar la creación de la infraestructura.

### 3.1. Levantar Contenedores
Ejecute el siguiente comando en la raíz del proyecto para construir e iniciar los servicios (PHP y MySQL):

```bash
docker-compose up -d --build
```

### 3.2. Instalación de Dependencias (Composer)
Una vez que los contenedores estén en ejecución, debe instalar las librerías de Symfony ejecutando el siguiente comando directamente en el contenedor de PHP:

```bash
docker exec -it symfony_app composer install
```

## 4. Preparación de la Base de Datos
El sistema está configurado para que la base de datos se inicialice con datos de prueba de forma automática.

### 4.1. Inicialización automática
Al levantar el contenedor por primera vez, Docker detectará y ejecutará el volcado SQL ubicado en:
`./docker/mysql/init.sql`

### 4.2. Restauración manual
Si necesita resetear la base de datos a su estado original de prueba en cualquier momento, ejecute el siguiente comando:

```bash
docker exec -i symfony_db mysql -u root -padmin edukey_db < ./docker/mysql/init.sql
```

## 5. Acceso a la Aplicación
Tras completar los pasos anteriores, la aplicación será accesible a través del navegador:

> **URL de acceso:** [http://localhost:8000](http://localhost:8000)

### Datos de acceso de prueba
Para facilitar la evaluación, puede utilizar las siguientes credenciales preconfiguradas:

| Rol | Usuario / Email | Contraseña |
| :--- |:----------------| :--- |
| **Administrador** | `admin`         | `admin123` |
| **Personal** | `personal`      | `personal123` |
| **Docente** | `docente`       | `docente123` |

## 6. Resolución de Problemas Comunes

### 6.1. Conflicto de Puertos
Si los puertos **8000** o **3306** ya están ocupados por otros servicios en su máquina host, modifique el mapeo en el archivo `docker-compose.yml`.

### 6.2. Limpieza de Caché
Si el sistema no refleja cambios recientes en la configuración, ejecute el comando de limpieza de caché de Symfony:

```bash
docker exec -it symfony_app php bin/console cache:clear
```

*Proyecto de fin de ciclo. Desarrollado con Symfony, MySQL y Docker.*
