FROM gitpod/workspace-full:latest

USER root

# Install MySQL
RUN install-packages mysql-server \
 && mkdir -p /var/run/mysqld /var/log/mysql \
 && chown -R gitpod:gitpod /etc/mysql /var/run/mysqld /var/log/mysql /var/lib/mysql /var/lib/mysql-files /var/lib/mysql-keyring /var/lib/mysql-upgrade

# Install our own MySQL config
COPY mysql.cnf /etc/mysql/mysql.conf.d/mysqld.cnf

# Install default-login for MySQL clients
COPY client.cnf /etc/mysql/mysql.conf.d/client.cnf

COPY mysql-bashrc-launch.sh /etc/mysql/mysql-bashrc-launch.sh

USER gitpod

RUN echo "/etc/mysql/mysql-bashrc-launch.sh" >> ~/.bashrc

RUN sudo apt-get remove -yq php7.2 && \
    sudo add-apt-repository ppa:ondrej/php && \
    sudo apt-get update -q && \
    sudo apt-get install -yq php7.3 && \
    sudo rm -rf /var/lib/apt/lists/*
    
RUN sudo npm install -g grunt 
