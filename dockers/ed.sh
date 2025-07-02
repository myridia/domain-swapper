#!/bin/bash

DB_NAME=dbsql1
DB_USER=dbsql1
DB_PASSWORD=passpass
DATE=$(date +"%F")

docker  run -i --rm --net=host  salamander1/mysqldump --verbose -h db -u "${DB_NAME}" -p"${DB_PASSWORD}"  "${DB_NAME}" | gzip > "init/${DB_NAME}-${DATE}.sql.gz"

docker  run -i --rm --net=host  salamander1/mysqldump --verbose -h db -u "${DB_NAME}" -p"${DB_PASSWORD}"  "${DB_NAME}" | gzip > "init/${DB_NAME}.sql.gz"

