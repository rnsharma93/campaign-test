# Stats viewing app

Create a basic stats viewing application by designing a database schema,
importing data from a CSV file and implementing the routes.

## Installation

It is requires php version ^8.2

```sh
git clone https://github.com/rnsharma93/campaign-test
cd campaign-test
cp .env.example .env
php artisan key:generate
composer install
php artisan migrate:fresh --seed
php artisan app:import-stats stats_2024_03_31.csv
```
