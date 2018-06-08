<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Exception;

use Exception;
use RuntimeException;

/**
 * Exception class that is thrown when a view file failed to load properly.
 *
 * This exceptions extends the SPL RuntimeException.
 */
class FailedToLoadView extends RuntimeException {

	/**
	 * Create a new instance of the exception if the view file itself created
	 * an exception.
	 *
	 * @param string    $uri       URI of the file that is not accessible or
	 *                             not readable.
	 * @param Exception $exception Exception that was thrown by the view file.
	 *
	 * @return static
	 */
	public static function view_exception(
		$uri,
		Exception $exception
	): FailedToLoadView {
		$message = sprintf(
			'Could not load the View URI "%1$s". Reason: "%2$s".',
			$uri,
			$exception->getMessage()
		);

		return new static( $message, $exception->getCode(), $exception );
	}
}
