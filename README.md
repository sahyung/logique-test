# Test PHP Developer
Test for PHP Developer Position

## Quickstart

Make sure to configure database on `.env`
```
$ git clone
$ cp .env.example .env
$ composer install
$ php artisan migrate --seed
$ php artisan serve
```

## Endpoints
All endpoints needs headers 
```
Accept: application/json
Content-Type: application/json
```
### Open
| Method      | Route | Body | Notes
| ----------- | ----- | ---- | ---
| POST  | api/auth/register | `{"email": "user@example.com", "password": "123456", "password_confirmation": "123456", "dob": "2020-12-24","gender": 0,"tnc": 1,"first_name": "Tarjono","last_name": "Tarjono","addresses": ["15 Gordon St, 3121 Cremorne, Australia"],"cc": {"type": "Visa","number": "4012888888881881","expiry": "02-21"},"membership": "Gold"}`
| POST  | api/auth/login | `{"email": "user@example.com", "password": "123456"}` | check `Authorization` on response's headers
