<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requerimientos del sistema

- PHP >= 8.0
- MYSQL 8.0
- Sqlite v3 para ejecución de pruebas
- composer 2.4
- node v16.18.0


## Pasos para instalación

Se debe clonar este repositorio y crear el fichero .env en la raíz del proyecto agregando los datos de conexión
de base de datos en las variables.

- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=alterbrain
- DB_USERNAME=root
- DB_PASSWORD=password

Se deben ejecutar los siguientes comandos para instalar dependencias, ejecutar migraciones, seeders y el npm para el vuejs3.
- composer install
- php artisan key:generate
- php artisan migrate --seed
- npm install
- npm run build

Para levantar la aplicacion se debe ejecutar el comando he ingresar a la ruta con el puerto especificado por lo general es 
http://localhost:8000/ sin embargo puede variar. 
- php artisan serve

Al ingresar a dicha ruta debera visualizarse el login directamente de la aplicación:

- user: test@test.test
- password: password

Una vez autenticado pordrá visualizar el formulario para filtar actividades.

## Ejecución de pruebas unitarias y de integración
Este proyecto tiene pruebas unitarias y de integración tanto de los controladores
como los repositorios.

La diferencia de uno u otro es que las pruebas de integración prueban un todo incluyendo persistencia en la base de datos
y las pruebas unitarias usan mocks para simular comportamientos y no solicitar conexión de base de datos.

Para ejecutar en paralelo
- php artisan test --parallel

Para ejecutar normal
- php artisan test

También se puede ejecutar
- vendor/bin/phpunit

Para ver el coverage se debe tener xdebug instalado, se va generar un directorio llamado "coverage" y al visualizar el index.html en el navegador se podrá 
ver la cobertura de las pruebas en controladores y repositorios.
- vendor/bin/phpunit --coverage-html=coverage
