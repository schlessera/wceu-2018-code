<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\WordPress;

use DateTimeInterface;
use DateTimeImmutable;
use Exception;
use WordCampEurope\Workshop\SocialNetwork\FeedEntry as FeedEntryInterface;

/**
 * A single entry of the WordPress.com social media feed.
 */
final class FeedEntry implements FeedEntryInterface {

	const LINK_TAG  = '<a href="%s" class="%s">%s</a>';
	const TITLE_TAG = '<h3 class="%s">%s</h3>';

	/**
	 * API response element that this feed represents.
	 *
	 * @var object
	 */
	private $element;

	/**
	 * Instantiate a FeedEntry object.
	 *
	 * @param object $element API response element that this feed represents.
	 */
	public function __construct( $element ) {
		$this->element = $element;
	}

	/**
	 * Get the content of the feed entry.
	 *
	 * @return string Content of the feed entry.
	 */
	public function get_content(): string {
		$url = sprintf(
			self::LINK_TAG,
			$this->element->URL,
			'url url--wordpress',
			$this->element->title
		);

		$title = sprintf(
			self::TITLE_TAG,
			'title title--wordpress',
			$url
		);

		return $title . $this->element->excerpt;
	}

	/**
	 * Get the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author_name(): string {
		return sprintf(
			self::LINK_TAG,
			$this->get_author_field( 'profile_URL' ),
			'author author--wordpress',
			$this->get_author_field( 'name' )
		);
	}

	/**
	 * Get the slug of the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author_slug(): string {
		return $this->get_author_field( 'login' );
	}

	/**
	 * Get the time the feed entry was posted.
	 *
	 * @return DateTimeInterface Date & time that the entry was posted.
	 */
	public function get_posted_time(): DateTimeInterface {
		try {
			$date = new DateTimeImmutable( $this->element->date );
		} catch ( Exception $exception ) {
			return new DateTimeImmutable();
		}

		return $date;
	}

	/**
	 * Get the avatar image URL.
	 *
	 * @return string Avatar image URL.
	 */
	public function get_avatar_image_url(): string {
		return $this->get_author_field( 'avatar_URL' );
	}

	/**
	 * Get a given field from the author data.
	 *
	 * @param string $key Key to retrieve from the author data.
	 *
	 * @return string Value found under the requested key.
	 */
	private function get_author_field( string $key ): string {
		if ( ! isset( $this->element->author ) ) {
			return '';
		}

		$author = $this->element->author;

		if ( ! isset( $author->$key ) ) {
			return '';
		}

		return $author->$key;
	}
}
