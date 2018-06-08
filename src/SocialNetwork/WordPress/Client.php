<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\WordPress;

use WordCampEurope\Workshop\Config\WordPressComCredentials as Credentials;

/**
 * Remote API client that connects to the WordPress.com API and fetches the
 * requested results.
 */
final class Client {

	const FEED_ENDPOINT = 'https://public-api.wordpress.com/rest/v1.2/read/search';

	/**
	 * WordPress.com authentication credentials.
	 *
	 * @var Credentials
	 */
	private $credentials;

	/**
	 * Instantiate a Feed object.
	 *
	 * @param Credentials $credentials   Credentials to use for authenticating
	 *                                   with WordPress.com.
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

		$url  = self::FEED_ENDPOINT . $url_arguments;
		$args = [];

		$access_token = $this->credentials->get_access_token();
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
}
