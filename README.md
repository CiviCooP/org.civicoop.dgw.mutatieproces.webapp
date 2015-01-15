Mutatieproces
========================

This application is a so called webapp, designed for use with mobile and tablet devices.

Functionality
-------------

This application shows a form in which an inspector can inspect a house and put remarks in the report. Such as the renter has to take off the wallpaper in a specific room. Or the new renter will use the carpet of the old renter. Or the housing organisation has to provide a new kitchen, etc...
All those lines are put in a report and that is sent back to CiviCRM in which the case of cancelling the renting contract is processed. 

So this application has nu use on its own. 

Installation and configuration
-----------------------------

To install the application follow the instructions below

1. `git clone github.com/jaapjansma/org.civicoop.dgw.mutatieproces.webapp`
2. Create a database
3. `php composer.phar install`
4. Fill in the database details and the details of your civicrm installation in **app/config/parameters.yml**
5. `php app/console doctrine:migrations:migrate`
6. `php app/console assetic:dump -e prod`
7. `php app/console cache:clear -e prod`
8. Your application is now ready for use

Requirements
------------

- SSH access
- PHP 5.3.3 or greater
- PHP-Intl extension enabled (intl with Icu 4+)
- ctype
- json
- php-xml
- php-pdo
- A working civicrm installtion with the Mutatieproces extension (https://github.com/CiviCooP/org.civicoop.dgw.mutatieproces)
