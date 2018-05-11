<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop;

interface Registerable {

	/**
	 * Register the registerable element with the system.
	 *
	 * @return void
	 */
	public function register();
}
