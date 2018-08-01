ARGS = $(filter-out $@,$(MAKECMDGOALS))
MAKEFLAGS += --silent

#############################
# Docker machine states
#############################

rebuild:
	docker build -t one/hub $$(pwd)/

up:	clean_runtime run

run:
	docker run -it -d --name one_hub -p 9501:9501 -v $$(pwd):/app one/hub

down:
	docker stop one_hub && docker rm one_hub

start:
	docker start one_hub

stop:
	docker stop one_hub

ssh:
	docker exec -it -u app one_hub bash

root:
	docker exec -it one_hub bash

tail:
	docker logs -f one_hub

clean_ds:
	find . -name .DS_Store -print0 | xargs -0 rm -f

clean_runtime:
	rm -f $$(pwd)/runtime/**/*.log
	rm -f $$(pwd)/runtime/**/*.pid
	rm -f $$(pwd)/runtime/**/*.sock

#############################
# Argument fix workaround
#############################
%:
	@:
