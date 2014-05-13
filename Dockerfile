FROM ubuntu:14.04
# maintainer details
MAINTAINER Alexandre Combe "aco@yooz.fr"

RUN echo deb http://archive.ubuntu.com/ubuntu trusty main universe > /etc/apt/sources.list

RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get install -y openssh-server supervisor curl unzip
RUN mkdir -p /var/run/sshd
#RUN echo 'root:xela12' |chpasswd
RUN mkdir -p /var/log/supervisor

# Jenkins
RUN curl http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | apt-key add -
RUN echo deb http://pkg.jenkins-ci.org/debian binary/ > /etc/apt/sources.list.d/jenkins.list
RUN apt-get update
# HACK: https://issues.jenkins-ci.org/browse/JENKINS-20407
RUN mkdir /var/run/jenkins
RUN apt-get install -y jenkins

# Sonar
RUN curl --remote-name http://dist.sonar.codehaus.org/sonarqube-4.1.zip
RUN unzip sonarqube-4.1.zip
RUN mv sonarqube-4.1 /opt

# Git
RUN apt-get install -y git
# Clone and init repo for course
RUN git clone https://github.com/acombe/source-dev-practice-course

# Maven
# RUN apt-get install -y maven => error "fuse install device"
RUN wget http://wwwftp.ciril.fr/pub/apache/maven/maven-3/3.2.1/binaries/apache-maven-3.2.1-bin.zip
RUN unzip apache-maven-3.2.1-bin.zip
RUN mv apache-maven-3.2.1 /opt/
RUN ln -s /opt/apache-maven-3.2.1/bin/mvn /usr/bin/mvn

RUN sed -i '1iM3_HOME="/opt/apache-maven-3.2.1"' /etc/environment
RUN sed -i '1iM3="$M3_HOME/bin"' /etc/environment
RUN sed -i '1iJAVA_HOME="/usr/lib/jvm/java-7-openjdk-amd64/"' /etc/environment

# SSH
ADD authorized_keys /root/.ssh/authorized_keys
RUN sed -i 's/.*session.*required.*pam_loginuid.so.*/session optional pam_loginuid.so/g' /etc/pam.d/sshd
# Allow root ssh connection 
#RUN mkdir /home/root

ADD supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 22 8080 9000
CMD ["/usr/bin/supervisord"]
