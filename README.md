## Laravel 8 Dev Test

## Setup
- Run composer install on your cmd or terminal
- Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run php artisan key:generate
- Run php artisan migrate:fresh --seed
- Run php artisan serve

## Laravel Features Used
- Form Request Validation
- Migrations & Seeders
- Auth Modification
- Route Prefix, Group, Middleware
- Eloquent ORM
- Resource Controller
- Repository/Service Class
- Route Model Binding
- Model Trait Modification
- Payload Encryption
- Const Values using Enums
- Custom Logger channel

 ## Exported Postman Collection 
 - Please download the exported postman json collection below.
 - https://drive.google.com/file/d/1PzQiufxbzkRdb2L_qFX4paGxiRaaSyM1/view?usp=sharing
 - Process instruction please see image below
 - https://drive.google.com/file/d/1fVYdy9QAx45wyx1YmT_5XpWXyjntp0h3/view?usp=sharing
 

 ## Using APIs in Postman
 - If you see `message: unauthenticated`. Please click 2nd step to refresh client token, if still not working go back to 1st step.
 - The tokens are already set upon click. Please see **Test** tab to verify.

 ## Logger
 - I made new channel for logs to show it is working. Please see */storage/logs/kumu_logs*.

 ## Redis Cache
 - I used Redis facade not the Cache facade because my configuration does not recognize it should use redis.
 - Expiration is default set 320sec(5mins), I made an env config to make it 120sec(2mins) in case of changing it.
 
 ## Github API
 - I used my own client id/secret to increase rate limit call since I am using unauthenticated way of calling api.
 - Client id/secret are in .env.example. Please verify/change if needed.

 ## Challenge Test
 - Please see *Challenge1.php*.