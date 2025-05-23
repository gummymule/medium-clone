#!/bin/bash

# Tunggu MySQL sampai siap
until nc -z "$DB_HOST" "$DB_PORT"; do
  echo "Waiting for MySQL..."
  sleep 2
done

# Jalankan migration
php artisan migrate --force

# Start Laravel server
php artisan serve --host=0.0.0.0 --port=8000
