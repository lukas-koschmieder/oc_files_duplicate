#!/bin/bash
# Docker entrypoint
# (c) Lukas Koschmieder <lukas.koschmieder@rwth-aachen.de>

# Exit on error

set -e

# Fall back to default admin user credentials if undefined

ADMIN_USER=${ADMIN_USER:-admin}
ADMIN_PASS=${ADMIN_PASS:-admin}
echo "ownCloud admin username: $ADMIN_USER"
echo "ownCloud admin password: $ADMIN_PASS"

# Install ownCloud database, admin user and files_duplicate app

su - apache -s /bin/bash -c "php /var/www/html/owncloud/occ maintenance:install --database sqlite --admin-user $ADMIN_USER --admin-pass $ADMIN_PASS"
su - apache -s /bin/bash -c "php /var/www/html/owncloud/occ app:enable files_duplicate"

# Start Apache

httpd -k start

# Enter infinite loop in order to keep Docker container running
# Use trap to quickly respond to Docker container controls

trap : TERM INT
sleep infinity & wait
