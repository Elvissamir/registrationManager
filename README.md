# SERVM
Servm created as part of the community service program and was developed as a project proposal for the “Manuel Antonio Carreño” School.

The main features are: 

- Management system of students, teachers, subjects, and courses.
- Developed the back end using the TDD process, and as a result, created 231 tests. 

You can check the live demo deployed to heroku: 
(Keep in mind that with heroku's free tier if the app receives no traffic in a 30-minute period, it will sleep, so please be patient while it "wakes up" ;) .)
https://servm.herokuapp.com/login

## Running using Docker for development: 
1 - Clone repository

2 - Install npm dependencies: 
```sh
sudo npm i
```
3 - Build and start docker containers: 
```
sudo docker-compose up --build
```
4 - In a separate console tab run the migrations with seed data: 
```
sudo docker-compose run --rm app php artisan migrate --seed
```
## Running locally 
1 - Clone repository

2 - Install npm dependencies:
```sh 
sudo npm i
```
3 - Run migrations with seed data:
```sh
sudo docker-compose run --rm app php artisan migrate --seed
```
4 - Use your favorite development environment: laragon, nginx server or xampp.