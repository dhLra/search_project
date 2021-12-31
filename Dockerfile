FROM debian:10

RUN apt update && \
      apt -y install php7.3 php7.3-common php7.3-cli php7.3-json php7.3-pdo \
          php7.3-mysql php7.3-zip php7.3-gd php7.3-mbstring php7.3-curl php7.3-xml \
          php7.3-bcmath apache2 libapache2-mod-php7.3 curl

RUN mkdir /app && \
      addgroup --gid 1000 ada && \
      adduser --home /app --no-create-home --add_extra_groups \
              --ingroup ada --shell /bin/bash --uid 1000 ada && \
      a2enmod rewrite && \
      a2enmod php7.* && \
      service apache2 stop

COPY ./docker/start.sh /start.sh

WORKDIR /app

CMD ["/start.sh"] 
