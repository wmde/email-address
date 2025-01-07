# Email Address

[![Build Status](https://travis-ci.org/wmde/email-address.svg?branch=main)](https://travis-ci.org/wmde/email-address)
[![Latest Stable Version](https://poser.pugx.org/wmde/email-address/version.png)](https://packagist.org/packages/wmde/email-address)
[![Download count](https://poser.pugx.org/wmde/email-address/d/total.png)](https://packagist.org/packages/wmde/email-address)

Email Address value object that can

- split username and domain 
- normalize Internationalized Domain names (IDN).

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
file that just defines a dependency on Email Address 2.x:

```json
{
    "require": {
        "wmde/email-address": "~2.0"
    }
}
```

## Development

### Installing dependencies

To pull in the project dependencies via Composer, run:

    make install

To update them, run

    make update

### Running the CI checks

To run all CI checks, which includes PHPUnit tests, PHPCS style checks and static analysis with PHPStan, run:

    make
    
### Running the tests

To run the PHPUnit tests run

    make test

To run a subset of PHPUnit tests or otherwise pass flags to PHPUnit, run

    docker compose run --rm app ./vendor/bin/phpunit --filter SomeClassNameOrFilter

