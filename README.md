# Esute-Confam-Ltd-Co-operative

Esute-Confam-Ltd-Co-operative REST API
This project is for weekly copreative contribution

## Installation
To use it just clone the repo and composer install.
Laravel Passport is required to run this project so you need to install it and configure it
Set the database connection
run the migration command to migrate the database
You can use Google Chrome addin call [Postman] (getpostman.com) to run the Api Test.


## Usage
We need to pass this header in postman when testing:
```laravel
'headers' => [
 'Accept' => 'application/json',
 'Authorization' => 'Bearer '.$accessToken, ]

Check the api.php in the route folder to get the route links as below:

```laravel
Route::post('register', 'Api\UserController@register'); 
Route::post('login', 'Api\UserController@login');

Route::middleware('auth:api')->group( function () { 
      Route::resource('groups', 'API\GroupController'); 
      Route::post('listgroups', 'Api\UserController@listgroup'); 
      Route::post('allgroups', 'Api\UserController@listallgroup'); 
      Route::resource('memberdeposits', 'Api\MemberDepositController'); 
      Route::post('addusergroups', 'Api\UserController@addusertogroup');

});
