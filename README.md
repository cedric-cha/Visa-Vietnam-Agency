# E-VISA VIETNAM ONLINE

## Installation
```bash
git https://github.com/cedric-cha/Visa-Vietnam-Agency.git
cd backend.evisa-vietnam-online.com
```

```bash
composer install
```

```bash
yarn //or
npm install
```

## Setup
```bash
copy .env.example .env //on Windows
cp .env.example .env //on Linux
```

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

```bash
yarn dev //or
npm run dev
```

## Default users
```bash
admin@mail.com:password
```