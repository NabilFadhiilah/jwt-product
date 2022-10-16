<!-- GETTING STARTED -->
## Getting Started

Intruksi Penggunaan Aplikasi JWT-Product Menggunakan Laravel 9

### Prerequisites 
Bisa download melalui zip atau git clone menggunakan command line atau pakai github desktop
* command git clone
  ```sh
  gh repo clone NabilFadhiilah/jwt-product
  ```
 
### Installation 
Gunakan Command Line Di Bawah Ini Di Terminal
* Composer
  ```sh
  composer install
  ```
  
Selanjutnya pembuatan tabel
> Jangan Lupa ubah .env.example menjadi .env dan buat database yang sesuai dengan di .env
* Artisan
  ```sh
  php artisan migrate:fresh --seed
  ```
  ```sh
  php artisan jwt:secret
  ```
  
### Usage

Gunakan Command Line ini di terminal
```sh
php artisan serve
```

### API Documentation 
https://documenter.getpostman.com/view/19407125/2s847BTvcf

### Built With
* [Laravel](https://laravel.com)

<p align="right">(<a href="#top">back to top</a>)</p>
