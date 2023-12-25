/**
 * External dependencies
 */
import { _x } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

/**
 * Internal dependencies
 */
import Block from './block';

export const Edit = ( { attributes } ) => {
	const { referrer, className } = attributes;
	const blockProps = useBlockProps();
	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody
					title={ _x(
						'Block options',
						'[BUILDERS] Shortcode attributes',
						'yith-woocommerce-affiliates'
					) }
				>
					<TextControl
						label={ _x(
							'Initial affiliate token to show',
							'[BUILDERS] Shortcode attributes',
							'yith-woocommerce-affiliates'
						) }
						type="search"
						value={ referrer }
					/>
				</PanelBody>
			</InspectorControls>
			<Block className={ className } referrer={ referrer } />
		</div>
	);
};

export const Save = () => {
	return <div { ...useBlockProps.save() } />;
};
