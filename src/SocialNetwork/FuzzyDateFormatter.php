<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use Cake\Chronos\Chronos;
use DateTimeInterface;

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
