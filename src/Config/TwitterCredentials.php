<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\Exception\MissingConfigKey;

/**
 * Configuration object that provides the credentials for the Twitter Remote
 * API Client implementation.
 */
final class TwitterCredentials extends BaseConfig {

	const OAUTH_ACCESS_TOKEN        = 'oauth_access_token';
	const OAUTH_ACCESS_TOKEN_SECRET = 'oauth_access_token_secret';
	const CONSUMER_KEY              = 'consumer_key';
	const CONSUMER_SECRET           = 'consumer_secret';

	const REQUIRED_KEYS = [
		self::OAUTH_ACCESS_TOKEN,
		self::OAUTH_ACCESS_TOKEN_SECRET,
		self::CONSUMER_KEY,
		self::CONSUMER_SECRET,
	];

	/**
	 * Asserts that the current configuration data is valid.
	 */
	protected function validate_config() {
		foreach ( self::REQUIRED_KEYS as $key ) {
			if ( ! $this->offsetExists( $key ) ) {
				$class = str_replace( __NAMESPACE__ . '\\', '', __CLASS__ );
				throw MissingConfigKey::from_key( $key, $class );
			}
		}
	}

	/**
	 * Get an array of settings as it is required by the Twitter client.
	 *
	 * @return array<string>
	 */
	public function get_client_settings(): array {
		return [
			self::OAUTH_ACCESS_TOKEN        => $this->offsetGet( self::OAUTH_ACCESS_TOKEN ),
			self::OAUTH_ACCESS_TOKEN_SECRET => $this->offsetGet( self::OAUTH_ACCESS_TOKEN_SECRET ),
			self::CONSUMER_KEY              => $this->offsetGet( self::CONSUMER_KEY ),
			self::CONSUMER_SECRET           => $this->offsetGet( self::CONSUMER_SECRET ),
		];
	}
}
