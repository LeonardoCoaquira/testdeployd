FROM php:7-apache

LABEL maintainer="Sawood Alam <@ibnesayeed>"

ENV API_ENDPOINT="http://localhost:5000/api/"

# Copia los archivos al directorio de trabajo del servidor web
COPY . /var/www/html/

# Establece permisos adecuados para el servidor web
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/