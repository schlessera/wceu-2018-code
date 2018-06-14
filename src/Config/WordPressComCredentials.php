<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\Exception\MissingConfigKey;

/**
 * Configuration object that provides the credentials for the WordPress.com
 * Remote API Client implementation.
 */
final class WordPressComCredentials extends BaseConfig {

	const CLIENT_ID = 'client_id';
	const CLIENT_SECRET = 'client_secret';
	const API_TOKEN = 'api_token';

	const AUTHENTICATION_ENDPOINT = 'https://public-api.wordpress.com/oauth2/token';

	const REQUIRED_KEYS = [
		self::CLIENT_ID,
		self::CLIENT_SECRET,
		self::API_TOKEN,
	];

	/**
	 * Instantiate a BaseConfig object.
	 *
	 * @param array $config Associative array if configuration data.
	 */
	public function __construct( $config = array() ) {
		// Make sure the config entries can be accessed as properties.
		parent::__construct( $config );

		$this->validate_config();
	}

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
	 * Get an array of keys as it is required by the WordPress.com client.
	 *
	 * @return array<string>
	 */
	public function get_keys(): array {
		return [
			self::CLIENT_ID     => $this->offsetGet( self::CLIENT_ID ),
			self::CLIENT_SECRET => $this->offsetGet( self::CLIENT_SECRET ),
			self::API_TOKEN     => $this->offsetGet( self::API_TOKEN ),
		];
	}
}
