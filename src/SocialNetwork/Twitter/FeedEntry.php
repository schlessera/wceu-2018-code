<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\Twitter;

use DateTimeInterface;
use WordCampEurope\Workshop\SocialNetwork\FeedEntry as FeedEntryInterface;

final class FeedEntry implements FeedEntryInterface {

	/**
	 * Get the content of the feed entry.
	 *
	 * @return string Content of the feed entry.
	 */
	public function get_content(): string {
		// TODO: Implement get_content() method.
	}

	/**
	 * Get the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author(): string {
		// TODO: Implement get_author() method.
	}

	/**
	 * Get the time the feed entry was posted.
	 *
	 * @return DateTimeInterface Date & time that the entry was posted.
	 */
	public function get_posted_time(): DateTimeInterface {
		// TODO: Implement get_posted_time() method.
	}
}
