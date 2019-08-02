# Patient Monitoring System API Documentation

---

# Table of Content

    - Getting Setup
    - Consuming Endpoints
    - Todos

## Getting Setup

    - Setting up your local environment
    - Clone/Download Repository
    - Install Dependencies
    - Run Server

**Setting up your local environment**

    Make sure you have [composer](https://getcomposer.org/download)  and [node](https://nodejs.org/en/download/) installed globally on your local machine

**Installing Dependencies**
Clone this repository to your local work-space using the following command

    git clone https://github.com/algorithm-sam/lmart-api.git

**Run Server**

Having installed the dependencies, the next logical line of action would be to run the server.
Hey before your hands get all itchy to run the server don’t forget to change the setup in the .env file.

**Migrate database**

Run the following command to migrate your database.

    php artisan migrate

After Migrating your database there are a little bit of data i created to ease the workflow, it contains roles and demo accounts for admin, doctors, patient e.t.c.
Just run the seeders using the following command and you should be all setup.
to run the seeders use the following command

    php artisan db:seed

Have your server listen for request using the following command

    php -S localhost:8000 -t public

Boom You are good to go….

## Consuming Endpoints

    - Authentication Endpoint
    - General Endpoints
    - Admin Endpoints
    - Doctors Endpoint
    - Patients Endpoint
    - Relatives Endpoint
