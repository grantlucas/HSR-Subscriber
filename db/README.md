# DB Scripts

A collection of scripts used to managed live and local databases including the creation, updating and downloading of data.

All scripts reference site.conf which does not exist by default. When first setting up a site, create a symbolic link to the relevant configuration file.

For Example

    ln -s site.local.conf site.conf

## Variables

- SITE_NAME
  - Site name is used when creating the compressed sql files and for determining which sql file to target when completing a database refresh
  - Will be same in both live and local configurations
- DB_USER
  - The database username to be used with the site
- DB_PASS
  - The database password to be used with the site
- DB_NAME
  - The database name to be used with the site
- DB_HOST
  - The database host to be used with the site
  - For local development, this will almost always be **localhost**


##Scripts

### Create DB

When initially setting up a site locally or on a live server, running 

    ./create-db

will prompt you for the MySQL root password for the current machine before creating an empty database and user as defined in **site.conf**. 

**Note:** If a sql file already exists for this site, there is no need to run this script, refreshing the database will create the needed database and user.

### MySQL Dump

This script is most often used on the live site to pull down the latest copy of the database. No MySQL root password is needed to run this script. Running

    ./mysql-dump

will update the compressed sql file in this folder or create it if one does not already exist.

**Note:** It is a good idea to run this script before making any serious changes to a database on a live site. In the off chance shit hits the fan, you can beg for a database refresh on the live site hoping that not too much data was lost.

### Refresh DB

This script will mainly be used in local environments to update a database to match the latest dump from the live site. Running 

    ./refresh-db

will prompt for the MySQL root password of the machine in order to continue. On your local machine, ensure this password is easy to remember and type as you will be doing it a lot. This script removes the database in order to recreate it to match the live site exactly.

When setting up a site which already has an existing database dump on a new machine, there is no need to run create-db as refresh-db will create the needed database and user automatically. There will be a MySQL error at first as it tries to drop the existing database, but have no fear, this is expected behaviour.

**Note:** Never run this on a live server unless absolutely needed as **all** data since the last database dump will be lost.

### Refresh DB Shared

This refresh DB script is a paired down version of the original script but
without the user and database deletion/creation since that's managed by CPanel
on shared hosting.

This script prompts for a confirmation to continue and will update an existing
database with the latest conten.

    ./refresh-db-shared
