format:
	@php ./vendor/bin/pint

lint:
	@php -d memory_limit=2G ./vendor/bin/phpstan analyse

serve:
	@php artisan serve
