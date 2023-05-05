#!/bin/bash

# Leveraging the variables defined in the Laravel .env file and the MySQL root password defined in docker-compose.yml
# create local and test databases

database="${MYSQL_DATABASE}"
testDatabase="${database}_test"

mysql --user="root" --password="${MYSQL_ROOT_PASSWORD}" -e "CREATE DATABASE IF NOT EXISTS $database"
mysql --user="root" --password="${MYSQL_ROOT_PASSWORD}" -e "GRANT ALL PRIVILEGES ON ${database}.* TO '${MYSQL_USER}'@'%'"

mysql --user="root" --password="${MYSQL_ROOT_PASSWORD}" -e "CREATE DATABASE IF NOT EXISTS $testDatabase"
mysql --user="root" --password="${MYSQL_ROOT_PASSWORD}" -e "GRANT ALL PRIVILEGES ON ${testDatabase}.* TO '${MYSQL_USER}'@'%'"
 