<p align="center"><img src="https://laravel.com/assets/img/components/logo-airlock.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/airlock"><img src="https://travis-ci.org/laravel/airlock.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/airlock"><img src="https://poser.pugx.org/laravel/airlock/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/airlock"><img src="https://poser.pugx.org/laravel/airlock/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/airlock"><img src="https://poser.pugx.org/laravel/airlock/license.svg" alt="License"></a>
</p>

## Introduction

Laravel Airlock provides a featherweight authentication system for SPAs and simple APIs.

## Installation

- Clone repository and install composer dependencies

    composer require laravel/airlock

- Setting database and run migration

    php artisan migrate

- Start application

    php artisan serve

- Implementation examples - follow the routes/api.php file

    - Generate Token & Set token abilities
    - Authenticate Application using Token
    - Get current loggedIn User
    - SPA authentication - get the code in resources/view/welcome.blade.php
    - Revoke tokens

## Official Documentation

https://github.com/laravel/airlock