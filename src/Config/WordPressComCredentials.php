<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\Exception\MissingConfigKey;

final class WordPressComCredentials extends BaseConfig {

	const CLIENT_ID     = 'client_id';
	const CLIENT_SECRET = 'client_secret';
	const USERNAME      = 'username';
	const PASSWORD      = 'password';

	const REQUIRED_KEYS = [
		self::CLIENT_ID,
		self::CLIENT_SECRET,
		self::USERNAME,
		self::PASSWORD,
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
			self::CLIENT_ID     => $this->offsetGet( self::CLIENT_ID ),
			self::CLIENT_SECRET => $this->offsetGet( self::CLIENT_SECRET ),
			self::USERNAME      => $this->offsetGet( self::USERNAME ),
			self::PASSWORD      => $this->offsetGet( self::PASSWORD ),
		];
	}
}
