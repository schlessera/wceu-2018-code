<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\Twitter;

use WordCampEurope\Workshop\SocialNetwork\Attributes;
use WordCampEurope\Workshop\SocialNetwork\Feed as FeedInterface;

final class Feed implements FeedInterface {

	/**
	 * Twitter client to use.
	 *
	 * @var Client
	 */
	private $client;

	/**
	 * Instantiate a Feed object.
	 *
	 * @param Client $client Twitter client to use.
	 */
	public function __construct( Client $client ) {
		$this->client = $client;
	}

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param Attributes $attributes Attributes to get the feed entry for.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( Attributes $attributes ): array {
		$entries = [];

		$feed_elements = $this->client->get_feed(
			$attributes->mention(),
			$attributes->limit()
		);

		foreach ( $feed_elements as $element ) {
			$entries[] = new FeedEntry( $element );
		}

		return $entries;
	}
}
