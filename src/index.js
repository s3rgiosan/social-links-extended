/* eslint-disable @wordpress/no-unsafe-wp-apis */
/**
 * WordPress dependencies
 */
import { registerBlockVariation } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { ExternalLink, __experimentalText as Text, PanelBody } from '@wordpress/components';
import { createInterpolateElement } from '@wordpress/element';
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import variations from './variations';

variations.forEach(({ name, title, icon }) => {
	registerBlockVariation('core/social-link', {
		name,
		title,
		icon,
		attributes: { service: name },
		isActive: ['service'],
	});
});

const addInspectorControls = (BlockEdit) => (props) => {
	const { name } = props;

	if (name !== 'core/social-links') {
		return <BlockEdit {...props} />;
	}

	return (
		<>
			<BlockEdit {...props} />
			<InspectorControls group="list">
				<PanelBody>
					<Text as="span" variant="muted">
						{createInterpolateElement(
							__(
								'Missing a social icon? <a>Request it here</a>',
								'social-links-extended',
							),
							{
								a: (
									<ExternalLink href="https://github.com/s3rgiosan/social-links-extended/issues" />
								),
							},
						)}
					</Text>
				</PanelBody>
			</InspectorControls>
		</>
	);
};

addFilter('editor.BlockEdit', 'socialLinksExtended/addInspectorControls', addInspectorControls);
