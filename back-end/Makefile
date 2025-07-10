# Makefile for Symfony project database and fixtures

.PHONY: db-reset db-schema fixtures cache-clear all

db-reset:
	symfony console doctrine:database:drop --force --if-exists
	symfony console doctrine:database:create

db-schema:
	symfony console doctrine:schema:update --force

fixtures:
	symfony console doctrine:fixtures:load --no-interaction

cache-clear:
	symfony console cache:clear

# Full setup (drop DB, create, update schema, load fixtures, clear cache)
all: db-reset db-schema fixtures cache-clear
