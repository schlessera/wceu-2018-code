<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop;

/**
 * Segregated interface of something that can be registered.
 */
interface Registerable {

	/**
	 * Register the registerable element with the system.
	 *
	 * @return void
	 */
	public function register();
}
