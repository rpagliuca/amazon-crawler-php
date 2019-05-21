#!/bin/bash

# Current dir
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Get random port
read LOWERPORT UPPERPORT < /proc/sys/net/ipv4/ip_local_port_range
while :
do
    SOCKS_PORT="`shuf -i $LOWERPORT-$UPPERPORT -n 1`"
    ss -lpn | grep -q ":$SOCKS_PORT " || break
done

# Start Tor
TOR_LOG=$(mktemp)
TOR_FOLDER=$(mktemp)".d"
echo "SocksPort 0.0.0.0:$SOCKS_PORT
DataDirectory $TOR_FOLDER" | tor -f - > $TOR_LOG &
TOR_PID=$!

SUCCESS_MESSAGE="Tor has successfully opened a circuit. Looks like client functionality is working."
echo "Waiting for Tor ($TOR_PID) <$TOR_LOG> to initialize on port $SOCKS_PORT..."
SECONDS=0
while true; do
    if grep "$SUCCESS_MESSAGE" "$TOR_LOG"; then
        break
    fi
    if [ "$SECONDS" -gt 30 ]; then
        echo "Timed out waiting for Tor ($TOR_PID) <$TOR_LOG> to initialize... Exiting..."
        echo "Exiting Tor PID $TOR_PID..."
        kill -s 9 $TOR_PID
        rm -rf "$TOR_LOG"
        rm -rf "$TOR_FOLDER"
        echo "Exited Tor."
        exit 1
    fi
    sleep 1
done

echo "Tor has initialized."

php "$DIR/../index.php" "$SOCKS_PORT"

echo "Exiting Tor PID $TOR_PID..."
kill -s 9 $TOR_PID
rm -rf "$TOR_LOG"
rm -rf "$TOR_FOLDER"
echo "Exited Tor."

exit 1
