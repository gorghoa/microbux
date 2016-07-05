FROM gorghoa/php7
RUN apt-get update && apt-get install -y net-tools

WORKDIR /app
ADD ./start.sh /start.sh


CMD ["/start.sh"]
