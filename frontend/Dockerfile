## Usa uma imagem PHP oficial com Apache (mais simples que Nginx para iniciantes)
#FROM php:8.2-apache
#
## Instala extensões PHP e dependências
#RUN apt-get update && apt-get install -y \
#    git \
#    zip \
#    unzip \
#    && docker-php-ext-install pdo_mysql
#
## Instala o Composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#
## Define o diretório de trabalho
#WORKDIR /var/www/html
#
## Copia os arquivos do projeto Laravel para o container
#COPY frontend/ .
#
## Instala as dependências do Composer
#RUN composer install --no-dev --optimize-autoloader
#
## Configura as permissões de escrita (storage/logs)
#RUN chown -R www-data:www-data storage bootstrap/cache \
#    && chmod -R 775 storage bootstrap/cache
#
## Copia o arquivo de configuração do virtual host (substitui o index.html default)
#COPY frontend/docker/vhost.conf /etc/apache2/sites-available/000-default.conf
## Habilita o mod_rewrite
#RUN a2enmod rewrite
#
## Expõe a porta (porta padrão do Apache)
#EXPOSE 80