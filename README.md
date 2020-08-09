# voluntary-assistance-planning

This is my main repo for my bachelor thesis in Business Informatics

## about this project

 The project itself is based on an need in the nonprofit association I'm in since 2011.
    The planning of medical services is one of the jobs that is done from a group of four people at this association.
    Some time it happens that some information has been forgotten to tell to each other so that this information got lost.
    This web-based application should help on this and also make it possible to spread information towards everybody.
    Some work is still ahead to make this application good for most needs.
    At the moment just basic information can be written to operations (such as medical services, german: Sanitätsdienst)
    but volunteers can create accounts and get access to this information and they can declare their commitment for
    an operation they like to commit theirself to.   
    
    
## important folders that are not found in vokuro!

> /_phalcon
 
 This folder contains the devtools-template - used in devtools 4.0.3 in windows
 
> /db/MySQLWorkbench

This folder contains all database information

if migration does not do, take a look there and do what needs to be done ;)

please always comment on changes in "forward-engineer-export.sql" 
    
## basic first steps to get this run

environment: xampp with php 7.4 and phalcon ready instealled; phalcon devtools also ready installed

!!! important: take the templates for creating new scaffolding - look for details in 

> /_phalcon/devtools-templates/scaffold/no-forms/...  

To make this work there are not that much steps for setup

> composer install

setup database based on 

> ./vendor/bin/phinx migrate

Check the config settings for your database in /config/config4cli.php 

run migration through the webtools of phalcon: http://localhost/webtools.php
-> take V0.3.20200809-final; its the last time migration has been run 

rename your .env.example to .env and fill it with correct data

further reading: https://github.com/phalcon/vokuro  

also nice: https://docs.phalcon.io/4.0/en/devtools


## about

This project is based on vokuro an sample project of phalcon and programmed by Marco Hetzel, contact on github: https://github.com/delphianer


## license

see License-file for this project
for license of vokuro see LICENSE-phalcon  

