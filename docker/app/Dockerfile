FROM centos:7
ENV container docker
COPY nginx.repo /etc/yum.repos.d/nginx.repo

RUN (cd /lib/systemd/system/sysinit.target.wants/; for i in *; do [ $i == \
systemd-tmpfiles-setup.service ] || rm -f $i; done); \
rm -f /lib/systemd/system/multi-user.target.wants/*;\
rm -f /etc/systemd/system/*.wants/*;\
rm -f /lib/systemd/system/local-fs.target.wants/*; \
rm -f /lib/systemd/system/sockets.target.wants/*udev*; \
rm -f /lib/systemd/system/sockets.target.wants/*initctl*; \
rm -f /lib/systemd/system/basic.target.wants/*;\
rm -f /lib/systemd/system/anaconda.target.wants/*;\
yum update -y;\
yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm -y; \
yum install yum-utils -y;\
yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm -y; \
yum-config-manager --enable remi-php72 -y;\
yum install php72 php72-php-fpm php72-php-mysqlnd -y; \
yum install php72-php-opcache php72-php-xml php72-php-xmlrpc -y;\
yum install php72-php-gd php72-php-mbstring php72-php-json php72-curl php72-mcrypt -y;\
yum install php72-zip php72-pdo php72-pdo-mysql php72-cli php72--tokenizer -y; \
yum install supervisor -y; \
yum install vim -y; \
yum -y update && yum clean all;\
ln -s /usr/bin/php72 /usr/bin/php;\
systemctl enable php72-php-fpm.service;\
yum install nginx -y;\
systemctl enable nginx;\
yum install git -y;\
cd /tmp; \
curl -sS https://getcomposer.org/installer | php; \
mv composer.phar /usr/local/bin/composer;



COPY default /etc/nginx/conf.d/default.conf
COPY php.ini /etc/opt/remi/php72/php.ini
COPY www.conf /etc/opt/remi/php72/php-fpm.d/www.conf
COPY php-fpm.conf /etc/opt/remi/php72/php-fpm.conf
COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisord.conf



EXPOSE 80
EXPOSE 443

WORKDIR /var/www/html
VOLUME [ "/sys/fs/cgroup" ]

CMD ["supervisord"]
CMD ["/usr/sbin/init"]
