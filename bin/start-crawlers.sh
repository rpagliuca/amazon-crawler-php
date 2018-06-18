#!/bin/bash

# Current dir
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Worker command
CMD="/.$DIR/start-one-crawler-with-proxy.sh"
NUM_WORKERS=14

i="0"
while [ $i -lt $NUM_WORKERS ]
do
    (
        until $CMD $i; do
            echo "Worker crashed with exit code $?. Respawning..." >&2
            sleep 1
        done
    ) &
    sleep 0.5
    i=$[$i+1]
done

# Wait for all subprocesses finish (forever or CTRL+C)
wait
