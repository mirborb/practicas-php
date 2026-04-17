FROM php:8.2-apache

RUN a2enmod rewrite

COPY . /var/www/html/

RUN printf '#!/bin/sh\n\
set -e\n\
PORT="${PORT:-80}"\n\
echo "Listen ${PORT}" > /etc/apache2/ports.conf\n\
echo "<VirtualHost *:${PORT}>"                       > /etc/apache2/sites-available/000-default.conf\n\
echo "    DocumentRoot /var/www/html"               >> /etc/apache2/sites-available/000-default.conf\n\
echo "    DirectoryIndex index.php index.html"      >> /etc/apache2/sites-available/000-default.conf\n\
echo "    <Directory /var/www/html>"                >> /etc/apache2/sites-available/000-default.conf\n\
echo "        AllowOverride All"                    >> /etc/apache2/sites-available/000-default.conf\n\
echo "        Require all granted"                  >> /etc/apache2/sites-available/000-default.conf\n\
echo "    </Directory>"                             >> /etc/apache2/sites-available/000-default.conf\n\
echo "</VirtualHost>"                               >> /etc/apache2/sites-available/000-default.conf\n\
exec apache2-foreground\n' > /start.sh \
    && chmod +x /start.sh

CMD ["/bin/sh", "/start.sh"]
