# Utilise une image PHP avec Apache
FROM php:8.2-apache

# Copie tous les fichiers dans le conteneur
COPY . /var/www/html/

# Expose le port 80 (utilisé par Apache)
EXPOSE 80

# Démarre Apache
CMD ["apache2-foreground"]