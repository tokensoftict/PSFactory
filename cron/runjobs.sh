#!/bin/bash
php /opt/lampp/htdocs/project/artisan queue:work --sansdaemon --tries=3 --timeout=0
