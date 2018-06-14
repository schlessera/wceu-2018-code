<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

/**
 * Abstracts away the strategy that is being used to sort the result set.
 *
 * The basic algorithm takes two elements, and returns less than, equal to, or
 * greater than zero if the first entry is considered to be respectively less
 * than, equal to, or greater than the second.
 *
 * Pattern: Strategy
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Behavioral/Strategy/README.html
 */
interface SortingStrategy {

	/**
	 * Comparison callback for the given strategy.
	 *
	 * @param FeedEntry $a First entry to compare.
	 * @param FeedEntry $b Second entry to compare.
	 *
	 * @return int Comparison result. Less than, equal to, or greater than zero
	 *             if the first entry is considered to be respectively less
	 *             than, equal to, or greater than the second.
	 */
	public function compare( FeedEntry $a, FeedEntry $b ): int;
}
