# Wait for database to be up

until [ "$(mysql -u$DB_USER -p$DB_PASSWORD -h$DB_HOST -e 'SHOW DATABASES')" ]; do
    sleep 1
done

mysql -u$DB_USER -p$DB_PASSWORD -h$DB_HOST -e "CREATE DATABASE $DB_NAME;"

cd ..; vendor/bin/doctrine orm:schema-tool:update --force

cd bin; ./console setup-insert-initial-data
