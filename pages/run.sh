#!/bin/sh
while inotifywait -e modify ./main.py
do
   ./main.py
done
