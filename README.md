![Product Api](https://github.com/Remonhasan/product-api-laravel-sanctum-spa/blob/main/api-validation.png)

| :bell: Boxy api from Resvona |
|:--------------------|
|This project based on a product api with auth using laravel 8 Sanctum with Postman .|
|Project will get deployed to Heroku,  followed with awake request, to awake server's dyno'|
|will add vuejs to consume this api|

```
http://localhost:8000/api/login
POST
name:
password:
```

```
http://localhost:8000/api/user/{uuid}
GET
uuid:
```

```
http://localhost:8000/api/logout
POST
with bearer api token
```

```
http://localhost:8000/api/awake
GET
with bearer api token
```

```
http://localhost:8000/api/edit
GET
with bearer api token
```

```
http://localhost:8000/api/updateImage
POST
with bearer api token
image:
```

```
http://localhost:8000/api/updateBio
POST
with bearer api token
bio:
```

```
http://localhost:8000/api/updateName
POST
with bearer api token
nickName:
```

```
http://localhost:8000/api/addSocial
POST
with bearer api token
platform:
link:
```

```
http://localhost:8000/api/editSocial
POST
with bearer api token
id:
link:
```

```
http://localhost:8000/api/deleteSocial
POST
with bearer api token
id:
```
