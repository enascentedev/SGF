FROM php:8.0-apache

# Instalar dependências do PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev

# Instalar extensões PDO e PDO_PGSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Habilitar o módulo rewrite do Apache para suportar URLs amigáveis
RUN a2enmod rewrite

# Configurar o Apache para permitir o uso de .htaccess
# Isso é feito alterando o arquivo de configuração padrão do Apache
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>" > /etc/apache2/conf-available/allow-override.conf && \
    a2enconf allow-override

# Definir o diretório de trabalho como o diretório do Apache
WORKDIR /var/www/html

# Copiar apenas o conteúdo da pasta public para o diretório do Apache
COPY ./public /var/www/html
