<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\Twitter;

use WordCampEurope\Workshop\Config\TwitterCredentials as Credentials;
use TwitterAPIExchange;
use Exception;

final class Client {

	const URL = 'https://api.twitter.com/1.1/search/tweets.json';

	/**
	 * Twitter authentication credentials.
	 *
	 * @var Credentials
	 */
	private $credentials;

	/**
	 * Instantiate a Feed object.
	 *
	 * @param Credentials $credentials Credentials to use for authenticating
	 *                                 with Twitter.
	 */
	public function __construct( Credentials $credentials ) {
		$this->credentials = $credentials;
	}

	public function get_feed( string $user, int $limit ) {
		$getfield = "?q={$user}&count={$limit}";
		$twitter  = new TwitterAPIExchange( $this->credentials->get_client_settings() );

		try {
			$response = $twitter->setGetfield( $getfield )
			                    ->buildOauth( self::URL, 'GET' )
			                    ->performRequest();
		} catch ( Exception $exception ) {
			// We couldn't execute the request, so return an empty array instead
			// of choking on the exception.
			return [];
		}

		$result = json_decode( $response );
		if ( isset( $result->errors ) && count( $result->errors > 0 ) ) {
			// The Twitter API produced an error, so just return an empty array
			// instead.
			return [];
		}

		return $result->statuses;
	}
}