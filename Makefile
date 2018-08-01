ARGS = $(filter-out $@,$(MAKECMDGOALS))
MAKEFLAGS += --silent

#############################
# Docker machine states
#############################

rebuild:
	docker build -t one/swoole/loghub $$(pwd)/

up:	clean_runtime run

run:
	docker run -it -d --name one_swoole_loghub -p 9501:9501 -v $$(pwd):/app one/swoole/loghub

down:
	docker stop one_swoole_loghub && docker rm one_swoole_loghub

start:
	docker start one_swoole_loghub

stop:
	docker stop one_swoole_loghub

ssh:
	docker exec -it -u app one_swoole_loghub bash

root:
	docker exec -it one_swoole_loghub bash

tail:
	docker logs -f one_swoole_loghub

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
