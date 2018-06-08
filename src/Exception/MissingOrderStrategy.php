<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Exception;

use DomainException;

class MissingOrderStrategy extends DomainException {

	/**
	 * Create a new instance of the exception for a missing strategy.
	 *
	 * @param string $strategy Strategy that is missing.
	 *
	 * @return static
	 */
	public static function from_strategy( string $strategy ): MissingConfigKey {
		$message = sprintf(
			'The order strategy "%s" is missing from the set of known strategies.',
			$strategy
		);

		return new static( $message );
	}
}
