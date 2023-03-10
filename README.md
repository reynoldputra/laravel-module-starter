# Set up

## Last Progress
- creating dto
- create simple error handling for validtion error
- dto file structure
- implement auth
- continue to write readme
## TO DO
- fix seeder validation column and error handling log level
- throttle

## 1. Configuration
- Run composer install
- Create new database
- Create new .env file by duplicating .env.example
- Change database env with your own configuration

## 2. Authentication
### a. User Models
- I created mutator method in User Model/Entities for auto hashing password when create/update password


## 3. Design Pattern
A design pattern provides a general reusable solution for the common problems that occur in software design. The pattern typically shows relationships and interactions between classes or objects. The idea is to speed up the development process by providing well-tested, proven development/design paradigms.

### Laravel modularity
I use laravel-modules package to organize laravel folder structure. nwidar/laravel-modules is a Laravel package which was created to manage your large Laravel app using modules. A module is like a Laravel package, it has some views, controllers or models.
<a href="https://nwidart.com/laravel-modules/v6/introduction">Read more about laravel-modules</a>

#### a. Move default user database
- I move default user migration such as personal_access_tokens, users, password_resets from /Database to Auth Module in /Modules/Auth/Database so i can setup anything related to authentication and user in that module
- I didn't move failed_jobs migration because it has nothing to do with Auth Module
- I realized one important thing, i try to change personal_acces_tokens migration and i got an error when run artisan migrate because 'artisan' looking for migration named '2019_12_14_000001_create_personal_access_tokens_table.php' so i changed the file name back to how it was and error solved :D
- Laravel module run seeder in each module using default seeder that created when we first created module. For example, when i create Auth Module, it will also created AuthDatabaseSeeder. We can make another seeder and call it from AuthDatabaseSeeder
- By the way, i have made helper for seeding database from csv
#### b. Optimize Laravel Models
In my opinion, instead of using repository pattern in laravel, it is better to use model/entity and then optimize service in our code. Most of part in repository pattern is can be handled by model/entitiy in laravel, because laravel have eloquent ORM that can be use for building query.
Optimizing laravel model can be done by using some feature that very usefull like accessor for get specific data from model.

```php

// In laravel model
// Get slug from user name

public function getSlugName($name){
    $slugName = preg_replace('/[^A-Za-z0-9-]+/', '-', $urlString);
    return ucfirst($slugName)
}


```

Another example is using set atribute to give some action before set some data to database.

```php

// Module/Auth/Entities/User.php
// Hashing password before save to database

public function setPasswordAttribute($password){
    $this->attributes['password'] = Hash::make($password);
}

```
#### c. Service layer

#### d. Request layer
#### e. Response layer


## 4. Throttle


#### Reference
- <a href="https://cerwyn.medium.com/laravel-generalizing-api-response-error-handling-85646a195fea">Generalizing API Response & Error Handling</a>
- <a href="https://laracasts.com/discuss/channels/laravel/whats-your-opinion-on-the-service-repository-pattern">What's Your Opinion on the Service + Repository Pattern?</a>