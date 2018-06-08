<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Exception;

use InvalidArgumentException;

/**
 * Exception class that is thrown when an invalid View URI was provided.
 *
 * This exceptions extends the SPL InvalidArgumentException.
 */
class InvalidURI extends InvalidArgumentException {

	/**
	 * Create a new instance of the exception for a file that is not accessible
	 * or not readable.
	 *
	 * @param string $uri URI of the file that is not accessible or not
	 *                    readable.
	 *
	 * @return static
	 */
	public static function from_uri( $uri ): InvalidURI {
		$message = sprintf(
			'The View URI "%s" is not accessible or readable.',
			$uri
		);

		return new static( $message );
	}
}
