<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Exception;

use DomainException;

/**
 * Exception class that is thrown when a required configuration key is missing.
 *
 * This exceptions extends the SPL DomainException.
 */
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

	/**
	 * Create a new instance of the exception for a missing or invalid network
	 * implementation.
	 *
	 * @param string $name Name of the social network.
	 *
	 * @return static
	 */
	public static function from_social_network_implementation(
		string $name
	): MissingConfigKey {
		$message = sprintf(
			'The configuration for the social network "%s" is missing a valid implementation class.',
			$name
		);

		return new static( $message );
	}

	/**
	 * Create a new instance of the exception for a missing or invalid network
	 * label.
	 *
	 * @param string $name Name of the social network.
	 *
	 * @return static
	 */
	public static function from_social_network_label(
		string $name
	): MissingConfigKey {
		$message = sprintf(
			'The configuration for the social network "%s" is missing a label.',
			$name
		);

		return new static( $message );
	}

	/**
	 * Create a new instance of the exception for a missing or invalid order
	 * strategy implementation.
	 *
	 * @param string $name Name of the sorting strategy.
	 *
	 * @return static
	 */
	public static function from_sorting_strategy_implementation(
		string $name
	): MissingConfigKey {
		$message = sprintf(
			'The configuration for the sorting strategy "%s" is missing a valid implementation class.',
			$name
		);

		return new static( $message );
	}

	/**
	 * Create a new instance of the exception for a missing or invalid order
	 * strategy label.
	 *
	 * @param string $name Name of the sorting strategy.
	 *
	 * @return static
	 */
	public static function from_sorting_strategy_label(
		string $name
	): MissingConfigKey {
		$message = sprintf(
			'The configuration for the sorting strategy "%s" is missing a label.',
			$name
		);

		return new static( $message );
	}
}
