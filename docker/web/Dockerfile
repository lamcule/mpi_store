FROM nginx:1.10


ADD vhost.conf /etc/nginx/conf.d/default.conf

RUN echo "deb [check-valid-until=no] http://cdn-fastly.deb.debian.org/debian jessie main" > /etc/apt/sources.list.d/jessie.list
RUN echo "deb [check-valid-until=no] http://archive.debian.org/debian jessie-backports main" > /etc/apt/sources.list.d/jessie-backports.list
RUN sed -i '/deb http:\/\/deb.debian.org\/debian jessie-updates main/d' /etc/apt/sources.list
RUN apt-get -o Acquire::Check-Valid-Until=false update && apt-get install -y vim

RUN openssl genrsa -des3 -passout pass:x -out server.pass.key 2048 \
    && openssl rsa -passin pass:x -in server.pass.key -out server.key \
    && rm server.pass.key \
    && openssl req -new -key server.key -out server.csr -subj "/CN=app.store.gemvietnam.com" \
    && openssl x509 -req -days 365 -in server.csr -signkey server.key -out server.crt \
   && cp server.crt /etc/ssl/certs/ \
   && cp server.key /etc/ssl/private/ \
    && rm -rf /tmp/certgen
