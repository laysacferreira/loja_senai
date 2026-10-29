FROM php:8.2-apache

# Instala as extensões necessárias para o MySQL e PDO
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia todo o projeto para a pasta padrão do Apache
COPY . /var/www/html/

# Altera a configuração do Apache para apontar diretamente para dentro da pasta 'loja'
RUN sed -i 's!/var/www/html!/var/www/html/loja!g' /etc/apache2/sites-available/000-default.conf

# Configura as permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 80