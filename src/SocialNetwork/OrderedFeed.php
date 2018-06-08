<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

final class OrderedFeed implements Feed {

	/**
	 * Feed to cache.
	 *
	 * @var Feed
	 */
	private $feed;

	/**
	 * Order strategy to use.
	 *
	 * @var OrderStrategy
	 */
	private $strategy;

	/**
	 * Instantiate a OrderedFeed object.
	 *
	 * @param Feed          $feed     Feed to cache.
	 * @param OrderStrategy $strategy Order strategy to use.
	 */
	public function __construct( Feed $feed, OrderStrategy $strategy ) {
		$this->feed     = $feed;
		$this->strategy = $strategy;
	}

	/**
	 * Get the feed entries for the social network.
	 *
	 * @param Attributes $attributes Attributes to get the feed entry for.
	 *
	 * @return FeedEntry[] Array of FeedEntry objects.
	 */
	public function get_entries( Attributes $attributes ): array {
		$entries = $this->feed->get_entries( $attributes );

		return $this->order_entries( $entries );
	}

	/**
	 * Order the entries using the provided order strategy.
	 *
	 * @param array $entries Entries to sort.
	 *
	 * @return array Sorted entries.
	 */
	public function order_entries( array $entries ): array {
		if ( empty( $entries ) ) {
			return [];
		}

		usort( $entries, [ $this->strategy, 'compare' ] );

		return $entries;
	}
}
