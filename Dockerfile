FROM php:8.1-apache

# Installation des extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activation du module Apache mod_rewrite
RUN a2enmod rewrite

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers de l'application
COPY . .

# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Configuration d'Apache pour servir depuis la racine
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>' > /etc/apache2/conf-available/app.conf && \
    a2enconf app

# Exposition du port
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"]
