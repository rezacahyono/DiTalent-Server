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
+ **Code** : 
  + `200 OK`

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


## **Register**
+ **URL** :
  + `/api/register`

+ **Method** : 
  + `POST`

+ **Request Body** : 
  + `email` as `string`
  + `password` as `string`

+ **Response**
+ **Code** : 
  + `200 OK`

  ```json
  {
    "message": "User created"
  }
  ```

