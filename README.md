
# Getting started

A brief description of what this project does and who it's for

## Installation
Clone the repository
```
https://github.com/AdnanAlMaruf/Task-Mangement.git
```
Switch to the repo folder
```
cd Task_management
```
Install all the dependencies using composer
```
composer install
```
Copy the example env file and make the required configuration changes in the .env file
```
cp .env.example .env
```
Generate a new application key
```
php artisan key:generate
```
Run the database migrations (Set the database connection in .env before migrating)
```
php artisan migrate
```
Start the local development server
```
php artisan serve
```
You can now access the server at http://localhost:8000
### TL;DR command list
````
git clone https://github.com/AdnanAlMaruf/Task-Mangement.git
cd Task-Mangement
composer install
cp .env.example .env
php artisan key:generate
````
### Make sure you set the correct database connection information before running the migrations <u>Environment variables</u>
```
php artisan migrate
php artisan serve
```
## Database seeding
### Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.
Run the database seeder and you're done
```
php artisan db:seed
php artisan storage:link
```
**Note:** It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command
```
php artisan migrate:refresh
```
# Code overview
## Dependencies
*  laravel-auth
## Folders 
* app - Contains all the Eloquent models
* app/Http/Controllers/Api - Contains all the api controllers
* app/Http/Middleware - Contains the JWT auth middleware
* app/Http/Requests/Api - Contains all the api form requests
* app/RealWorld/Favorite - Contains the files implementing the favorite feature
* app/RealWorld/Filters - Contains the query filters used for filtering api requests
* app/RealWorld/Follow - Contains the files implementing the follow feature
* app/RealWorld/Paginate - Contains the pagination class used to paginate the result
* app/RealWorld/Slug - Contains the files implementing slugs to articles
* app/RealWorld/Transformers - Contains all the data transformers
* config - Contains all the application configuration files
* database/factories - Contains the model factory for all the models
* database/migrations - Contains all the database migrations
* database/seeds - Contains the database seeder
* routes - Contains all the api routes defined in api.php file
* tests - Contains all the application tests
* tests/Feature/Api - Contains all the api tests
## Environment variables
* .env - Environment variables can be set in this file
Run the laravel development server
```
php artisan serve
```
The api can now be accessed at
```
http://localhost:8000/api
```
