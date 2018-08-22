# 安装

## 快速开始

```bash
git clone https://github.com/movoin/onehub
```

## Docker

### 拉取镜像

**Nginx + Swoole 2.0**

```bash
docker pull movoin/devops-swoole-nginx:2
```

**Swoole 2.0**

```bash
docker pull movoin/devops-swoole:2
```

**Dockerfile**

```dockerfile
#
# MAINTAINER        Allen Luo <movoin@gmail.com>
# DOCKER-VERSION    1.12.3
#

FROM        movoin/devops-swoole:2
MAINTAINER  Allen Luo <movoin@gmail.com>

COPY dockerfiles/etc/ /etc/

WORKDIR /app/

RUN /opt/docker/bin/install.sh \
    && /opt/docker/bin/bootstrap.sh

```

## Docker Compose

```yaml
version: '2'
services:
  #######################################
  # PHP application Docker container
  #######################################
  app:
    build:
      context: .
      dockerfile: Dockerfile
    links:
      - redis
    ports:
      - "80:80"
    volumes:
      - ./:/app/
    # cap and privileged needed for slowlog
    cap_add:
      - SYS_PTRACE
    privileged: true
    env_file:
      - dockerfiles/etc/environment.yml
    networks:
      - docker-network



  #######################################
  # Redis server
  #######################################

  redis:
    image: redis:alpine
    ports:
      - "6379:6379"
    volumes:
      - ./data/redis:/data
    networks:
      - docker-network



  #######################################
  # MySQL server
  #######################################

  mysql:
    image: mysql:5.6
    ports:
      - "3306:3306"
    volumes:
      - ./data/mysql:/var/lib/mysql
    env_file:
      - dockerfiles/etc/environment.yml
    networks:
      - docker-network



#######################################
# Network
#######################################

networks:
  docker-network:
    driver: bridge
```

------

**相关内容：**

- [命令行工具 > 容器操作](console/container.md)
- [开发工具 > PHP SDK](devtools/php.md)
