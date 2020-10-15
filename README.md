## Setup Project

1. Clone data.

2. Create database on server.

3. Change database name, username, password in .env file on root.

4. Run these commands
	i. php artisan migrate
	ii. php artisan db:seed

5. import two tables data
	i. database/ImportData/countries.sql
	ii. database/ImportData/states.sql

6. Add cron job on server
	* * * * * root php7.2 /home/....root path..../artisan schedule:run