DB_NAME=dbsql1
DB_USER=dbsql1
DB_PASSWORD=passpass
DATE=$(date +"%F")

ask() {
echo -e "I'm ask.sh. What would you like to do? Enter a Task ID from the list below: \n"
echo -e "TaskID\t Description"
echo -e "1\t Run - Docker Test Enviroment "
echo -e "2\t Run - Docker Page "
echo -e "3\t Clean Docker - Clean the docker containers and volumes "
echo -e "4\t Clean All - Clean the docker containers and volumes and images "
echo -e "5\t WPCLI - Get into Wp cli "
echo -e "6\t Gen PHP docs - Generate php docs into pages/public/docs "
echo -e "7\t Export Db - Export the database on the docker/test server"
echo -e "8\t Rename WP - Rename the database on the docker server"
echo -e "9\t Watch debug.log "
echo -e "10\t Create Pot file -Language"
echo -e "0\t Exit "
}


ask

until [ "$task" = "0" ]; do 
read task
if [ "$task" = "1" ]; then
    echo "...${task}"
    cd test
    docker-compose up -d
    echo "Open:"
    echo "http://127.0.0.1:5800"    
    echo "Visit if you set your host:"
    echo "https://app.local"
    
elif [ "$task" = "2" ]; then
    echo "...${task}"
    cd pages/dockers
    docker-compose up -d    
    echo "Visit:"
    echo "http://127.0.0.1:88"    

    
elif [ "$task" = "3" ]; then
    echo "...${task}"
    docker stop `docker ps -qa`    
    docker rm `docker ps -qa`
    docker volume rm $(docker volume ls -q --force --filter dangling=true)
    docker network prune --force
    
elif [ "$task" = "4" ]; then
    echo "...${task}"
    docker stop `docker ps -qa`        
    docker rm  `docker ps -qa`
    docker volume rm $(docker volume ls -q --filter dangling=true)
    docker network prune
    docker rmi --force `docker images -aq`    

elif [ "$task" = "5" ]; then
    echo "...${task}"
    cd test/wordpress
    docker exec -it wpcli bash
    
elif [ "$task" = "6" ]; then
    echo "...${task}"
    phpDocumentor run -d  test/wordpress/wp-content/plugins/domain-translate/  -t pages/public/docs/

elif [ "$task" = "7" ]; then
    echo "...${task}"
    docker  run -i --rm --net=host  salamander1/mysqldump --verbose -h db -u "${DB_NAME}" -p"${DB_PASSWORD}"  "${DB_NAME}" | gzip > "./test/init/${DB_NAME}-${DATE}.sql.gz"
    docker  run -i --rm --net=host  salamander1/mysqldump --verbose -h db -u "${DB_NAME}" -p"${DB_PASSWORD}"  "${DB_NAME}" | gzip > "./test/init/${DB_NAME}.sql.gz"

elif [ "$task" = "8" ]; then
    echo "...${task}"
    cd test/wordpress/
    wp search-replace "https://en.app.local" "https://app.local"  --skip-columns=guid

elif [ "$task" = "9" ]; then
    echo "...${task}"
    echo "" > test/wordpress/wp-content/debug.log 
    tail  test/wordpress/wp-content/debug.log  -f

elif [ "$task" = "10" ]; then
    echo "...${task}"
    docker exec wpcli wp i18n make-pot wp-content/plugins/domain-translate  wp-content/plugins/domain-translate/languages/domain-translate.pot  --allow-root    




    
else
    echo "Goodbye! - Exit"
fi

ask

done 

