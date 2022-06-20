## Project Setup Steps

- Install PHP with version 7.2*
- Install Composer using this link https://getcomposer.org/download/
- Create a new folder and clone the project using below steps
- Clone the Project by using git
	- git clone https://github.com/Mallikarjundemogreeniitproject/backend.git
	- switch to "master" branch using command as "git checkout master"
	- Once the Project is clone then execute the command "composer install" for installing dependency packages for the project
	- rename the file .env.example with .env in project folder (I have defined the mysql details )
	- Run the command "php artisan key:generate" to generate the new key for project
	- Make sure config is refreshed using command : php artisan config:cache
	- You should be able to run a database migrate on your new test database, like so php artisan migrate:refresh --database=mysql and php artisan migrate:refresh --database=mysql_test
	- Run the command "php artisan serve" in command prompt for executing the project
	- Run the command "php artisan test" for unit and feature test
