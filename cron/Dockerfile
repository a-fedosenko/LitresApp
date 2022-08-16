FROM alpine:3.13.6

RUN apk add --no-cache curl vim

# Copy in customized crontab file
COPY crontab /etc/crontabs/root
RUN chmod 777 /etc/crontabs/root

# Copy in entrypoint.sh script; this allows cron to run as daemon
COPY entrypoint.sh /entrypoint.sh
RUN chmod 777 /entrypoint.sh
ENTRYPOINT sh /entrypoint.sh
