# Wait for database to be up

until [ "$(mysql -uroot -proot -hdb -e 'SHOW DATABASES')" ]; do
    sleep 1
done

mysql -uroot -proot -hdb -e "CREATE DATABASE webcrawler;"

cd ..; vendor/bin/doctrine orm:schema-tool:update --force

cd bin; ./console setup-insert-initial-data
