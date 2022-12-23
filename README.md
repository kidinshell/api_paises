
## Instrucciones

## Instalaciones Previas
1. Instalar WAMP(recomendado), XAMP o LAMP (https://www.wampserver.com/en/)
2. versión de php -8.1  / versión phpmyadmin 5.2.0 
3. Instalar Git (https://git-scm.com/download/win)
4. Instalar composer(https://getcomposer.org/download/)

## Instalación del proyecto 
1. Clona el repositorio en el directorio que quieras con "git clone url"
2. Crea un Directorio virtual (http://localhost/add_vhost.php)
3. Abre un Terminal en la carpeta del proyecto.
4. Ejecuta "composer update"

## Crear la base de datos
1. entra en http://localhost/phpmyadmin/ (usuario: root, sin contraseña)
2. crear base de datos
3. Modificar el .env:
    DATABASE_URL="mysql://root:@127.0.0.1:3306/DATABASE?serverVersion=8.0.27"
4. Abre terminal en carpeta de proyecto
5. Ejecuta las migraciones.

## Acceder a la Aplicacion
1. entrar en http://localhost/nombrehostvirtual
