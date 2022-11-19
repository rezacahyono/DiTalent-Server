# **DiTalent Service**


DiTalent service is restfull api for [DiTalent]('https://github.com/rezacahyono/DiTalentApp') application. 
This service uses laravel version 9.38.0.

# Instalation

1. Cloning this repository
2. Install dependency using composer 
    ```cmd
      composer install
    ```
3. Turn on your DBMS, using XAMPP
4. migration database like 
    ```cmd
      php artisan migrate:fresh
    ```
5. Configuration file .env
6. Running server
    ```cmd
      php artisan serve
    ```
7. If you want to run the test, use the following command :
    ```cmd
      php artisan test
    ```
# Endpoint
### **Login**
+ **URL** :
  + `/api/login`

+ **Method** : 
  + `POST`

+ **Request Body** : 
  + `email` as `string`
  + `password` as `string`

+ **Response**
  ```json
    {
      "data": {
          "id": "e8f373e1-ee8b-4f14-acfe-e696f2efcf2b",
          "name": "Dody Mulyanto",
          "email": "Dody Mulyanto@gmail.com",
          "role": "TALENT",
          "no_phone": "082188391021",
          "created_at": "2022-11-05T16:57:41.000000Z",
          "updated_at": "2022-11-05T16:57:41.000000Z"
      },
      "access_token": "1|h4khIZijBYTUsjHtttVQO82hyjF22TuW32RCuEYx"
    }
  ```
+ **Code** : 
  + `200 OK`


### **Register**
+ **URL** :
  + `/api/register`

+ **Method** : 
  + `POST`

+ **Request Body** : 
  + `name` as `string`
  + `email` as `string`
  + `role` as `string`
  + `no_phone` as `string`
  + `password` as `string`

+ **Response**
  ```json
    {
      "message": "User created"
    }
    ```
+ **Code** : 
  + `200 OK`



## Testing
+ Login test

  :white_check_mark: `Success login`

  :white_check_mark: `Login user with wrong password`

  :white_check_mark: `Required email login`
  
  :white_check_mark: `Required password login`

+ Register test

  :white_check_mark: `Required email registration`

  :white_check_mark: `Required name registration`

  :white_check_mark: `Required role registration`

  :white_check_mark: `Required no phone registration`

  :white_check_mark: `Required password registration`

  :white_check_mark: `Success registration`

