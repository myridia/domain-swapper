#!/bin/sh
rm public/*.html
rm db/*.json
./main.py
while inotifywait -e modify ./main.py templates/*.html
do
   ./main.py
done
