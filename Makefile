ARGS = $(filter-out $@,$(MAKECMDGOALS))
MAKEFLAGS += --silent

#############################
# Docker machine states
#############################

clean_runtime:
	rm -f $$(pwd)/runtime/**/*.log
	rm -f $$(pwd)/runtime/**/*.pid
	rm -f $$(pwd)/runtime/**/*.sock

clean_ds:
	find . -name .DS_Store -print0 | xargs -0 rm -f

build:
	docker build -t one/hub $$(pwd)/

start:
	clean_runtime
	clean_ds
	build
	docker run -it -d --name one_hub -p 9501:9501 -v $$(pwd):/app one/hub

stop:
	docker stop one_hub

remove:
	docker stop one_hub && docker rm one_hub

ssh:
	docker exec -it -u app one_hub bash

root:
	docker exec -it one_hub bash

logs:
	docker logs -f one_hub

#############################
# Docker Commpose
#############################

up:
	docker-compose up -d

down:
	docker-compose stop
	docker-compose rm

rebuild:
	docker-compose stop
	docker-compose rm --force app
	docker-compose build --no-cache
	docker-compose up -d

tail:
	docker-compose logs -f

status:
	echo "--------------------"
	echo "=> Process status <="
	echo "--------------------"
	docker-compose ps
	echo ""
	echo "--------------------"
	echo "=> Process detail <="
	echo "--------------------"
	docker-compose top
	echo ""

shell:
	docker exec -it -u app $$(docker-compose ps -q app) /bin/bash

super:
	docker exec -it -u root $$(docker-compose ps -q app) /bin/bash


#############################
# Argument fix workaround
#############################
%:
	@:
