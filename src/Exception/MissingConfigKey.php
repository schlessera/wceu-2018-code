<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Exception;

use DomainException;

class MissingConfigKey extends DomainException {

	/**
	 * Create a new instance of the exception for a missing configuration value.
	 *
	 * @param string $key    Configuration key that is missing.
	 * @param string $config Configuration object that is missing the key.
	 *
	 * @return static
	 */
	public static function from_key(
		string $key,
		string $config
	): MissingConfigKey {
		$message = sprintf(
			'The configuration key "%s" is missing for the configuration object "%s".',
			$key,
			$config
		);

		return new static( $message );
	}

	/**
	 * Create a new instance of the exception for a missing network.
	 *
	 * @param string $network Network that is missing a configuration.
	 *
	 * @return static
	 */
	public static function from_network( string $network ): MissingConfigKey {
		$message = sprintf(
			'The network "%s" is missing from the set of configuration objects.',
			$network
		);

		return new static( $message );
	}
}
