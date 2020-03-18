<?php

declare( strict_types = 1 );

namespace WMDE\EmailAddress;

use const IDNA_NONTRANSITIONAL_TO_ASCII;
use const INTL_IDNA_VARIANT_UTS46;

/**
 * @licence GNU GPL v2+
 * @author Christoph Fischer < christoph.fischer@wikimedia.de >
 * @author Kai Nissen < kai.nissen@wikimedia.de >
 */
class EmailAddress {

	private $userName;
	private $domain;

	public function __construct( string $emailAddress ) {
		$delimiter = strrpos( $emailAddress, '@' );
		if ( $delimiter === false ) {
			throw new \InvalidArgumentException( 'Email must contain "@" character' );
		}
		$this->userName = substr( $emailAddress, 0, $delimiter );
		$this->domain = substr( $emailAddress, $delimiter + 1 );

		if ( trim( $this->domain ) === '' ) {
			throw new \InvalidArgumentException( 'Email domain cannot be empty' );
		}

		if ( trim( $this->userName ) === '' ) {
			throw new \InvalidArgumentException( 'Local part of email cannot be empty' );
		}
	}

	public function getUserName(): string {
		return $this->userName;
	}

	public function getDomain(): string {
		return $this->domain;
	}

	public function getNormalizedDomain(): string {
		return (string)idn_to_ascii( $this->domain, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46 );
	}

	public function getFullAddress(): string {
		return $this->userName . '@' . $this->domain;
	}

	public function getNormalizedAddress(): string {
		return $this->userName . '@' . $this->getNormalizedDomain();
	}

	public function __toString(): string {
		return $this->getFullAddress();
	}

}
