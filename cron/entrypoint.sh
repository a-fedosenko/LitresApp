#!/bin/sh
echo "Starting Cron service..."
crond -f -l 8 -d 8 -L /dev/stdout