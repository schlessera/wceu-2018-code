( function ( blocks, editor, components, i18n, element, networkOptions, sortingOptions ) {

	var el = element.createElement;
	var __ = i18n.__;

	blocks.registerBlockType( 'wceu2018/mentions', {
		title: __( 'Social Media Mentions' ),
		category: 'widgets',
		icon: 'format-chat',
		supports: { html: false },

		attributes: {
			network: {
				type: 'text',
				default: networkOptions[ 0 ].value
			},
			mention: {
				type: 'text',
				default: 'WCEU'
			},
			limit: {
				type: 'integer',
				default: 5
			},
			order_strategy: {
				type: 'text',
				default: sortingOptions[ 0 ].value
			}
		},

		edit: function ( props ) {
			return [
				el(
					components.ServerSideRender,
					{
						block: 'wceu2018/mentions',
						attributes: props.attributes
					}
				),
				el( editor.InspectorControls, { key: 'inspector' },
					el( components.PanelBody, {
							title: __( 'Social Media Mentions' ),
							className: 'block-social-mentions',
							initialOpen: true
						},
						el( components.SelectControl, {
							label: __( 'Network to pull mentions from' ),
							options: networkOptions,
							value: props.attributes.network,
							onChange: function ( value ) {
								props.setAttributes(
									{ network: value }
								);
							}
						} ),
						el( components.TextControl, {
							label: __( 'Mention to look for' ),
							value: props.attributes.mention,
							onChange: function ( value ) {
								props.setAttributes(
									{ mention: value }
								);
							}
						} ),
						el( components.RangeControl, {
							label: __( 'How many entries to fetch' ),
							value: props.attributes.limit,
							min: 1,
							max: 20,
							onChange: function ( value ) {
								props.setAttributes(
									{ limit: value }
								);
							}
						} ),
						el( components.SelectControl, {
							label: __( 'How to sort the results' ),
							options: sortingOptions,
							value: props.attributes.order_strategy,
							onChange: function ( value ) {
								props.setAttributes(
									{ order_strategy: value }
								);
							}
						} )
					)
				)
			];
		},

		save: function () {
			return null;
		}
	} );
} )(
	window.wp.blocks,
	window.wp.editor,
	window.wp.components,
	window.wp.i18n,
	window.wp.element,
	window.wceu2018_social_media_mentions_network_labels,
	window.wceu2018_social_media_mentions_order_strategy_labels
);
