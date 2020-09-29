#!/usr/bin/env bash

echo 'Creating project databases...'

mysql -u "root" -p"${MYSQL_ROOT_PASSWORD}" -e "CREATE DATABASE IF NOT EXISTS ${MYSQL_DATABASE} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u "root" -p"${MYSQL_ROOT_PASSWORD}" -e "GRANT ALL PRIVILEGES ON ${MYSQL_DATABASE} TO '${MYSQL_USER}'@'%';" "${MYSQL_DATABASE}"

mysql -u "root" -p"${MYSQL_ROOT_PASSWORD}" -e "CREATE DATABASE \`${MYSQL_DATABASE}_test\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u "root" -p"${MYSQL_ROOT_PASSWORD}" -e "GRANT ALL PRIVILEGES ON \`${MYSQL_DATABASE}\_test\`.* TO '${MYSQL_USER}'@'%';" "${MYSQL_DATABASE}_test"

echo 'Created project databases.'
