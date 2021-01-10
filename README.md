# Book Titles and Authors CRUD Application

## [Demo](https://yaraku.herokuapp.com)
<img width="100%" contain src="https://github.com/harshit2996/yaraku-assignment/blob/master/Yaraku.gif">

## Functionalities

1. Add a Book to the List
2. Delete a Book from the List
3. Edit Book - Author Name & Book Title
4. Sort by Title or Author
5. Search by Title or Author
6. Download the the following in CSV and XML
    - A list with Title and Author
    - A list with only Titles
    - A list with only Authors
7. Light and Dark Mode

## Installation Guide
### To run the Application on Local Machine / Local Server / localhost 
1. Clone the Repository or Download as Zip and Extract it in a Directory
2. Run ```composer install``` to install Composer dependencies
3. Run ```npm install && npm run dev``` to install Node Modules 
4. Change/Rename the ```.env.example``` to ```.env```
5. Setup a MySQL database with username and password
6. Run ```php artisan key:generate --show``` and copy the 'value' from APP_KEY=value displayed in the result in the console.
7. Configure the following environment variables in the ```.env``` file
    - APP_KEY='value'
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=YOUR_DATABASE_NAME
    - DB_USERNAME=YOUR_DATABASE_USERNAME
    - DB_PASSWORD=YOUR_DATABASE_PASSWORD
8. Run ```php artisan migrate``` to migrate the table to the database
9. Run ```php artisan db:seed``` to seed fake/random data into the database using the Factory Class
10. Run ```php artisan serve``` to Start the Server 

### To Deploy the Application on Heroku
Follow the Guide here - [Deployment Guide](https://dev.to/eduvin/how-to-deploy-a-laravel-vue-app-to-heroku-4kmg)

## Tech Stack Used
Here is the list of technologies used
  - Laravel
  - Vue.JS
  - Vuetify
  - MySQL
  - Heroku