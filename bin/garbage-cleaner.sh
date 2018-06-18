#!/bin/bash
INTERVAL=3600
while [ true ]; do
    SECONDS=0
    while [ "$SECONDS" -lt "$INTERVAL" ]; do
        echo "Countdown for next garbage cleaning: " $((INTERVAL - SECONDS))
        sleep 1
    done
    echo "Killing everything..."
    killall -s 9 chrome
    killall -s 9 chromedriver
    killall -s 9 tor
done
