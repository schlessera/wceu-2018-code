<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork;

use DateTimeInterface;

/**
 * A single entry of a social media mentions feed.
 *
 * This is the common minimum set of data we want every supported social
 * network to provide.
 */
interface FeedEntry {

	/**
	 * Get the content of the feed entry.
	 *
	 * @return string Content of the feed entry.
	 */
	public function get_content(): string;

	/**
	 * Get the name of the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author_name(): string;

	/**
	 * Get the slug of the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author_slug(): string;

	/**
	 * Get the time the feed entry was posted.
	 *
	 * @return DateTimeInterface Date & time that the entry was posted.
	 */
	public function get_posted_time(): DateTimeInterface;

	/**
	 * Get the avatar image URL.
	 *
	 * @return string Avatar image URL.
	 */
	public function get_avatar_image_url(): string;
}
