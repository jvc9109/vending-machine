#!/bin/bash

if [ "${APP_ENV}" != "local" ] && [ "${APP_ENV}" != "test" ] && [ "${APP_ENV}" != "dev" ] && [ "${APP_ENV}" != "pre" ] && [ "${APP_ENV}" != "prod" ]; then
    echo "Environment: ${APP_ENV} is not a valid environment"
    exit
fi


if [ "${APP_ENV}" == "dev" ]; then

    # Put current remote host for xdebug
    export XDEBUG_SESSION=PHPSTORM
    echo "xdebug.start_with_request=false" >> /etc/php/8.0/cli/php.ini

fi

## Run cron
#/usr/sbin/cron

# Start apache
tail -f /dev/null
