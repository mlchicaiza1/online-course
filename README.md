
## Iniciar el Proyecto 
El proyecto esta configurado con Docker,
    docker-compose up --build -d      

## Cargar Infotmacion en Las tablas de Permisos, Roles y crear usuario Admin
php artisan db:seed --class=RolesAndPermissionsSeeder

    correo: admin@admin.com
    contraseña: 12345678

