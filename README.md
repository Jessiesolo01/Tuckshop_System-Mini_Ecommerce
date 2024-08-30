<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About The Project
Users can register by creating an account, they can login as well. They can add products to cart and also place orders afterwards. The cost would be deducted from their wallet balance. They can also update their wallet balance by uploading a valid receipt to the system which will be reviewed and confirmed by the admin. They can place as many orders at a time and download each order invoice specified by their ID. If an admin cancels an order, they are refunded back in their wallet, and sent emails accordingly.

Admins can retrieve products, add products to the system, update and delete products as well. They can retrieve users and edit users info, and also delete a user. They can retrieve orders, cancel and confirm delivery. They can also retrieve receipts, cancel and  confirm as well. Some of these functionalities allow sending emails automatically after such action as cancelling or confirming to inform the user of what next to do. 

Also I implemented a search functionality to allow search for an order, receipt, user or item(product), using some specific field values.

