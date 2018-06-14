<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Exception;

use RuntimeException;

/**
 * Exception class that is thrown when a required dependency is missing.
 *
 * This exceptions extends the SPL RuntimeException.
 */
class MissingDependency extends RuntimeException {

	/**
	 * Create a new instance of the exception for a missing the Gutenberg plugin.
	 *
	 * @return static
	 */
	public static function for_gutenberg(): MissingDependency {
		$message = 'You need to install the Gutenberg plugin for the WCEU 2018 Workshop Code plugin to work.';

		return new static( $message );
	}

}