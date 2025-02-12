#!/bin/bash

# Set permissions and ownership
chmod 750 /var/www/public/doc
chown -R www-data:www-data /var/www/public/doc
chmod 640 /efnc-certs/.env
chown www-data:www-data /efnc-certs/.env
chmod 644 /efnc-certs/ca-cert.pem /efnc-certs/server-cert.pem
chmod 644 /efnc-certs/server-key.pem
chown www-data:www-data /efnc-certs/*.pem