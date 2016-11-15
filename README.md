# darkstar-afterhours

This project was created in order to emulate what [FFXIAH](http://www.ffxiah.com/) provides for Retail FFXI yet for the Darkstar FFXI Server Emulator. While this project could be adapted to work with any private server, it has been specifically developed with the AfterHours Private Server in mind.  

:godmode: [Live Demo](https://ffxi.kyau.net:4444/)  
:inbox_tray: [Installation](#installation)  
:memo: [TODO](#todo)

### Installation

darkstar-afterhours recommends [PHP](https://php.net/) v7+ to run.  
darkstar-afterhours recommends [NGINX](https://www.nginx.com/) v1.11+ to run.

Download and extract the [latest release](https://github.com/kyau/darkstar-afterhours/archive/master.zip).

Make sure NGINX and PHP are already setup and running, then add the following rewrite rules to your NGINX config. (If you want to use different web server software just convert these rewrite and location deny lines into the appropriate syntax for your web server.)

```nginx
rewrite ^/(ah|download|help|recipes|shops|users)$ /$1.php last;
rewrite ^/(ah|download|help|recipes|shops|users)/$ /$1.php last;
rewrite ^/(ah|char|item|shops)/([^\?]*)$ /$1.php?id=$2 last;
rewrite ^/recipes/([^\?]*)/([^\?]*)$ /recipes.php?cat=$1&rank=$2 last;
location = /include/config.inc { deny all; }
```

You will then need to create the extra `item_info` table in the darkstar database.

```sql
USE dspdb;
CREATE TABLE IF NOT EXISTS `item_info` (
  `itemid` int(6) unsigned NOT NULL,
  `realname` varchar(128) DEFAULT NULL,
  `sortname` varchar(128) NOT NULL,
  `description` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

Next you will need to edit the configuration file with your database login information.

```sh
$ cp include/config.inc.default include/config.inc
$ vi include/config.inc
```

Utilize the script found in the `scripts` folder to import the FFXIAH item xml into your database.  
NOTE: This script will utilize the `config.inc` file you setup in the previous step.

```sh
$ cd scripts
$ wget http://static.ffxiah.com/files/ffxiah_items.tgz
$ tar xf ffxiah_items.tgz
$ php ffxiah_import_xml.php
```

After this you would probably want to edit the `help.php` and `download.php` files to customize them to your liking. The main site logo text is in `include/html.inc`. In this same file is the <base> tag within the header, this needs to be changed to the location you are hosting your version of the app.

### TODO

- [x] User Online Status / Full User List
- [x] Character Profiles
- [x] Implement Mission Status on Character Profiles
- [ ] Global Bazaar Page
- [x] Bazaar's on Character Profiles
- [x] Bazaar's on Item Pages
- [x] Properly Color Crafts on Character Profiles when Capped
- [x] Auction House Category Listings
- [x] Auction House Item Information
- [x] Item Tooltips
- [x] Armor/Weapon Tooltips -> Darkstar Database
- [x] Descriptive Items Tooltip -> FFXIAH XML
- [ ] Add Latent Effects on Item Tooltips
- [ ] Add On Use Effects on Item Tooltips
- [ ] Add Items/Key Items to Auto-Translator
- [x] Implement Item Search
- [ ] Add Filters to Item Search
- [x] Full Recipe Listings
- [x] Recipes on Item Pages
- [x] Remaster Ingame Icons
- [x] Help/FAQ Section
- [x] Download Section
