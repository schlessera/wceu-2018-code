<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

interface OrderStrategy {

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
