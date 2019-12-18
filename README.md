SKISPEED Readme

Welcome to the community website project of ski style figures.
Steps:
1 - Clone the repository
2 - Edit the file approx. to add your database settings.
3 - Enter the command "composer install" to access the commands.
4 - Import the file "insnow.sql" into your database.
5 - Then apply the commands: php bin / console doctrine: database: create followed by
      php bin / console doctrine: migrations: migrate
6 - To load the fixtures: php bin / console doctrine: fixtures: load
7 - Launch the server, by: php bin / console server: run to go to "localhost: 8000"

Good visit!
