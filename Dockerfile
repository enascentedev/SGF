FROM php:8.0-apache

# Instalar dependências do PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev

# Instalar extensões PDO e PDO_PGSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Habilitar os módulos rewrite e headers do Apache
RUN a2enmod rewrite headers

# Configurar o Apache para permitir o uso de .htaccess
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/allow-override.conf && \
    a2enconf allow-override

# Definir o diretório de trabalho como o diretório do Apache
WORKDIR /var/www/html

# Copiar todo o conteúdo do projeto para o diretório do Apache
COPY . /var/www/html

# Expor a porta 80
EXPOSE 80

# Iniciar o Apache em primeiro plano
CMD ["apache2-foreground"]
