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

To initialize the Wiki, run the following command:

```php
$ docker exec -it <MEDIAWIKI_APP> php85 maintenance/run.php installPreConfigured
```

## Upgrading an existing Wiki

Run the command

```php
$ docker exec -it <MEDIAWIKI_APP> php85 maintenance/run.php update
```
