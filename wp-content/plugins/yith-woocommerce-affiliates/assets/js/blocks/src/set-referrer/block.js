/**
 * External dependencies
 */
import { _x } from '@wordpress/i18n';
import { applyFilters } from '@wordpress/hooks';
import { useState } from '@wordpress/element';
import { useDispatch } from '@wordpress/data';
import { withInstanceId } from '@wordpress/compose';
import { Button } from '@wordpress/components';
import {
	ValidatedTextInput,
	TotalsWrapper,
} from '@woocommerce/blocks-checkout';

/**
 * Internal dependencies
 */
import { $document } from '../../../src/globals';
import YITH_WCAF_Ajax from '../../../src/modules/ajax';

const Block = ( {
	instanceId,
	className,
	defaultReferrer,
	displayReferrerForm,
} ) => {
	const { createNotice } = useDispatch( 'core/notices' );
	const [ referrer, setReferrer ] = useState( defaultReferrer );
	const [ isLoading, setIsLoading ] = useState( false );
	const [ isReferrerFormHidden, setIsReferrerFormHidden ] = useState(
		! displayReferrerForm
	);
	const textInputId = `yith-block-components-set-referrer__input-${ instanceId }`;
	const formWrapperClass = `yith-block-components-set-referrer__content ${
		isReferrerFormHidden ? 'screen-reader-text' : ''
	}`;
	const handleReferrerAnchorClick = ( e ) => {
		e.preventDefault();
		setIsReferrerFormHidden( false );
	};
	const handleReferrerSubmit = ( e ) => {
		e.preventDefault();
		setIsLoading( true );

		YITH_WCAF_Ajax.post
			.call( null, 'set_referrer', 'set_referrer', {
				referrer,
			} )
			.done( ( data ) => {
				setIsLoading( false );

				if ( data?.success ) {
					setReferrer( referrer );
					setIsReferrerFormHidden( true );

					if ( data?.data?.message ) {
						createNotice( 'info', data?.data?.message, {
							id: 'coupon-form',
							type: 'snackbar',
							context: 'wc/checkout',
						} );
					}

					$document.trigger( 'yith_wcaf_referrer_set' );
				}
			} );
	};

	const label = applyFilters(
		'yith_wcaf_set_referrer_message',
		_x(
			'Did anyone suggest our site to you?',
			'[FRONTEND] Set referrer shortcode',
			'yith-woocommerce-affiliates'
		)
	);

	return (
		<TotalsWrapper className={ className }>
			<div className="yith-block-components-set-referrer">
				{ isReferrerFormHidden ? (
					<a
						role="button"
						href="#yith-block-components-set-referrer__form"
						className="yith-block-components-set-referrer-link"
						aria-label={ label }
						onClick={ handleReferrerAnchorClick }
					>
						{ label }
					</a>
				) : (
					<div className={ formWrapperClass }>
						<form
							className="yith-block-components-set-referrer__form"
							id="yith-block-components-set-referrer__form"
						>
							<ValidatedTextInput
								id={ textInputId }
								errorId="coupon"
								className="yith-block-components-set-referrer__input"
								label={ _x(
									'Affiliate code',
									'[FRONTEND] Set referrer shortcode',
									'yith-woocommerce-affiliates'
								) }
								value={ referrer }
								onChange={ ( newReferrer ) => {
									setReferrer( newReferrer );
								} }
								focusOnMount={ true }
								validateOnMount={ false }
								showError={ false }
							/>
							<Button
								className="yith-block-components-set-referrer__button wp-element-button"
								disabled={ isLoading || ! referrer }
								onClick={ handleReferrerSubmit }
								type="submit"
							>
								{ _x(
									'Set affiliate',
									'[FRONTEND] Set referrer shortcode',
									'yith-woocommerce-affiliates'
								) }
							</Button>
						</form>
					</div>
				) }
			</div>
		</TotalsWrapper>
	);
};

export default withInstanceId( Block );
