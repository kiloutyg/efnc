#!/bin/bash

# Set ownership to mysql user
chown mysql:mysql /efnc-db-certs/*.pem

# Set permissions for certificate files
chmod 644 /efnc-db-certs/ca-cert.pem /efnc-db-certs/server-cert.pem

# Set secure permissions for private key
chmod 644 /efnc-db-certs/server-key.pem