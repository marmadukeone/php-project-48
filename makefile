install:
	composer install

validate:
	composer validate
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
say-hello:
	echo "Hello, World!"
