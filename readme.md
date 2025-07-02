# Gingersauce

## Design:
https://www.figma.com/file/jfDKbwbwz0Wg92cslGVMUK/phase-4?node-id=38%3A63



### Project setup steps:

- First set this versions in your system
    - node: `v8.10.0`
    - npm: `6.14.11`
    - PHP `7.2.24`
- Do installation of [Snappy](https://github.com/barryvdh/laravel-snappy)
- Go to project root directory from terminal
- Copy paste `.env.example` into `.env` file in root directory
  ```shell
  cp .env.example .env
  ```
- Create database with name `gingersauce`
- Do necessary changes in `.env` file (optional)
- Run following commands:
  ```shell
  composer install
  php artisan key:generate
  php artisan migrate:fresh
  yarn && yarn run dev
  ```
- If you need test data run following `(must be in staging server)`:
  ```shell
  php artisan db:seed
  ```
- Take `theme.sql` and `theme.zip` file from other member teammates or from server
- Import `theme.sql` into database
- unzip the `theme.zip` and put the `theme` directory into `storage\app\public` directory


