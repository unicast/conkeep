# conkeep

* [Website](http://conkeep.org/)

## Description

conkeep is a web-based manager of various configuration files (iptables, Cisco, etc. ). Provides version control, per-line comments and e-mail notifications.

## Requirements

* PHP >= 5.2
* MySQL >= 5.0

## Installation

    $ git clone https://github.com/unicast/conkeep.git
    $ cd conkeep; git submodule update --init
    $ chmod 777 application/cache application/logs
    $ cp application/config/database_example.php application/config/database.php
    $ mysql -u root -p < sql_schema/database_create.sql
    $ mysql conkeep -u root -p < sql_schema/conkeep.sql
    $ cd kohana; git submodule update --init

## Usage

You can manage Your configs via web-interface (e.g. http://conkeep.expample.com)
For auto-update configs You can use script conkeep/scripts/conkeep_update.sh, e.g.:

    $ iptables-save | sed "/^[:#]\.*/d" | /var/www/conkeep/scripts/conkeep_update.sh http://conkeep.example.com/config/update/3 -

