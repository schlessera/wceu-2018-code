<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\Block;

use WordCampEurope\Workshop\Asset;
use WordCampEurope\Workshop\Registerable;
use WordCampEurope\Workshop\Renderable;
use WordCampEurope\Workshop\View\EscapeContext;
use WordCampEurope\Workshop\View\ViewFactory;

abstract class GutenbergBlock implements Registerable, Renderable {

	const EDITOR_SCRIPT = 'editor_script';
	const EDITOR_STYLE  = 'editor_style';
	const SCRIPT        = 'script';
	const STYLE         = 'style';

	/**
	 * View factory to use for creating the views.
	 *
	 * @var ViewFactory
	 */
	protected $view_factory;

	/**
	 * Array of assets that are needed for this block.
	 *
	 * @var array<Asset>
	 */
	protected $assets;

	/**
	 * Instantiate a GutenbergBlock object.
	 *
	 * @param ViewFactory $view_factory Optional. View factory to use.
	 */
	public function __construct( ViewFactory $view_factory ) {
		$this->view_factory = $view_factory;
		$this->assets       = $this->get_assets();
	}

	/**
	 * Register the registerable element with the system.
	 *
	 * @return void
	 */
	public function register() {
		$this->register_assets();
		$this->register_block();
	}

	/**
	 * Render the current Renderable.
	 *
	 * @param array $context Context in which to render.
	 *
	 * @return string Rendered output.
	 */
	public function render( array $context = [] ): string {
		$view = $this->view_factory->create(
			$this->get_frontend_view(),
			EscapeContext::POST
		);

		$context = array_merge( $context, $this->get_frontend_context() );

		return $view->render( $context );
	}

	/**
	 * Register all required assets.
	 */
	protected function register_assets() {
		array_map( [ $this, 'register_asset' ], $this->assets );
	}

	/**
	 * Register a single asset.
	 *
	 * @param Asset\Enqueueable $asset
	 */
	protected function register_asset( Asset\Enqueueable $asset ) {
		$asset->register();
	}

	/**
	 * Enqueue a single asset.
	 *
	 * @param Asset\Enqueueable $asset
	 */
	protected function enqueue_asset( Asset\Enqueueable $asset ) {
		$asset->enqueue();
	}

	/**
	 * Register the Gutenberg block.
	 *
	 * @return void
	 */
	protected function register_block() {
		$args = [
			'render_callback' => [ $this, 'render' ],
			'attributes'      => $this->get_attributes(),
		];

		foreach ( $this->get_gutenberg_asset_types() as $type ) {
			if ( ! array_key_exists( $type, $this->assets ) ) {
				continue;
			}

			$args[ $type ] = $this->assets[ $type ]->get_handle();
		}

		register_block_type( $this->get_block_name(), $args );
	}

	/**
	 * Return an array of Gutenberg asset types.
	 *
	 * @return array<string> Array of Gutenberg asset types.
	 */
	protected function get_gutenberg_asset_types(): array {
		return [
			self::EDITOR_SCRIPT,
			self::EDITOR_STYLE,
			self::SCRIPT,
			self::STYLE,
		];
	}

	/**
	 * Get the name of the block to register.
	 *
	 * @return string Name of the block.
	 */
	abstract protected function get_block_name(): string;

	/**
	 * Get the attributes to register.
	 *
	 * @return array Associative array of attributes.
	 */
	abstract protected function get_attributes(): array;

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
	abstract protected function get_assets(): array;

	/**
	 * Get the location of the frontend view to be rendered.
	 *
	 * @return string Relative location of the frontend view.
	 */
	abstract protected function get_frontend_view(): string;

	/**
	 * Get the contextual data with which to render the frontend.
	 *
	 * @return array Associative array of contextual data.
	 */
	abstract protected function get_frontend_context(): array;
}
