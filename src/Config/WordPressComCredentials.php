<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Config;

use WordCampEurope\Workshop\CachingEngine;
use WordCampEurope\Workshop\Exception\MissingConfigKey;

/**
 * Configuration object that provides the credentials for the WordPress.com
 * Remote API Client implementation.
 */
final class WordPressComCredentials extends BaseConfig {

	const CLIENT_ID     = 'client_id';
	const CLIENT_SECRET = 'client_secret';
	const USERNAME      = 'username';
	const PASSWORD      = 'password';

	const AUTHENTICATION_ENDPOINT = 'https://public-api.wordpress.com/oauth2/token';
	const CACHE_KEY_FORMAT        = 'wceu2018/access_token/wordpress_com/%s';

	const REQUIRED_KEYS = [
		self::CLIENT_ID,
		self::CLIENT_SECRET,
		self::USERNAME,
		self::PASSWORD,
	];

	/**
	 * Caching engine to use.
	 *
	 * @var CachingEngine
	 */
	private $cache;

	/**
	 * Instantiate a BaseConfig object.
	 *
	 * @param array         $config Associative array if configuration data.
	 * @param CachingEngine $cache  Optional. Caching engine to use. Defaults
	 *                              to TransientCache.
	 */
	public function __construct(
		$config = array(),
		CachingEngine $cache = null
	) {
		// Make sure the config entries can be accessed as properties.
		parent::__construct( $config );

		$this->validate_config();

		// We make the cache instance optional here, but fill it with a default
		// implementation.
		// This makes dependency injection optional, but still allows us to
		// easily inject a mock cache for testing.
		$this->cache = $cache ?? new CachingEngine\TransientCache();
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
			self::USERNAME      => $this->offsetGet( self::USERNAME ),
			self::PASSWORD      => $this->offsetGet( self::PASSWORD ),
		];
	}

	/**
	 * Get the access token to use for authentication.
	 *
	 * @return string Access token to use. Empty string if none available.
	 */
	public function get_access_token(): string {
		$keys = $this->get_keys();

		$cache_key = sprintf(
			self::CACHE_KEY_FORMAT,
			md5( json_encode( $keys ) )
		);

		$access_token = $this->cache->read( $cache_key );

		if ( false !== $access_token ) {
			return $access_token;
		}

		// Make sure we have everything we need.
		foreach ( self::REQUIRED_KEYS as $key ) {
			if ( empty( $keys[ $key ] ) ) {
				return '';
			}
		}

		$url  = self::AUTHENTICATION_ENDPOINT;
		$args = [
			'body' => [
				self::CLIENT_ID     => $keys[ self::CLIENT_ID ],
				self::CLIENT_SECRET => $keys[ self::CLIENT_SECRET ],
				self::USERNAME      => $keys[ self::USERNAME ],
				self::PASSWORD      => $keys[ self::PASSWORD ],
				'grant_type'        => 'password',
			],
		];

		$response = wp_remote_post( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );

		if ( (int) $code !== 200 ) {
			// The WordPress.com API produced an error, so just return an empty
			// array instead.
			$this->cache->write( $cache_key, '', 5 * MINUTE_IN_SECONDS );

			return '';
		}

		$result = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! isset( $result->access_token ) ) {
			// Result didn't contain posts, so just return an empty array.
			$this->cache->write( $cache_key, '', 5 * MINUTE_IN_SECONDS );

			return '';
		}

		$this->cache->write(
			$cache_key,
			$result->access_token,
			24 * HOUR_IN_SECONDS
		);

		return $result->access_token;
	}
}
