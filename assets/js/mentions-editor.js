( function ( blocks, editor, components, i18n, element ) {

	var el = element.createElement;
	var __ = i18n.__;

	var networkOptions = [
		{ value: 'twitter', label: __( 'Twitter' ) },
		{ value: 'wordpress', label: __( 'WordPress' ) }
	];

	blocks.registerBlockType( 'wceu2018/mentions', {
		title: __( 'Social Media Mentions' ),
		category: 'widgets',
		icon: 'format-chat',
		supports: { html: false },

		attributes: {
			network: {
				type: 'text',
				default: 'twitter'
			},
			mention: {
				type: 'text',
				default: '#WCEU'
			},
			limit: {
				type: 'integer',
				default: 5
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
							options: networkOptions,
							value: props.attributes.limit,
							min: 1,
							max: 20,
							onChange: function ( value ) {
								props.setAttributes(
									{ limit: value }
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
	window.wp.element
);
