<?php

declare( strict_types = 1 );

namespace WMDE\EmailAddress\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use WMDE\EmailAddress\EmailAddress;

#[CoversClass( EmailAddress::class )]
class EmailAddressTest extends TestCase {

	#[DataProvider( 'unparsableAddressProvider' )]
	public function testWhenGivenEmailWithMissingParts_mailCannotConstruct( string $mailToTest, string $expectedException ): void {
		$this->expectException( InvalidArgumentException::class );
		$this->expectExceptionMessage( $expectedException );

		new EmailAddress( $mailToTest );
	}

	/**
	 * @return iterable<array{string, string}>
	 */
	public static function unparsableAddressProvider(): iterable {
		yield [ 'just.testing', 'Email must contain "@" character' ];
		yield [ '@example.com', 'Local part of email cannot be empty' ];
		yield [ '', 'Email must contain "@" character' ];
		yield [ '@', 'Email domain cannot be empty' ];
		yield [ ' ', 'Email must contain "@" character' ];
		yield [ 'jeroendedauw@', 'Email domain cannot be empty' ];
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
