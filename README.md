## How to run project

- composer install
- create "faraz" database
- php artisan migrate
- php artisan migrate:fresh --seed
- php artisan queue:work
- php artisan test
- php artisan serve
- hotels : http://127.0.0.1:8000/api/hotels (GET)
- rooms: http://127.0.0.1:8000/api/hotels/1/rooms (GET)
- reserve: http://127.0.0.1:8000/api/reserve (POST)
### reserve sample data:
```json
{
  "room_id" : 1,
  "amount" :2,
  "start_date" : "2025-11-23",
  "end_date" : "2025-11-25"
}
```

## Requirements
- php 8.3.9
- mariaDb

## ToDo
- Payment Repository
- Add is_final_reserve field to reserve table and handle conditions and approach for prevent make is active by false in job queue and other sections

## project description
- DDD pattern for business requirements consideration and large scale project
- Feature Test Also added

## Postman file
Postman file also added on this project root

# Thanks for checking this project
