MediaWiki
=========
This is a distribution of MediaWiki with customizations for LiTHe Blås. This includes…

* OpenID Connect
* Fully private access model
* Fancy logos
* Fancy URLs

## Build & installation
```
$ sudo docker buildx build . --tag ghcr.io/litheblas/mediawiki:latest

$ sudo docker compose -f docker-compose.ci.yml up
```

Currently, MediaWikis install script does not automatically update the database models. Once the containers are up and running a workaround needs to run:
```
$ sudo docker exec -it <MEDIAWIKI_APP> cat maintenance/tables-generated.sql | sudo docker exec -i <MEDIAWIKI_DATABASE> mariadb -D <DATABASE_NAME> -u <DATABASE_USER> --password=<DATABASE_PASSWORD>

$ sudo docker exec -it <MEDIAWIKI_APP> php82 maintenance/run.php update
```
which essentially installs and updates the schema in the database.
