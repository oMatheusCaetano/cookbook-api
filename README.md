# Cookbook

## 🤔 About

Technical project for [Open Datacenter](https://opendatacenter.com.br/) full stack developer role.

This project uses [Docker](https://www.docker.com/) to run the application based on containers.

<br /><br />

### Start up the docker containers
```
docker compose up
```

<br /><br />


What will happen when you run the command above:
- Build the image for api (cookbook-api)
- Start the docker container for database (cookbook-db)
- Start the docker container for API (cookbook-api)
- Install Laravel dependencies
- Run the migrations
- Run the database seeds to populate the database
- Put the apache server up and running

<br /><br />

There will be a user ready to use:
```
E-mail    => usuarioteste@email.com
Password  => 123456789
```

<br /><br />

### 💻 Hosts
Once you followed the steps above you can access this url to reach the `API` directly

[http://localhost:7776](http://localhost:7776)
