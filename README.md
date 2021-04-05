- - - -

Disaster Management Backend
==================

Development tools
----------------
1. [Homebrew](https://brew.sh)
    - `/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
2. [Composer](https://getcomposer.org)
    - `brew install composer`

Setup
----------------
1. Go to project directory and run:
    ```sh
        composer install
    ```
2. Then install passport:
    ```sh
        php artisan passport:install
    ```
3. Run the migration
    ```sh
        php artisan migrate
    ```
4. Make a copy of `.env.sample` and rename it to `.env`
5. Configure the `.env` variables such as:
    ```sh
        DB_DATABASE
        DB_USERNAME
        DB_PASSWORD

        GOOGLE_CLIENT_ID
        GOOGLE_CLIENT_SECRET
        GOOGLE_CLIENT_REDIRECT

        FACEBOOK_APP_ID
        FACEBOOK_APP_SECRET
        FACEBOOK_APP_REDIRECT
    ```
6. Run this command:
    ```sh
        php artisan serve
    ```
7. Done!