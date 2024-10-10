# Laravel Vue Project

This project is built using Laravel for the backend and Vue.js for the frontend. This document will guide you on how to set up and run the project locally.

## Requirements

Make sure you have the following installed:

- [PHP >= 7.4.33](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js >= 16.x](https://nodejs.org/)
- [NPM](https://www.npmjs.com/)
- [SQL Server](https://www.microsoft.com/en-us/sql-server) or [SQL Server Express](https://www.microsoft.com/en-us/sql-server/sql-server-downloads)

## Project Setup

Project Setup 
- composer install (Command)
- node install (Command)
- php artisan key:generate (Command)
- SQl server Schema Create in SQL Server (Given Schema database.sql in Project)
- Make Database Connection in .env file

## Project From Local View
- http://localhost/LarvP/covid-vaccine-registration (For User Registration)
- http://localhost/LarvP/covid-vaccine-register-user-search (For User Search)


## Project Live View
- http://202.53.171.11/LarvP/covid-vaccine-registration (For User Registration)
- http://202.53.171.11/LarvP/covid-vaccine-register-user-search (For User Search)

## Demo Data
- NID number- 120120 (For Searching User Data, iT has been registered) 
- NID will be unique so, it can be checked in registration page to confirm it's existence
- NID Number - 89557563 (For Not Scheduled User)

## How Optimized Search Query
- indexing (NID) column
- Set Id and NID column as a composite primary key
- Used DB Raw while searching a customer to overcome eloquent speed issue

## Scheduling Email System
- php artisan email:send (Command For Email System, Already scheduled  for every Day  at 8 PM)
- At present Mail goes in Mail trap (For testing purpose)

## Real Time Notification and SMS system
- Real Time Notification implemented (Channel Name : UserCreate, Event Name : NotificationEvent)

## For notification system used technology
- Laravel Echo
- Pusher Js 2.234

## Need Change into Code if SMS and notification System Integrates
- SSL 
- SMS Credential
- Mail Credential

### 1. Clone the repository

```bash
git https://github.com/zahidhasan566/LarvP.git
cd project
