<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Block;

use WordCampEurope\Workshop\Asset;
use WordCampEurope\Workshop\Config\OrderStrategies;
use WordCampEurope\Workshop\Config\SocialNetworks;
use WordCampEurope\Workshop\SocialNetwork\Attributes;
use WordCampEurope\Workshop\SocialNetwork\FeedFactory;
use WordCampEurope\Workshop\SocialNetwork\FuzzyDateFormatter;
use WordCampEurope\Workshop\View\ViewFactory;

final class SocialMediaMentions extends GutenbergBlock {

	const BLOCK_NAME = 'wceu2018/mentions';

	const BLOCK_EDITOR_JS  = 'mentions-block-editor';
	const BLOCK_EDITOR_CSS = 'mentions-block-editor';
	const BLOCK_CSS        = 'mentions-block';

	const SOCIAL_NETWORKS_INLINE_SCRIPT = 'wceu2018_social_media_mentions_network_labels';
	const ORDER_STRATEGY_INLINE_SCRIPT  = 'wceu2018_social_media_mentions_order_strategy_labels';

	const FRONTEND_VIEW = 'templates/social-media-mentions';

	/**
	 * Feed factory to use.
	 *
	 * @var FeedFactory
	 */
	private $feed_factory;

	/**
	 * Available social networks.
	 *
	 * @var SocialNetworks
	 */
	private $networks;

	/**
	 * Available order strategies.
	 *
	 * @var OrderStrategies
	 */
	private $order_strategies;

	/**
	 * Instantiate a SocialMediaMentions object.
	 *
	 * @param FeedFactory     $feed_factory     Feed factory to use.
	 * @param ViewFactory     $view_factory     View factory to use.
	 * @param SocialNetworks  $networks         Available social networks.
	 * @param OrderStrategies $order_strategies Available order strategies.
	 */
	public function __construct(
		FeedFactory $feed_factory,
		ViewFactory $view_factory,
		SocialNetworks $networks,
		OrderStrategies $order_strategies
	) {
		$this->feed_factory     = $feed_factory;
		$this->networks         = $networks;
		$this->order_strategies = $order_strategies;
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
			new Asset\InlineScript(
				self::BLOCK_EDITOR_JS,
				$this->get_social_network_labels_script(),
				'before'
			),
			new Asset\InlineScript(
				self::BLOCK_EDITOR_JS,
				$this->get_order_strategy_labels_script(),
				'before'
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

		$feed = $this->feed_factory->create( $attributes );

		return [
			'feed_entries'   => $feed->get_entries( $attributes ),
			'date_formatter' => new FuzzyDateFormatter(),
		];
	}

	/**
	 * Get the network label data as a JavaScript script to inline.
	 *
	 * @return string JavaScript script to inline.
	 */
	protected function get_social_network_labels_script(): string {
		$labels = [];
		foreach ( $this->networks as $network => $attributes ) {
			$labels[] = [
				'value' => $network,
				'label' => $attributes['label'],
			];
		}

		return sprintf(
			'var %s = %s;',
			self::SOCIAL_NETWORKS_INLINE_SCRIPT,
			json_encode( $labels )
		);
	}

	/**
	 * Get the order strategy label data as a JavaScript script to inline.
	 *
	 * @return string JavaScript script to inline.
	 */
	protected function get_order_strategy_labels_script(): string {
		$labels = [];
		foreach ( $this->order_strategies as $strategy => $attributes ) {
			$labels[] = [
				'value' => $strategy,
				'label' => $attributes['label'],
			];
		}

		return sprintf(
			'var %s = %s;',
			self::ORDER_STRATEGY_INLINE_SCRIPT,
			json_encode( $labels )
		);
	}
}
