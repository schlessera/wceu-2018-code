<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\WordPress;

final class Client {

	const URL = 'https://public-api.wordpress.com/rest/v1.2';

	/**
	 * Search the WordPress.com posts for a mention
	 *
	 * @param string $mention Mention to search for.
	 * @param int    $limit   Limit the result set to this number.
	 *
	 * @return array Array of mentions for the given user.
	 */
	public function get_feed( string $mention, int $limit ) {
		$endpoint   = '/read/search';
		$parameters = [
			'q'      => $mention,
			'number' => $limit,
		];
		$headers    = [ 'Content-Type' => 'application/json' ];

		$url = self::URL . $endpoint . '?' . http_build_query( $parameters );

		$args = [
			'timeout'     => 2,
			'httpversion' => '1.1',
			'headers'     => $headers,
		];

		$response = wp_remote_get( $url, $args );
		$code     = wp_remote_retrieve_response_code( $response );

		if ( (int) $code !== 200 ) {
			// The WordPress.com API produced an error, so just return an empty array instead
			return [];
		}

		$result = json_decode( wp_remote_retrieve_body( $response ) );

		return $result->posts;
	}
}
