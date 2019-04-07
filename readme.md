# PlaceToPay

El proyecto está hecho con [Laravel](https://laravel.com/docs/5.8) 5.8 y usa [Faker](https://github.com/fzaninotto/Faker) para generar datos en las pruebas unitarias y [Guzzle](<(https://github.com/guzzle/guzzle)>) para las peticiones a su API.

-   Se utilizó `TDD` para los casos de prueba de crear un pago y crear un comprador.
-   Se utilizó un `Observer` de Laravel para crear la fecha de expiración de la transacción con una hora de duración automáticamente se registre un pago.
-   Se creó un `ServiceProvider` llamado `PlaceToPayServiceProvider` para registar el `Facade PlaceToPay` y así llamar globalmente al `Helper PlaceToPay`, clase encargada de realizar las peticiones a su API.

## Clonar proyecto

```sh
git clone https://github.com/paleox/placetopay.git
```

## Instalar dependencias

Una vez se haya clonado el proyecto se deben instalar las dependencias de Laravel

```sh
cd placetopay
composer install
```

## Configurar .env

Como prerrequisito la base de datos debe estar creada. Se debe crear un archivo llamado `.env` partiendo de la estructura del archivo `.env.example` y se deben configurar las siguientes variables con sus respectivos valores:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=placetoplay
DB_USERNAME=root
DB_PASSWORD=

PTP_LOGIN=login
PTP_SECRET=secretKey
PTP_ENDPOINT=https://test.placetopay.com/redirection/
PTP_LOCALE=es_CO
```

Una vez configurado es necesario generar el `key` de la aplicación:

```sh
php artisan key:generate
```

\*\*Los parámetos `PTP` son opcionales ya que cuentan con su propio archivo de configuración ubicado en `placetopay\config\placetopay.php`

## Pruebas unitarias

Las pruebas unitarias se encuentran en `placetopay\tests\Feature\Http\Controllers`. Para ejecutar las pruebas unitarias se usan los comandos:

```sh
.\vendor\bin\phpunit.bat tests\Feature\Http\Controllers\PaymentControllerTest.php
.\vendor\bin\phpunit.bat tests\Feature\Http\Controllers\BuyerControllerTest.php
```

Si se desea ejecutar un método en especifico se usa `--filter nombre_metodo` por ejemplo:

```sh
.\vendor\bin\phpunit.bat tests\Feature\Http\Controllers\PaymentControllerTest.php --filter can_create_a_payment
```

\*\*Es importante recordar que cada vez que se ejecuten las pruebas la base de datos será reseteada por el uso del `trait RefreshDatabase`

## Crear tablas y poblar base de datos

```sh
php artisan migrate --seed
```

## Ejecutar el proyecto

```sh
php artisan serve
```
