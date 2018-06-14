<?php

namespace WordCampEurope\Workshop;

use Exception;

/**
 * Segregated interface of something that can handle an exception.
 */
interface ExceptionHandler {

	/**
	 * @param Exception $exception
	 *
	 * @return void
	 */
	public function handle( Exception $exception );

}