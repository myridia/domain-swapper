#!/bin/sh
while inotifywait -e modify ./main.py templates/*.html
do
   ./main.py
done
