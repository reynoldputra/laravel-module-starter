# Set up
## 1. Change project name and data base in .env.example
- APP_NAME
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

## 2. Authentication
### a. User Models
- I created mutator method in User Model/Entities for auto hashing password when create/update password using Model

## 3. Throttle

## 4. SOLID

### Laravel modularity
I use laravel-modules package to organize laravel folder structure. nwidar/laravel-modules is a Laravel package which was created to manage your large Laravel app using modules. A module is like a Laravel package, it has some views, controllers or models.
<a href="https://nwidart.com/laravel-modules/v6/introduction">Read more about laravel-modules</a>

#### a. Move default user database
- I move default user migration such as personal_access_tokens, users, password_resets from /Database to Auth Module in /Modules/Auth/Database so i can setup anything related to authentication and user in that module
- I didn't move failed_jobs migration because it has nothing to do with Auth Module
- I realized one important, i try to change personal_acces_tokens migration and i got an error when run artisan migrate because 'artisan' looking for migration named '2019_12_14_000001_create_personal_access_tokens_table.php' so i changed the file name back to how it was and error solved :D

## 5. Testing

## 6. Redis

## 7. Email
