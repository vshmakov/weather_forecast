### Weather forecast
#### Requirements
1. [Git 2.16.2 and higher](https://git-scm.com/downloads)
2. [Docker 17.03 and higher](https://www.docker.com/community-edition)
3. [Docker Compose](https://docs.docker.com/compose/)

#### Installation
- `docker-compose up -d`
- `docker-compose exec php bash -c 'composer install'`
- `docker-compose exec php bash -c 'bin/console doctrine:migrations:migrate -n'`
- Open http://localhost:8080

#### Task

Please create a simple Laravel/Symfony/(Any other framework you like) site where a user will be able to provide his city and country via form and after submission system will display current weather forecast.

Forecast temperature should be calculated as an average based on different APIs, at least 2 different data sources (ex. API1 will return temperature 25, API2 will return temperature 27 so the result should be 25+27/2 ie. 26)

Feel free to use https://openweathermap.org/API and any other API you like.

Few notes:
- please implement proper error handling
- results should be stored in the database
- a simple caching mechanism should be added
- ability to easily add new data sources (how to register them, interfaces etc.)
- clean data separation
- nice to have - latest PHP mechanisms (ex. traits)
