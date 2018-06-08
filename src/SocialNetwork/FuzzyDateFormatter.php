<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use Cake\Chronos\Chronos;
use DateTimeInterface;

/**
 * Abstracts away the logic we need to format a given date into the fuzzy output
 * that people are used to for social networks.
 *
 * This object is injected into a view, so that the view does not need to know
 * about the exact logic itself.
 */
final class FuzzyDateFormatter {

	/**
	 * Format a precise point in time into a relative, fuzzy string.
	 *
	 * @param DateTimeInterface $time
	 *
	 * @return string Fuzzy time string.
	 */
	public function format( DateTimeInterface $time ): string {
		return Chronos::createFromFormat(
			DATE_ATOM,
			$time->format( DATE_ATOM )
		)->diffForHumans();
	}
}
