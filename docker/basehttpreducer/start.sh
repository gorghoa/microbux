#!/bin/bash
set -o monitor

IP=`/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'`
php -S 0.0.0.0:8000 &
sleep 2
curl -X POST -H "Content-Type: application/json" -H "Cache-Control: no-cache" -d "{
    \"provider\": \"HTTP\",
    \"options\": {\"base_uri\": \"http://$IP:8000\"},
    \"name\": \"$REDUCER_NAME\"
}" "$MICROBUX_STORE/register"
fg %1
