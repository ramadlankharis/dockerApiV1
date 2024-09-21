
# dockerApi

Aplikasi API Laravel 11 dengan docker


## Environment Host

OS version: Ubuntu 22.04

docker : Docker version 27.3.1, build ce12230

docker compose : Docker Compose version v2.29.7


## Run Locally

Clone the project

```bash
  git clone https://github.com/ramadlankharis/dockerApiV1.git
```

Go to the project directory

```bash
  cd my-project
```

Build image dan container docker.

```bash
  docker compose up --build
```

Setting env untuk koneksi ke DBMS (copy .env.example dan rename menjadi .env)

```bash
  # docker setting connection DB
	DB_CONNECTION=mysql
	DB_HOST=mysql #alamat container
	DB_PORT=3306 #port container
	DB_DATABASE=db_docker
	DB_USERNAME=docker
	DB_PASSWORD=qwerty
```

Melihat container yang active

```bash
  sudo docker ps
```

Melihat container yang active. Notes: (Pastikan semua container jalan dan tidak error). Kemudian lihat nama atau id container php-laravel-app.

```bash
  sudo docker ps
```

Masuk ke container php-laravel-app dan menjalankan bash

```bash
  docker exec -it <name-container/id-container> bash
```

Memastikan environment yang mendukung laravel jalan di dalam container 

```bash
  php -v (melihat version php)

  composer (melihat composer info)
```

Melakukan migration table 

```bash
  php artisan migrate
```

Generate API_KEY

```bash
  php artisan key:generate
```

Generate API_KEY

```bash
  php artisan config:cache
```


## Aplikasi Database Administrator

Jika ingin menghubungkan DBMS di dalam container ke Database Administrator yang Anda gunakan maka gunakan alamat dari HOST. berikut adalah contohnya jika menggunakan navicat

#### connection name = .....
#### Host = 127.0.0.1 (Jangan menggunkaan localhost)
#### Port = 4036
#### username dan password sesuai dengan docker compose setting


## Authors

- [@Kharisma](https://github.com/ramadlankharis)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
