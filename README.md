Laravel + React Udemy Course.

A twitter like app using Laravel + MySQL as Backend and ReactJS as Frontend
<<<<<<< HEAD

The SocketIO branch to see a version working with Socket.io and Laravel Echo Server

Requirements to run:
- Redis server
- Composer
- NPM

Steps:
- Download Repo
- composer require
- npm install
- Make sure you have the laravel echo server installed globally "npm install -g laravel-echo-server"
- Make sure you have the following configuration in your .env
    BROADCAST_DRIVER=redis
    QUEUE_DRIVER=redis
    REDIS_CLIENT=predis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    REDIS_PREFIX=

- Run your laravel echo server "laravel-echo-server start"
- Run your app "php artisan serve"
- Compile the javascript "npm run dev"
=======
Using Pusher to develop a real time app.

Can you found the course here:
https://www.udemy.com/course/laravel-react/
>>>>>>> 2471488f47d62e23d9b398ba66f5ea4d9c57a831
