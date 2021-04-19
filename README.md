## Disaster Management Backend

## Development tools

[Homebrew](https://brew.sh/) — `/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

[Composer](https://getcomposer.org) — `brew install composer`

[PHP](https://www.php.net/) — `brew install php`

[MySQL](https://www.mysql.com/) — `brew install mysql`

## Setup

Go to project directory and run:

    ```sh
        composer install
    ```

Make a copy of `.env.sample` and rename it to `.env`

Create MYSQL Database named `disaster_management_db`

Install passport:

    ```sh
        php artisan passport:install
    ```

Run the Migration with Seeder

    ```sh
        php artisan migrate:fresh --seed
    ```

Run Artisan Serve

    ```sh
        php artisan serve
    ```

Local Dev Sites:
- http://disaster-management.test/
- http://localhost:8000/
- http://127.0.0.1:8000/

GraphQL Playground
- http://disaster-management.test/graphql-playground
- http://localhost:8000/graphql-playground
- http://127.0.0.1:8000/graphql-playground

## Facebook Test Users

Email:
- tggexdwhjj_1618306485@tfbnw.net
- bshyajgylf_1618306485@tfbnw.net
- ivoempnupf_1618306485@tfbnw.net
- njztasfyzz_1618306485@tfbnw.net

Password: admin12345