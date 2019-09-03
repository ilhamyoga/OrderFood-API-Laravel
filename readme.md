<h1 align="center">RESTful OrderFood App</h1>
<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.
Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Requirements
1. Composer
2. Web Server (xampp)
3. Postman
4. Code Editor

## How to Run the App ?
1. Clone or download backend repository
2. Open CMD or Terminal, enter to the app directory and Type `composer install`
3. Copy file <b>.env.example</b>, paste and save it in a new file with the name <b>.env</b>
4. Create database and setting connection database in file <b>.env</b>
5. Type in the terminal `php artisan key:generate` to generate key app in your <b>.env</b>
6. Type in the terminal `php artisan migrate:resfresh`. If successful several tables will appear in the database
7. Then to run project type `php artisan serve` in your terminal
8. After this, Open POSTMAN to Choose HTTP Method and enter request url.(ex. localhost:3000/notes)

## End Point List
### 1. GET
* `/restaurant` -- (get all data restaurant) 
* `/restaurant?id=restaurant_id` -- (get data restaurant by id) 
* `/food` -- (get all data food) 
* `/food/:restaurant_id` -- (get data food by id restaurant)
* `/food?id=food_id` -- (get data food by id)
* `/order` -- (get all data order)
* `/order?id=order_id` -- (get data order by id)
* `/order/:restaurant_id` -- (get data order by id restaurant)
* `/cart/:order_id` -- (get data order list by id order)
* `/transaction/:restaurant_id` -- (get data transaction by id restaurant)
### 2. POST
* `/restaurant` -- (add new restaurant data)
* `/food` -- (add new food data)
* `/order` -- (add new order data)
* `/cart` -- (add orders to the order list data)
* `/transaction` -- (add new transaction data)
### 3. PUT
* `/restaurant/:id` -- (update data restaurant by id)
* `/food/:id` -- (update data food by id)
* `/order/:id` -- (update data order by id)
* `/order/done/:id` -- (change status order by id)
* `/cart/:id` -- (update data order list by id)
### 4. DELETE
* `/restaurant/:id` -- (delete data restaurant by id)
* `/food/:id` -- (delete data food by id)
* `/order/:id` -- (delete data order by id)
* `/cart/:id` -- (delete data order list by id)
* `/transaction/:id` -- (delete data transaction by id)

##FLOW TRANSACTION
1. The user searches for a list of foods from a particular restaurant
2. The user creates a list of orders and the date they were taken
3. The user creates a list of orders in one restaurant
4. The vendor sees the recorded order data from the user
5. Users take orders as scheduled and Users make transactions based on order data
6. Vendors look at transaction and order recording data
7. The vendor changes the order status data that the order success
