Dashboar de usuarios con rol de administrador y usuario estandar.

1. Lenguaje y framework: PHP 8.2; Laravel 10.10
2. Lengauje complementario para intefaz(frontn-end); Javascript
3. Base de datos: Mysql (Se adjunta script de.sql para ser importado bien sea por mysql workbench o mariaDb Xampp)

4. Instalación:

5. Desde una terminal o CMD, digitar: 

git clone https://github.com/sebastesb1986/fenix_prueba.git

6. Una vez descargado el proyecto, nos dirigimos a la carpeta del mismo a partir de cd/fenix_prueba y una vez adentro, digitamos:

composer install

7. Una vez instaladas y configuradas las dependencias para el framework de PHP Laravel, nos dirigimos al archivo .env.example y lo renombramos
a:  .env

7.1 Adentro de .env, configuramos con nuetsras credenciales las siguientes variables de configuración:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phoenixusers (en caso de que la base de datos ya haya sido creada)
DB_USERNAME=root
DB_PASSWORD=admin123 (o el password que tenga tu entorno de base de datos mysql)

8. Opcional: 

A. Digitamos en consola: php artisan migrate y desde nuestras migraciones se migraran las tablas de datos
A.1. una vez completa el paso A, digitamos: php artisan migrate:refresh --seed con el fin de agregar el usuario administrador a nuestra aplicación
B. Importamos el .sql de la carpeta mysql_DB que contiene un script llamado phoenixusers.sql(aqui ya s eencuentran datos de usuariosregistrados)

9. Una vez importado todo sin dificultad, procedemos a digitar en consola: php artisan serve

9.1 y en nuestro navegador ingresamos a: http://127.0.0.1:8000 que nos redirigira a http://127.0.0.1:8000/login

10. Una vez ubicados en login si se siguieron los pasos anteriores podriamos inicar sesión con los usuarios:

admin2023@gmail.com(administrador); usuario2023@gmail.com y el password para ambos default es 12345678

Nota: Cada usuario tiene su vista de rol, a la izquierda, es posible desplegar un panel para adminstrar usuarios(Rol administrador)
y para el caso de un usuario estandar, administrara solo su perfil.

Solo un usuario administrador puede registrar y eliminar usuarios; un usuario estandar solo puede actualizar su perfil de datos

Para un usuario estandar que intente eliminar un usuario, se le enseñara la alerta del caso que no tiene permisos para ello.

Para el caso de un usuario administrador, le es posible realizar operaciones como administrar otros usuarios.

Para cualquier inquietud, observación y/o sugerencia contactame via email: salgadosb1986@gmail.com

Espero sea de tu agrado y gran ayuda esta prueba y aplicación.