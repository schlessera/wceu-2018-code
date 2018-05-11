<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Block;

use WordCampEurope\Workshop\Asset;

final class SocialMediaMentions extends GutenbergBlock {

	const BLOCK_NAME = 'wceu2018/mentions';

	const BLOCK_EDITOR_JS  = 'mentions-block-editor';
	const BLOCK_EDITOR_CSS = 'mentions-block-editor';
	const BLOCK_CSS        = 'mentions-block';

	const FRONTEND_VIEW = 'templates/social-media-mentions';

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
		return [];
	}

	/**
	 * Get the location of the frontend view to be rendered.
	 *
	 * @return string Relative location of the frontend view.
	 */
	protected function get_frontend_view(): string {
		return self::FRONTEND_VIEW;
	}
}
