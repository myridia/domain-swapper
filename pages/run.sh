#!/bin/bash

fun_osx() { 
    echo "osx"
    fswatch -o ./main.py templates/*.html| xargs -n1 -I{} ./main.py
}

fun_linux() { 
echo "linux"
rm public/*.html
rm db/*.json
./main.py
while inotifywait -e modify ./main.py templates/*.html templates/assets/css/styles.css  templates/assets/js/page.js 
do
   ./main.py
done    
}


case "$OSTYPE" in
  solaris*) echo "SOLARIS" ;;
  darwin*)  fun_osx ;; 
  linux*)   fun_linux ;;
  bsd*)     echo "BSD" ;;
  msys*)    echo "WINDOWS" ;;
  cygwin*)  echo "ALSO WINDOWS" ;;
  *)        echo "unknown: $OSTYPE" ;;
esac






