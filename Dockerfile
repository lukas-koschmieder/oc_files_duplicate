# Dockerfile
FROM centos:7
MAINTAINER Lukas Koschmieder <lukas.koschmieder@rwth-aachen.de>

# Install ownCloud
RUN rpm --import https://download.owncloud.org/download/repositories/9.1/CentOS_7/repodata/repomd.xml.key
RUN yum-config-manager --add-repo https://download.owncloud.org/download/repositories/9.1/CentOS_7/ce:9.1.repo
RUN yum clean expire-cache
RUN yum install -y owncloud

# Symlink app
RUN ln -s /files_duplicate/ /var/www/html/owncloud/apps/

# Add Docker entrypoint, Apache config and ownCloud app
COPY ./docker-entrypoint.sh /
COPY ./apache.conf /etc/httpd/conf.d/
