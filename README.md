## Installation

1. Clone this repository
2. Create DATABASE with name `vendorbest` if in your mysql database is doesn't exists
3. Run in the console 
    1. Install dependency   
        ```console
        composer install
    2. Migrate database
        ```console     
        php artisan migrate
    3. User dummy seeder    
        ```console
        php artisan make:seed --class=UserSeeder 
    4. Menu seeder          
        ```console
        php artisan make:seed --class=MenuSeeder 
    5. Jika ingin refresh data
        ```console
        php artisan migrate:fresh --seed
4. Start server 
    ```console
    php artisan serve
5. Login
    Admin   : `admin@vendorbest.com` : `admin`
    Vendor  : `vendor@vendorbest.com` : `vendor`