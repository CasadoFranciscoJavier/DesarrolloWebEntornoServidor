---
````markdown
# 📘 Guía Maestra: Entorno Laravel en Windows (XAMPP)

Esta guía cubre desde la configuración inicial para evitar errores de SSL/Antivirus, hasta cómo crear proyectos desde cero o clonarlos desde GitHub.

---

## 🚨 FASE 0: Preparación del Entorno (Anti-Errores)

Si al ejecutar comandos de Composer recibes errores como **"SSL operation failed"**, **"Certificate verify failed"** o **"Time out"**, es porque tu Antivirus está bloqueando la conexión.

**Solución Rápida:**
1.  **Pausa el "Escudo Web"** de tu antivirus durante 10 minutos.
2.  Abre tu terminal (CMD o Git Bash) y ejecuta estos comandos una sola vez para configurar Composer:

```bash
composer config -g disable-tls true
composer config -g secure-http false
````

-----

## 🚀 ESCENARIO A: Crear un Proyecto Nuevo (Desde Cero)

Sigue estos pasos para empezar un proyecto nuevo (por ejemplo, para ejercicios de clase).

### 1\. Verificar Composer

Abre la terminal y escribe:

```bash
composer
```

*Si ves un mensaje con las opciones de uso, está listo.*

### 2\. Crear el Proyecto

Navega a la carpeta donde guardas tus ejercicios y ejecuta:

```bash
composer create-project --prefer-dist laravel/laravel holaMundo
```

> **Nota:** Si sale error de "zip", asegúrate de tener la extensión `extension=zip` habilitada en tu `php.ini`.

**¿Qué hace este comando?**

  * `create-project`: Indica que queremos crear un nuevo proyecto.
  * `--prefer-dist`: Descarga la versión lista para usar (más rápido).
  * `laravel/laravel`: Especifica el paquete de Laravel.
  * `holaMundo`: El nombre de la carpeta que se creará.

**¿Qué sucede?**
Composer descargará Laravel, creará la carpeta `holaMundo` y configurará todo para empezar.

### 3\. Iniciar el Servidor

Entra en la carpeta creada:

```bash
cd holaMundo
```

Arranca el servidor local de desarrollo:

```bash
php artisan serve
```

**¿Qué hace este comando?**

  * `php`: Ejecuta el intérprete.
  * `artisan serve`: Herramienta de Laravel que inicia un mini-servidor web en tu PC.

Deberías ver:

> Starting Laravel development server: http://127.0.0.1:8000

Abre tu navegador y visita: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

-----

## 📥 ESCENARIO B: Clonar un Proyecto Existente (GitHub)

Sigue estos pasos si te descargas el código del profesor o de un compañero. GitHub **NO** sube las librerías ni la configuración local, así que debes reconstruirlas.

### 1\. Clonar y Entrar

```bash
git clone [https://github.com/usuario/repositorio.git](https://github.com/usuario/repositorio.git)
cd nombre-del-repositorio
```

### 2\. Instalar Dependencias (¡Importante\!)

Esto descarga la carpeta `vendor` que falta.
*(Recuerda pausar el antivirus si falla)*.

```bash
composer install
```

### 3\. Configurar el Entorno (.env)

Crea tu archivo de configuración personal copiando el ejemplo.

```bash
copy .env.example .env
```

### 4\. Generar la Clave de Aplicación

Laravel necesita una clave para encriptar sesiones.

```bash
php artisan key:generate
```

### 5\. Preparar la Base de Datos (SQLite)

Si el proyecto usa base de datos, crea el archivo y las tablas.

1.  Crea el archivo vacío:
    ```bash
    type nul > database/database.sqlite
    ```
2.  Crea las tablas:
    ```bash
    php artisan migrate
    ```

### 6\. Arrancar

```bash
php artisan serve
```

-----

## 🛠️ Solución de Problemas Comunes

### Error 404 (Not Found) al entrar a la web

  * **Causa:** Estás entrando a la raíz `/` pero en `routes/web.php` no hay ruta definida para `/`.
  * **Solución:** Revisa el archivo `routes/web.php`. Si la ruta es `Route::get('/hola'...)`, entra a `http://127.0.0.1:8000/hola`.

### Error "Failed opening required .../vendor/autoload.php"

  * **Causa:** Te falta la carpeta `vendor`.
  * **Solución:** Ejecuta `composer install`.

### Error "SSL certificate problem / Error 60"

  * **Causa:** Tu antivirus está interceptando la conexión.
  * **Solución:** Pausa el escudo web del antivirus y vuelve a intentar el comando.

<!-- end list -->

```
```