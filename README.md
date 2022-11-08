# DiTalent Service

DiTalent service is restfull api for [DiTalent]('https://github.com/rezacahyono/DiTalentApp') application. 
This service uses laravel version 9.38.0.

## **Login**
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
          "id": 1,
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


## **Register**
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
---


## Testing
+ Login test

  ![login test](/screenshot/test_login.jpg)
  

+ Register test

  ![login test](/screenshot/test_register.jpg)

