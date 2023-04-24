#!/bin/bash
php /opt/lampp/htdocs/project/artisan generate:maxquantity
sleep 5
php /opt/lampp/htdocs/project/artisan db:seed --class=StocksOpeningSeeder


