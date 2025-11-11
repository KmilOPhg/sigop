## INSTRUCCIONES PARA INICIAR EL PROYECTO
Este proyecto es una aplicación web desarrollada con Laravel y Boostrap. A continuación, se detallan los pasos necesarios para iniciar el proyecto en tu entorno local.

### Requisitos previos
Antes de comenzar, asegúrate de tener instalados los siguientes requisitos en tu máquina:
- PHP >= 8.0
- Composer
- Node.js y npm
- Un servidor de base de datos (MySQL)

### Pasos para iniciar el proyecto
1. **Clonar el repositorio**
   Abre tu terminal y clona el repositorio del proyecto utilizando el siguiente comando:
   ```bash
   git clone
   
2. Navegar al directorio del proyecto
   ```bash
   cd nombre-del-proyecto
   ```
3. **Instalar las dependencias de PHP**
4.   Ejecuta el siguiente comando para instalar las dependencias de PHP utilizando Composer:
   ```bash
   composer install
   ```
5. **Instalar las dependencias de JavaScript**
   Ejecuta el siguiente comando para instalar las dependencias de JavaScript utilizando npm:
   ```bash
   npm install
   ```
6. **Configurar el archivo .env**
   Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`:
   ```bash
   cp .env.example .env
    ```
    Luego, abre el archivo `.env` y configura las variables de entorno, especialmente las relacionadas con la base de datos.
7. **Generar la clave de la aplicación**
   Ejecuta el siguiente comando para generar la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```
8. **Migrar la base de datos**
   Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
   ```bash
   php artisan migrate
    ```
9. **Ejecutar las seeders**
    ```bash
    php artisan db:seed --class=RolePermissionSeeder
    php artisan db:seed --class=AdminUserSeeder
    ```
10. **Compilar los activos de frontend**
11.   Ejecuta el siguiente comando para compilar los activos de frontend utilizando Laravel Mix:
    ```bash
    npm run dev
    ```
12. **Iniciar el servidor de desarrollo**
    Finalmente, inicia el servidor de desarrollo de Laravel con el siguiente comando:
    ```bash
    php artisan serve
    ```
    Ahora puedes acceder a la aplicación en tu navegador web en `http://localhost:8000`.
14. **Para funcionalidad de recuperacion de contraseña hable con el desarrollador.**
