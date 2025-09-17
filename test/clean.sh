#!/bin/bash

docker rm --force `docker ps -qa`
docker volume rm $(docker volume ls -q --filter dangling=true)
docker network prune
<<<<<<< HEAD
=======

>>>>>>> 9641d45ef15d451cc717c3d3fb91b8c45e015dc1

if [ "$1" == "all" ] || [ $# -gt 1 ]; then
  echo "clean all including images"
  docker rmi --force `docker images -aq`    
fi

