<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Block;

use WordCampEurope\Workshop\Asset;
use WordCampEurope\Workshop\SocialNetwork\Attributes;
use WordCampEurope\Workshop\SocialNetwork\Feed;
use WordCampEurope\Workshop\SocialNetwork\FuzzyDateFormatter;
use WordCampEurope\Workshop\View\ViewFactory;

/**
 * This is the main class that represents our custom Gutenberg block.
 *
 * It contains all the references to the JS & CSS assets, and it handles the
 * basic mapping of the attributes. Everything that is not part of the
 * extensible collection of social networks.
 */
final class SocialMediaMentions extends GutenbergBlock {

	const BLOCK_NAME = 'wceu2018/mentions';

	const BLOCK_EDITOR_JS = 'mentions-block-editor';
	const BLOCK_EDITOR_CSS = 'mentions-block-editor';
	const BLOCK_CSS = 'mentions-block';

	const FRONTEND_VIEW = 'templates/social-media-mentions';

	/**
	 * Feed to use.
	 *
	 * @var Feed
	 */
	private $feed;

	/**
	 * Instantiate a SocialMediaMentions object.
	 *
	 * @param Feed        $feed         Feed to use.
	 * @param ViewFactory $view_factory View factory to use.
	 */
	public function __construct(
		Feed $feed,
		ViewFactory $view_factory
	) {
		$this->feed = $feed;
		parent::__construct( $view_factory );
	}

	/**
	 * Get an array of Enqueueable assets.
	 *
	 * These should be keyed with the attributes that map them to Gutenberg:
	 * - GutenbergBlock::EDITOR_SCRIPT
	 * - GutenbergBlock::EDITOR_STYLE
	 * - GutenbergBlock::SCRIPT
	 * - GutenbergBlock::STYLE
	 *
	 * @return array<Enqueueable>
	 */
	protected function get_assets(): array {
		return [
			GutenbergBlock::EDITOR_SCRIPT => new Asset\Script(
				self::BLOCK_EDITOR_JS,
				new Asset\Location\Minifiable(
					new Asset\Location\Relative( 'assets/js/mentions-editor.js' )
				),
				[ 'wp-blocks', 'wp-i18n', 'wp-element' ]
			),
			GutenbergBlock::EDITOR_STYLE  => new Asset\Style(
				self::BLOCK_EDITOR_CSS,
				new Asset\Location\Minifiable(
					new Asset\Location\Relative( 'assets/css/mentions-editor.css' )
				),
				[ 'wp-editor' ]
			),
			GutenbergBlock::STYLE         => new Asset\Style(
				self::BLOCK_CSS,
				new Asset\Location\Minifiable(
					new Asset\Location\Relative( 'assets/css/mentions.css' )
				),
				[ 'wp-editor' ]
			),
		];
	}

	/**
	 * Get the name of the block to register.
	 *
	 * @return string Name of the block.
	 */
	protected function get_block_name(): string {
		return self::BLOCK_NAME;
	}

	/**
	 * Get the attributes to register.
	 *
	 * @return array Associative array of attributes.
	 */
	protected function get_attributes(): array {
		return Attributes::SCHEMA;
	}

	/**
	 * Get the location of the frontend view to be rendered.
	 *
	 * @return string Relative location of the frontend view.
	 */
	protected function get_frontend_view(): string {
		return self::FRONTEND_VIEW;
	}

	/**
	 * Get the contextual data with which to render the frontend.
	 *
	 * @param array $context Associative array of contextual data.
	 *
	 * @return array Associative array of contextual data.
	 */
	protected function get_frontend_context( array $context ): array {
		$attributes = Attributes::from_context( $context );

		return [
			'feed_entries'   => $this->feed->get_entries( $attributes ),
			'date_formatter' => new FuzzyDateFormatter(),
		];
	}

}
