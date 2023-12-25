/**
 * External dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import { Edit, Save } from './edit';
import metadata from './block.json';
import { yith_icon } from '../../../../../plugin-fw/includes/builders/gutenberg/src/common';

registerBlockType( metadata, {
	icon: {
		src: yith_icon,
	},
	edit: Edit,
	save: Save,
} );
