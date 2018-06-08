<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

/**
 * Turns an implementation of the Feed interface that represents a collection
 * of feed entries into a sorted collection of feed entries.
 *
 * Pattern: Decorator
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Structural/Decorator/README.html
 */
final class OrderedFeed implements Feed {

	/**
	 * Feed to cache.
	 *
	 * @var Feed
	 */
	private $feed;

	/**
	 * Sorting strategy to use.
	 *
	 * @var SortingStrategy
	 */
	private $strategy;

	/**
	 * Instantiate a OrderedFeed object.
	 *
	 * @param Feed            $feed     Feed to cache.
	 * @param SortingStrategy $strategy Sorting strategy to use.
	 */
	public function __construct( Feed $feed, SortingStrategy $strategy ) {
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
	 * Order the entries using the provided sorting strategy.
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
