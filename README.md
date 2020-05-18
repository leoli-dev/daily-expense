# leoli-dev/daily-expense

This is a daily expense record system based on Symfony.

## DEVELOPMENT ENVIRONMENT

This project is using docker environment for development.

- nginx
- php: `7.4.6`
- mariaDB

## INSTALLATION

### Docker

1. Initial `docker-compose.yml` and `.env` files:
    
    ```bash
    make setup
    ```

2. Build dockers:

    ```bash
   docker-compose build
    ```
   
3. Start dockers:

    ```bash
    docker-compose up -d 
    ```

### Symfony & Webpack encore

Install php dependencies and frontend dependencies, then generate asset files:

```bash
docker-compose exec php make init
```

### Database

Initial database tables & load basic data fixtures:

```bash
docker-compose exec php make init_db
```

## DEVELOPMENT

### Dev host

The default host comes out from the box is `http://daily-expense.localhost/`.

There is no need to edit your `/etc/hosts` file, and the reason is [here](https://ma.ttias.be/chrome-force-dev-domains-https-via-preloaded-hsts/).

### Webpack Encore

Generate asset files continuously:

```bash
docker-compose exec engine yarn watch
```

### Database backup & restore

- Backup database structure with data:

    ```bash
    docker-compose exec php bin/console backup-manager:backup daily_expense local -c gzip
    ```

    When the command finish, you can file a backup file in the path: `./data/db_backup/{DATE}_{TIME}.gz`
    
- Restore the database from backup file:

    ```bash
    docker-compose exec php bin/console backup-manager:restore daily_expense local {BACKUP_FILE_PATH} -c gzip
    ```
