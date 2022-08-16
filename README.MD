# Litres API for Audio catalag

## Project structure:

Project includes three containers:

1. Api - Apache server with PHP7.4.
2. Cron - Cron server to update catalog dayly
3. Redis - Redis server to cache catalog data

## To start project:

1. Install `Docker Desktop` if not yet.
2. In comand line:
    ```
    cd /path/to/project/folder
    docker-compose up -d
    ```
3. Download Audio catalog:
    http://localhost/get_updates

## To test search in titles function:

In the browser, search for any string you want to find in titles, for example:
    http://localhost/api/v0/audio/titles/search/Второе нашествие

## Currently vailable APIs: 

    GET /api/v0/hello 
    GET /api/v0/audio/check
    GET /api/v0/audio/titles/{offset}/{length}
    GET /api/v0/audio/titles/search/{search pattern}
     

