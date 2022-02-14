#!/bin/bash
apachectl start
tail -f /app/logs/error.log | sed 's/\\n/\n/g'