FROM php:8.2

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Create a new user named "appuser"
RUN groupadd -r appuser && useradd -r -g appuser appuser

# Set the working directory
WORKDIR /var/www/html

# Copy composer.json from the build context
COPY ./composer.json /var/www/html/

# Change the owner of the working directory to the new user
RUN chown -R appuser:appuser /var/www/html

# Switch to the new user
USER appuser

# Copy the application code
COPY ./ /var/www/html/

# Set the ENTRYPOINT
ENTRYPOINT ["./docker/php/entrypoint.sh"]
