# Set up

## 1. Configuration
- Run composer install
- Create new database on your local computer
- Create new .env file by duplicating .env.example
- Change database env with your own configuration
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

```
- Create app key
```
php artisan key:generate 
```
- Create passport keys and personal access client
```
php artisan passport:keys
php artisan passport:client --personal
```
## 2. Authentication
- User models is located in Auth Module. I use entity folder to store model in every module
- I created mutator method in User Model/Entities for auto hashing password when create/update password

```php

// Module/Auth/Entities/User.php
// Hashing password before save to database

public function setPasswordAttribute($password){
    $this->attributes['password'] = Hash::make($password);
}

```
- This template is using laravel/passport for authenticate user, passport is more flexible, especially when we want to implement oAuth2 for third party login

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

// In some laravel model
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
#### c. Request layer
In laravel we have FormRequest that can be use to separate request instance for each endpoint. But instead only use that for validation, i use FormRequest or Request Layer as Data Transfer Object (DTO), so the request data can be sent to several layer (such as controller and service) with same data type. 
- First of all i create `app/Request/ApiRequest.php` for default function in DTO and more semantic function name.
```php
class ApiRequest extends FormRequest
{
  public function getAllFields() : array 
  {
    return $this->all();
  }
  
  public function getFieldValue(string $key) : mixed
  {
    return $this->input(key);
  }  
    
  public function getAllQueries() : array | string | null 
  {
    return $this->query();
  }

  public function getQuery(string $key) : array | string | null
  {
    return $this->query($key);
  }  
}
```
- Create DTO by extend ApiRequest class. You can add getter and setter to inside DTO
```php
class UserDTO extends ApiRequest {
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required'
        ];
    }
    
    public function getEmail() : string {
      return $this->getFieldValue('email');
    }

    public function getPassword() : string {
      return $this->getFieldValue('password');
    }

    public function getName() : string {
      return $this->getFieldValue('name');
    }
}
```
- One important thing about this Form Request is. If we want some field to be unique inside database, we can use 'unique:' to check whether a value exists or not in the database. So we don't need to check if email is in controller or service
- This is how we use DTO inside controller
```php
public function login(LoginDTO $loginDTO)
{
    try {
        $result = $this->authService->login($loginDTO);
        return $this->successResponse($result, "Succes log in.");
    } catch (Exception $e) {
        throw $e;
    }
}

```
- Clean controller, no more form validation. As you can see, i use same datatype between controller and service
#### d. Service layer
- The service layer is used to encapsulate business logic and applications functionally
- It can also be reused for different cases and remove redundancy
- So services are made with functionality, not just focused on serving one controller
- A service can call another service.
- For example I have a service for authentication and another service for managing user profiles. The authentication service can use the Manage user profile service to get user profile data. Two of them can be used in the same controller. Maybe i will make a demo code later :D

#### e. Response layer
- I have make some trait for success response in /App/Traits/ApiResponse. It can be use by write ApiResponse in top of controller class. 
- For error response is use exception handle by laravel. I have use custom response when handler is recieve ValidationExecption. It will mapping error field and the message
```json
{
    "success": false,
    "message": "There was an error with the submission.",
    "error": {
        "error_validation": {
            "email": [
                "The email field is required."
            ],
            "password": [
                "The password field is required."
            ],
            "name": [
                "The name field is required."
            ]
        }
    }
}

```





## Source :

- <a href="https://cerwyn.medium.com/laravel-generalizing-api-response-error-handling-85646a195fea">Generalizing API Response & Error Handling</a>
- <a href="https://laracasts.com/discuss/channels/laravel/whats-your-opinion-on-the-service-repository-pattern">What's Your Opinion on the Service + Repository Pattern?</a>





## Notes :

### Last Progress
- creating dto
- create simple error handling for validtion error
- dto file structure
- implement auth
- continue to write readme
- fix seeder validation column

### TO DO
- error handling and log
- pagination(?)
- semantic commit
