<?php

declare( strict_types = 1 );

namespace WMDE\EmailAddress\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WMDE\EmailAddress\EmailAddress;

/**
 * @covers \WMDE\EmailAddress\EmailAddress
 */
class EmailAddressTest extends TestCase {

	/**
	 * @dataProvider unparsableAddressProvider
	 */
	public function testWhenGivenEmailWithMissingParts_mailCannotConstruct( string $mailToTest, string $expectedException ): void {
		$this->expectException( \InvalidArgumentException::class );
		$this->expectExceptionMessage( $expectedException );

		new EmailAddress( $mailToTest );
	}

	public static function unparsableAddressProvider(): array {
		return [
			[ 'just.testing', 'Email must contain "@" character' ],
			[ '@example.com', 'Local part of email cannot be empty' ],
			[ '', 'Email must contain "@" character' ],
			[ '@', 'Email domain cannot be empty' ],
			[ ' ', 'Email must contain "@" character' ],
			[ 'jeroendedauw@', 'Email domain cannot be empty' ]
		];
	}

	public function testGetFullAddressReturnsOriginalInput(): void {
		$email = new EmailAddress( 'jeroendedauw@gmail.com' );

		$this->assertSame( 'jeroendedauw@gmail.com', $email->getFullAddress() );
	}

	public function testCanGetEmailParts(): void {
		$email = new EmailAddress( 'jeroendedauw@gmail.com' );

		$this->assertSame( 'jeroendedauw', $email->getUserName() );
		$this->assertSame( 'gmail.com', $email->getDomain() );
	}

	public function testCanGetEmailPartsWithDelimiterInLocalName(): void {
		$email = new EmailAddress( '"m@aster.of.the.universe"@gmail.com' );

		$this->assertSame( '"m@aster.of.the.universe"', $email->getUserName() );
		$this->assertSame( 'gmail.com', $email->getDomain() );
	}

	public function testCanNormalizedDomainName(): void {
		$email = new EmailAddress( 'info@triebwerk-grün.de' );

		$this->assertSame( 'xn--triebwerk-grn-7ob.de', $email->getNormalizedDomain() );
		$this->assertSame( 'info@xn--triebwerk-grn-7ob.de', $email->getNormalizedAddress() );
	}

	public function testInvalidDomainNamesAreNormalizedToEmpty(): void {
		$email = new EmailAddress( 'oh_boy@...' );

		$this->assertSame( '', $email->getNormalizedDomain() );
		$this->assertSame( 'oh_boy@', $email->getNormalizedAddress() );
	}

	public function testToStringOriginalInput(): void {
		$email = new EmailAddress( 'jeroendedauw@gmail.com' );

		$this->assertSame( 'jeroendedauw@gmail.com', (string)$email->getFullAddress() );
	}

}
