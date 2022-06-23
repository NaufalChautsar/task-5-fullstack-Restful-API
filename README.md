<div align="center">
<h3>Virtual Internship Experience (Investree)</h3>
<p>Restful API menggunakan Laravel Passport </p>
</div>

<br></br>
#### Tujuan : Membangun rest api dan oauth token menggunakan laravel framework serta laravel passport

1. Buatlah jwt authentication menggunakan laravel passport
2. Kemudian buatlah restful api posts (create, list all, show detail, update & delete)
3. Gunakan mekanisme middleware auth api passport ke endpoint posts (create, list all, show detail, update dan delete) 
4. Gunakan prefix versi pada api yang telah dibuat (contoh : api/v1)
5. Gunakan relasi eloquent pada table posts dan categories
6. Gunakan pagination pada api list all posts
7. Buatlah unit testing untuk setiap api posts
8. Untuk table yang digunakan silahkan refer pada link ini https://docs.google.com/document/d/18vr7dMZNmxeiT_CS6ofRTik8YygBraRvl0vscNXpRbQ/edit?usp=sharing

<br></br>
### Prepare dependencies
    - composer install
    - cp .env.example .env

### Change Database Config
    Change Database configuration in .env

### Generate and Migration
    - php artisan key:generate
    - php artisan passport:install
    - php artisan passport:client --personal
    - php artisan migrate

### Run PHP Unit Testing
    - php artisan test
