# Sistema de Inventarios y Ventas con RFID
## Instalación

Para crear la base de datos:
```
php artisan migrate
```

Para rellenar datos iniciales:

```
php artisan db:seed
```

Para ejecutar el sistema en local:

```
php artisan serve
```

Para ejecutar el sistema en red:
En host, colocar la IP de la computadora.
```
php artisan serve --host=192.168.1.5 --port=8000
```
Luego, modificar en el sketch del ESP32 la variable serverName, para que se pueda conectar el circuito al sistema.
