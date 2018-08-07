#
# MAINTAINER        Allen Luo <movoin@gmail.com>
# DOCKER-VERSION    1.12.3
#

FROM        movoin/devops-swoole-nginx:2
MAINTAINER  Allen Luo <movoin@gmail.com>

COPY dockerfiles/ /opt/docker/

RUN set -x \
    # Install
    && /opt/docker/bin/install.sh \
    # Bootstrap
    && /opt/docker/bin/bootstrap.sh \
    # Clean up
    && yum clean all

WORKDIR /app
