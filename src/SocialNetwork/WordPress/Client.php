<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\WordPress;

use WordCampEurope\Workshop\Config\WordPressComCredentials as Credentials;

/**
 * Remote API client that connects to the WordPress.com API and fetches the
 * requested results.
 */
final class Client {

	const API_ROOT                = 'https://public-api.wordpress.com/';
	const FEED_ENDPOINT           = 'rest/v1.2/read/search';
	const AUTHENTICATION_ENDPOINT = 'oauth2/token';
	const CACHE_KEY_FORMAT        = 'wceu2018/access_token/wordpress_com/%s';

	/**
	 * WordPress.com authentication credentials.
	 *
	 * @var Credentials
	 */
	private $credentials;

	/**
	 * Instantiate a Feed object.
	 *
	 * @param Credentials $credentials Credentials to use for authenticating
	 *                                 with WordPress.com.
	 */
	public function __construct( Credentials $credentials ) {
		$this->credentials = $credentials;
	}

	/**
	 * Search the WordPress.com posts for a mention
	 *
	 * @param string $mention Mention to search for.
	 * @param int    $limit   Limit the result set to this number.
	 *
	 * @return array Array of mentions for the given user.
	 */
	public function get_feed( string $mention, int $limit ) {
		$search_string = urlencode( $mention );
		$url_arguments = "?q={$search_string}&number={$limit}";

		$url  = self::API_ROOT . self::FEED_ENDPOINT . $url_arguments;
		$args = $this->get_default_http_args();

		$access_token = $this->get_access_token();
		if ( ! empty( $access_token ) ) {
			$args['headers']['Authorization'] = "Bearer {$access_token}";
		}

		$response = wp_remote_get( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );

		if ( (int) $code !== 200 ) {
			// The WordPress.com API produced an error, so just return an empty
			// array instead
			return [];
		}

		$result = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! isset( $result->posts ) ) {
			// Result didn't contain posts, so just return an empty array.
			return [];
		}

		return $result->posts;
	}

	/**
	 * Get the access token to use for authentication.
	 *
	 * @return string Access token to use. Empty string if none available.
	 */
	private function get_access_token(): string {
		$keys = $this->credentials->get_keys();

		$transient_key = sprintf(
			self::CACHE_KEY_FORMAT,
			md5( json_encode( $keys ) )
		);

		$access_token = get_transient( $transient_key );

		if ( false !== $access_token ) {
			return $access_token;
		}

		// Make sure we have everything we need.
		foreach ( Credentials::REQUIRED_KEYS as $key ) {
			if ( empty( $keys[ $key ] ) ) {
				return '';
			}
		}

		$url          = self::API_ROOT . self::AUTHENTICATION_ENDPOINT;
		$args         = $this->get_default_http_args();
		$args['body'] = [
			Credentials::CLIENT_ID     => $keys[ Credentials::CLIENT_ID ],
			Credentials::CLIENT_SECRET => $keys[ Credentials::CLIENT_SECRET ],
			Credentials::USERNAME      => $keys[ Credentials::USERNAME ],
			Credentials::PASSWORD      => $keys[ Credentials::PASSWORD ],
			'grant_type'               => 'password',
		];

		$response = wp_remote_post( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );

		if ( (int) $code !== 200 ) {
			// The WordPress.com API produced an error, so just return an empty
			// array instead
			set_transient( $transient_key, '', 5 * MINUTE_IN_SECONDS );

			return '';
		}

		$result = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! isset( $result->access_token ) ) {
			// Result didn't contain posts, so just return an empty array.
			set_transient( $transient_key, '', 5 * MINUTE_IN_SECONDS );

			return '';
		}

		set_transient(
			$transient_key,
			$result->access_token,
			24 * HOUR_IN_SECONDS
		);

		return $result->access_token;
	}

	/**
	 * Get the default HTTP arguments to use.
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	private function get_default_http_args(): array {
		return [
			'timeout'     => 2,
			'httpversion' => '1.1',
		];
	}
}
