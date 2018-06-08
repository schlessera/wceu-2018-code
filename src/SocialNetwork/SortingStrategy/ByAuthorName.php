<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\SortingStrategy;

use WordCampEurope\Workshop\SocialNetwork\FeedEntry;
use WordCampEurope\Workshop\SocialNetwork\SortingStrategy;

/**
 * Sorting strategy that sorts feed entries by their author name.
 *
 * Pattern: Strategy
 *
 * @see http://designpatternsphp.readthedocs.io/en/latest/Behavioral/Strategy/README.html
 */
final class ByAuthorName implements SortingStrategy {

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
	public function compare( FeedEntry $a, FeedEntry $b ): int {
		return mb_strtolower( $a->get_author_name() ) <=> mb_strtolower( $b->get_author_name() );
	}
}
