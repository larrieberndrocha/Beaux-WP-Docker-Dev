# Beaux WordPress Docker Development Environment
A Docker Dev Environment with WordPress Apache MariaDB PHP and fake SSL.

# Setup Your Environment by Updating the .env file:
IP=127.0.0.1 (IP address of the site. 127.0.0.1 for localhost IP)

# Add a hosts file entry for your site url and generate SSL certificates:
Open Windows Powershell or Terminal. 

Go to the project folder.

Run these commands:

    cd cli

    bash add-hosts.sh

    bash create-cert.sh

Or on windows, you can just go to the cli directory and open create-cert.sh and add-hosts.sh

Note: 

mkcert required for making fake SSL certificates.

To check if you have an mkcert, run this command: mkcert --version

If you do not have, you can install via:

  - Chocolatey: choco install mkcert
  - HomeBrew: brew install mkcert

Then go to the Environment Variable and then add this on System Variable > Path: "C:\ProgramData\chocolatey\bin\"


# Build the WordPress Apache PHP Image from Dockerfile:
Edit Dockerfile.

    FROM wordpress:php7.4
    
    RUN a2enmod ssl && a2enmod rewrite
    RUN mkdir -p /etc/apache2/ssl
    RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

    COPY ./certs/*.pem /etc/apache2/ssl/
    COPY ./config/wordpress-php-apache/000-default.conf /etc/apache2/sites-available/000-default.conf

    EXPOSE 80
    EXPOSE 443

Open Windows Powershell or Terminal. Go to the project/app folder. Run this command:

    docker image build -t wordpress-php-apache .

The generated image already has Apache, PHP and WordPress setup.


# Docker Commands via Powershell or Terminal:

Open Windows Powershell or Terminal. 

Go to the project folder.

## Start Project containers:

    docker-compose up
    
    docker-compose up --remove-orphans

## Stop Project containers:
    
    docker-compose stop

## Delete Project containers:

    docker-compose down


# To check running containers with port :80:

    netstat -nlp | grep :80


# Important Directories/Files:

## MySQL:

    ./mysql/lib/:/var/lib/mysql
    ./mysql/etc/:/etc/mysql

## Wordpress:Apache:
    
    ./html:/var/www/html
    ./config/000-default.conf:/etc/apache2/sites-available/000-default.conf

## SSL:
    
    ./certs:/etc/apache2/ssl/

# Important URLs:

https://localhost/ - Site URL
https://localhost:8080 -- PHPMySQLADMIN
