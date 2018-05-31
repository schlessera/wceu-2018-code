<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use DateTimeInterface;

interface FeedEntry {

	/**
	 * Get the content of the feed entry.
	 *
	 * @return string Content of the feed entry.
	 */
	public function get_content(): string;

	/**
	 * Get the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author(): string;

	/**
	 * Get the time the feed entry was posted.
	 *
	 * @return DateTimeInterface Date & time that the entry was posted.
	 */
	public function get_posted_time(): DateTimeInterface;
}
