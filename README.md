⚙️ Installation Guide

Follow these steps to run the project locally.

1️⃣ Clone Repository
git clone https://github.com/your-username/cake-shop.git
cd cake-shop
2️⃣ Install PHP Dependencies
composer install
3️⃣ Create Environment File
cp .env.example .env

Generate application key:

php artisan key:generate
4️⃣ Configure Database

Open .env file and update:

DB_DATABASE=cake_shop
DB_USERNAME=root
DB_PASSWORD=yourpassword

Create the database in MySQL:

CREATE DATABASE cake_shop;
5️⃣ Run Migrations
php artisan migrate

If seeders are available:

php artisan db:seed
6️⃣ Install Frontend Dependencies
npm install

Run development server:

npm run dev

Or build for production:

npm run build
7️⃣ Storage Linking (For Image Uploads)
php artisan storage:link
8️⃣ Run Application
php artisan serve

Open in browser:

http://127.0.0.1:8000