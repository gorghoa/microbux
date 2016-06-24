FROM gorghoa/php7

ENV REACT_PORT 8000

RUN echo export PATH="$PATH:/app/vendor/bin" >> /root/.bashrc

WORKDIR /app

CMD ["/usr/bin/php", "server.php"]
