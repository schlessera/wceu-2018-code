<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\WordPress;

use WordCampEurope\Workshop\SocialNetwork\Feed as FeedInterface;

final class Feed implements FeedInterface {

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * Instantiate a Feed object.
	 *
	 * @param Client $client WordPress client to use.
	 */
	public function __construct( Client $client ) {
		$this->client = $client;
	}

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param string $mention Mention to get the feed for.
	 * @param int    $limit   Optional. Limit the number of feed entries to this
	 *                        number. Defaults to 5.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( string $mention, int $limit = 5 ): array {
		$entries = [];

		$feed_elements = $this->client->get_feed( $mention, $limit );

		foreach ( $feed_elements as $element ) {
			$entries[] = new FeedEntry( $element );
		}

		return $entries;
	}
}
