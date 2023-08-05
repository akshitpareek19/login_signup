# Use the official PHP base image with Apache
FROM php:apache

# Install additional PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install MySQL client
RUN apt-get update && apt-get install -y default-mysql-client

# Copy the website files into the container
COPY . /var/www/html/


