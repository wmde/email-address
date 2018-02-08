# Email Address

[![Build Status](https://travis-ci.org/wmde/email-address.svg?branch=master)](https://travis-ci.org/wmde/email-address)
[![Latest Stable Version](https://poser.pugx.org/wmde/email-address/version.png)](https://packagist.org/packages/wmde/email-address)
[![Download count](https://poser.pugx.org/wmde/email-address/d/total.png)](https://packagist.org/packages/wmde/email-address)

Email Address value object written in PHP 7.

```php
class EmailAddress {
	public function __construct( string $emailAddress ) {
		// Validation
	}
	public function getUserName(): string {}
	public function getDomain(): string {}
	public function getNormalizedDomain(): string {}
	public function getFullAddress(): string {}
	public function getNormalizedAddress(): string {}
	public function __toString(): string {}
}
```

## Installation

To use the Email Address library in your project, simply add a dependency on wmde/email-address
to your project's `composer.json` file. Here is a minimal example of a `composer.json`
file that just defines a dependency on Email Address 1.x:

```json
{
    "require": {
        "wmde/email-address": "~1.0"
    }
}
```

## Development

For development you need to have Docker and Docker-compose installed. Local PHP and Composer are not needed.

    sudo apt-get install docker docker-compose

### Running Composer

To pull in the project dependencies via Composer, run:

    make composer install

You can run other Composer commands via `make run`, but at present this does not support argument flags.
If you need to execute such a command, you can do so in this format:

    docker run --rm --interactive --tty --volume $PWD:/app -w /app\
     --volume ~/.composer:/composer --user $(id -u):$(id -g) composer composer install -vvv

### Running the CI checks

To run all CI checks, which includes PHPUnit tests, PHPCS style checks and coverage tag validation, run:

    make
    
### Running the tests

To run just the PHPUnit tests run

    make test

To run only a subset of PHPUnit tests or otherwise pass flags to PHPUnit, run

    docker-compose run --rm email-address-7.1 ./vendor/bin/phpunit --filter SomeClassNameOrFilter
