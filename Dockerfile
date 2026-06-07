FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
RUN npm install
RUN npm run build

# Prepare SQLite Database
RUN touch database/database.sqlite
RUN php artisan migrate --force

# Render assigns a dynamic port via the $PORT environment variable
ENV PORT=8000

# Start PHP built-in server
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
