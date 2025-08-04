# ![domain-swapper](pages/public/assets/img/logo.png) Domain-Swapper

# The Domain Swapper Plugin lets you use multiple domain names.

## Developer Requirment Setup
We apologize but you need to do a one time setup to make it works, as we need to to tell your operation system where to find your testing domains. To do this configure your operation host file like
```
127.0.0.1 www.app.local ww1.app.local  ww2.app.local  ww3.app.local www.app.local foo.local phpmyadmin.local
```


## Install
### Clone from github
```
git clone https://github.com/myridia/domain-swapper.git
```
### Start the Web enviroment  via docker
```
cd domain-swapper/dockers
docker-compose up
```
### Check the PHP instation 
```
 https://ww1.app.local/info.php
```
### First Wordpress Setup
* After the Dockers is running, visit with your browser the address http://127.0.0.1

### Wordpress login
* user: test
* pass: test


### Info
Contributors: Myridia
Tags: wordpress, changer, host switcher, dynamic host, multiplehosts, multihost
Requires PHP: 5.2.4
Requires at least: 3.0.1
Tested up to: 6.7.1
Stable tag: 1.0.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WPMultiHost is a plugin which helps to access same WordPress site from different domains.

## Description 

plugin which helps you to access 1 WordPress site from Multiple domains.



## Whom it will help?

- This for developers sharing to help them share local site on a domain.
- It will allow WordPress site to be accessed from multiple domiain consecutively.
- Will help to use it with NGROK and any other tunnel domains.


## Screenshots 



## Installation 

1. Upload the plugin and activate it (alternatively, install through the WP admin console)
2. Go into Tools, Select sub-menu "host-swapper"
3. Add Allow Host and save setting.
4. Now you are good to go.


# Dockers Space to test and develop this Plugins
A WordPress plugin is integrated into WordPress, so the best way to work with it, is to create a minimal WordPress place where
we can work it.
The Dockers where will simulate the server, so we can access the site locally without computer.

See https://github.com/myridia/hello_haproxy_docker/tree/main for install the certificates into your browser to be able to access the local test  https domains

 
## After you run the docker-compose you can access to
```
  docker-compose up
```

*  Default Wordpress http://127.0.0.1:8080
*  phpmyadmin http://127.0.0.1:81
*  domain1  https://ww1.app.local
*  domain2  https://ww2.app.local
*  domain3  https://ww3.app.local
*  domain4  https://foo.local


## Enter wp cli and make the wordpress installation up2date 
```
docker exec -it wpcli bash
wp core verify-checksums --allow-root
wp core update --allow-root
wp plugin update --all --allow-root
wp core update-db --allow-root
wp core download --force --allow-root
wp plugin activate woocommerce  --allow-root
wp theme activate starter-shop  --allow-root
wp plugin install wordpress-importer --activate --allow-root
wp import wp-content/plugins/woocommerce/sample-data/sample_products.xml --authors=skip --quiet --allow-root
```

## Generate Language Files
```
wp i18n make-pot . languages/domain_swapper.pot --allow-root
```

## Constants
```
WPDS_NAME
WPDS_DIR
WPDS_BASE
WPDS_URL
WPDS_URI
WPDS_PATH
WPDS_SLUG
WPDS_BASENAME
WPDS_VERSION
WPDS_TEXT
WPDS_PREFIX
WPDS_SETTINGS


```
## Inpired by  WPMultiHost https://youtu.be/zEV2GVB-BcU


## Uploaded on
* https://wordpress.org/plugins/developers/add/
