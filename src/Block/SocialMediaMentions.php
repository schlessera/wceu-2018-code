<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Block;

use WordCampEurope\Workshop\Asset;
use WordCampEurope\Workshop\SocialNetwork\Feed;
use WordCampEurope\Workshop\SocialNetwork\FeedFactory;
use WordCampEurope\Workshop\SocialNetwork\FuzzyDateFormatter;
use WordCampEurope\Workshop\View\ViewFactory;

final class SocialMediaMentions extends GutenbergBlock {

	const BLOCK_NAME = 'wceu2018/mentions';

	const BLOCK_EDITOR_JS  = 'mentions-block-editor';
	const BLOCK_EDITOR_CSS = 'mentions-block-editor';
	const BLOCK_CSS        = 'mentions-block';

	const FRONTEND_VIEW = 'templates/social-media-mentions';

	/**
	 * Feed factory to use.
	 *
	 * @var FeedFactory
	 */
	private $feed_factory;

	/**
	 * Instantiate a SocialMediaMentions object.
	 *
	 * @param FeedFactory $feed_factory Feed factory to use.
	 * @param ViewFactory $view_factory View factory to use.
	 */
	public function __construct(
		FeedFactory $feed_factory,
		ViewFactory $view_factory
	) {
		$this->feed_factory = $feed_factory;
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
		return [
			'network' => [
				'type'    => 'text',
				'default' => 'twitter',
			],
			'mention' => [
				'type'    => 'text',
				'default' => '@schlessera',
			],
			'limit'   => [
				'type'    => 'integer',
				'default' => 5,
			],
		];
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
		$network = $this->get_network_name( $context );
		$mention = $this->get_mention( $context );
		$limit   = $this->get_limit( $context );
		$feed    = $this->feed_factory->create( $network );

		return [
			'feed_entries'   => $feed->get_entries( $mention, $limit ),
			'date_formatter' => new FuzzyDateFormatter(),
		];
	}

	/**
	 * Get the network name to use for instantiating the feed.
	 *
	 * @param array $context Associative array of contextual data.
	 *
	 * @return string Name of the social network to use.
	 */
	private function get_network_name( array $context ): string {
		return isset( $context['network'] )
			? (string) $context['network']
			: $this->get_attributes()['network']['default'];
	}

	/**
	 * Get the mwntion that the feed should reflect.
	 *
	 * @param array $context Associative array of contextual data.
	 *
	 * @return string Mention to use for the feed.
	 */
	private function get_mention( array $context ): string {
		return isset( $context['mention'] )
			? (string) $context['mention']
			: $this->get_attributes()['mention']['default'];
	}

	/**
	 * Get the number of entries to display at the most.
	 *
	 * @param array $context Associative array of contextual data.
	 *
	 * @return int Number of entries to limit the feed to.
	 */
	private function get_limit( array $context ): int {
		return isset( $context['limit'] )
			? (int) $context['limit']
			: $this->get_attributes()['limit']['default'];
	}
}
