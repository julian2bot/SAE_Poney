MODULES= $(wildcard src/*.py)

.PHONY: lint
lint:  
	pylint --rcfile=.pylintrc ${MODULES}

.PHONY: format
format:	
	yapf -ir ${MODULES}

.PHONY: makeDB
makeDB:	
	flask cleardb
	flask loaddb ./src/data/client.yaml

.PHONY: makeDB
all: makeDB
	flask run