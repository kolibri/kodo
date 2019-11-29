all: test cs-fix

test:
	./bin/phpunit

cs-fix:
	php-cs-fixer fix --allow-risky=yes

create-fixtures:
	./bin/console app:fixture:repos:create --cleanup


