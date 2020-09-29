FROM mariadb:10.5

COPY ./initdb.d/ /docker-entrypoint-initdb.d/

RUN apt-get update &&\
    apt-get install --no-install-recommends -y nano locales && \
    echo "LC_ALL=en_US.UTF-8" >> /etc/environment && \
    sed -i 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && \
    echo "LANG=en_US.UTF-8" > /etc/locale.conf && \
    locale-gen en_US.UTF-8 && \
    ln -sf /usr/share/zoneinfo/Asia/Yekaterinburg /etc/localtime && echo "Asia/Yekaterinburg" > /etc/timezone

RUN sed -i 's/^bind-address/# bind-address/' /etc/mysql/my.cnf

ENV LC_ALL=en_US.UTF-8 \
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US.UTF-8

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["mysqld", "--character-set-server=utf8", "--collation-server=utf8_general_ci"]
