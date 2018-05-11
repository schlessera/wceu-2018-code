<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Exception;

use InvalidArgumentException;

class InvalidEscapeContext extends InvalidArgumentException {

	/**
	 * Create a new instance of the exception for an escape context class that
	 * is not valid.
	 *
	 * @param string $escape_context Escape context class that is not valid
	 *
	 * @return static
	 */
	public static function from_escape_context(
		string $escape_context
	): InvalidEscapeContext {
		$message = sprintf(
			'The Escape Context "%s" is not valid.',
			$escape_context
		);

		return new static( $message );
	}
}
