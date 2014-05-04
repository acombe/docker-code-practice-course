FROM phusion/baseimage:0.9.9
# maintainer details
MAINTAINER Alexandre Combe "aco@yooz.fr"
# Set correct environment variables.
ENV HOME /root

# Regenerate SSH host keys. baseimage-docker does not contain any, so you
# have to do that yourself. You may also comment out this instruction; the
# init system will auto-generate one during boot.
RUN /etc/my_init.d/00_regen_ssh_host_keys.sh

# Use baseimage-docker's init system.
CMD ["/sbin/my_init"]

RUN echo deb http://archive.ubuntu.com/ubuntu precise main universe > /etc/apt/sources.list
RUN apt-get update

# Jenkins
RUN apt-get install -y curl
RUN curl http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | apt-key add -
RUN echo deb http://pkg.jenkins-ci.org/debian binary/ > /etc/apt/sources.list.d/jenkins.list
RUN apt-get update
# HACK: https://issues.jenkins-ci.org/browse/JENKINS-20407
RUN mkdir /var/run/jenkins
RUN apt-get install -y jenkins
RUN mkdir /etc/service/jenkins
ADD jenkins.sh /etc/service/jenkins/run

# Oracle Java 7
RUN apt-get install -y python-software-properties
RUN add-apt-repository ppa:webupd8team/java -y
RUN apt-get update
RUN echo oracle-java7-installer shared/accepted-oracle-license-v1-1 select true | /usr/bin/debconf-set-selections
RUN apt-get install -y oracle-java7-installer

# Sonar
RUN curl --remote-name http://dist.sonar.codehaus.org/sonarqube-4.1.zip
RUN apt-get install -y unzip
RUN unzip sonarqube-4.1.zip
RUN mv sonarqube-4.1 /opt

RUN mkdir /etc/service/sonar
ADD sonar.sh /etc/service/sonar/run

# Maven 
RUN apt-get install -y maven

# Git 
#RUN apt-get install -y git=1:1.7.9.5-1 -v
#RUN apt-get install -y git
# Clone and init repo for course
#RUN git clone https://github.com/acombe/source-dev-practice-course

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
