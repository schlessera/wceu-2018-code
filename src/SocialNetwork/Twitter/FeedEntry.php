<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\SocialNetwork\Twitter;

use DateTimeInterface;
use DateTimeImmutable;
use Exception;
use WordCampEurope\Workshop\SocialNetwork\FeedEntry as FeedEntryInterface;

final class FeedEntry implements FeedEntryInterface {

	const LINK_TAG         = '<a href="%s" class="%s">%s</a>';
	const HASHTAG_URL      = 'https://twitter.com/hashtag/%s';
	const USER_MENTION_URL = 'https://twitter.com/%s';
	const DEFAULT_AVATAR   = 'https://abs.twimg.com/sticky/default_profile_images/default_profile_bigger.png';

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
		return $this->linkify(
			$this->element->text,
			$this->element->entities
		);
	}

	/**
	 * Get the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author_name(): string {
		$url = sprintf(
			self::USER_MENTION_URL,
			$this->element->user->screen_name
		);

		return sprintf(
			self::LINK_TAG,
			$url,
			'author author--twitter',
			$this->element->user->name
		);
	}

	/**
	 * Get the slug of the author that posted the feed entry.
	 *
	 * @return string Author name.
	 */
	public function get_author_slug(): string {
		return "@{$this->element->user->screen_name}";
	}

	/**
	 * Get the time the feed entry was posted.
	 *
	 * @return DateTimeInterface Date & time that the entry was posted.
	 */
	public function get_posted_time(): DateTimeInterface {
		try {
			$date = new DateTimeImmutable( $this->element->created_at );
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
		if ( ! isset( $this->element->user->profile_image_url_https ) ) {
			return self::DEFAULT_AVATAR;
		}

		return $this->element->user->profile_image_url_https;
	}

	/**
	 * Turn the known entities of a feed entry into active links.
	 *
	 * @param string $content         Content that contains the entities.
	 * @param object $entities_object Object that contains data about the
	 *                                entities.
	 *
	 * @return string Linkified content.
	 */
	private function linkify( string $content, $entities_object ): string {
		// We need to order the entities by index first, otherwise we risk
		// breaking the content while doing replacements.
		$entities = $this->get_sorted_entities( $entities_object );

		foreach ( $entities as $entity ) {
			$data = current( $entity );
			switch ( key( $entity ) ) {
				case 'hashtag':
					$content = $this->link_to_url(
						$content,
						$data->indices[0],
						$data->indices[1],
						sprintf( self::HASHTAG_URL, $data->text ),
						'hashtag hashtag--twitter'
					);
					break;
				case 'symbol':
					// TODO: No idea what this is meant to represent...
					break;
				case 'user_mention':
					$content = $this->link_to_url(
						$content,
						$data->indices[0],
						$data->indices[1],
						sprintf( self::USER_MENTION_URL, $data->screen_name ),
						'user-mention user-mention--twitter'
					);
					break;
				case 'url':
					$content = $this->link_to_url(
						$content,
						$data->indices[0],
						$data->indices[1],
						sprintf( $data->url ),
						'url url--twitter'
					);
					break;
			}
		}

		return $content;
	}

	/**
	 * Get an array of entities sorted by furthest down into the string first.
	 *
	 * @param object $entities_object Object that contains data about the
	 *                                entities.
	 *
	 * @return array Sorted array of entities.
	 */
	private function get_sorted_entities( $entities_object ) {
		$entities = [];
		foreach ( [ 'hashtag', 'symbol', 'user_mention', 'url' ] as $type ) {
			$key = "{$type}s";
			foreach ( $entities_object->$key as $entity ) {
				$entities[ $entity->indices[0] ] = [ $type => $entity ];
			}
		}

		krsort( $entities );

		return $entities;
	}

	/**
	 * Replace the text of an entity with a link to that entity.
	 *
	 * @param string $content Content contain the entity text.
	 * @param int    $start   Starting character index of the entity text.
	 * @param int    $end     Ending character index of the entity text.
	 * @param string $url     URL to link to.
	 * @param string $classes CSS classes to add to the link.
	 *
	 * @return string
	 */
	private function link_to_url(
		string $content,
		int $start,
		int $end,
		string $url,
		string $classes
	) {
		$pre         = mb_substr( $content, 0, $start );
		$anchor_text = mb_substr( $content, $start, $end - $start );
		$post        = mb_substr( $content, $end );
		$link        = sprintf( self::LINK_TAG, $url, $classes, $anchor_text );

		return "{$pre}{$link}{$post}";
	}
}
