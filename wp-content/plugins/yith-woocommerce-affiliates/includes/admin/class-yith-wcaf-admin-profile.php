<?php
/**
 * Add extra profile fields for users in admin
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Admin_Profile' ) ) {
	/**
	 * Class that manages extra fields on user profile.
	 */
	class YITH_WCAF_Admin_Profile {

		/**
		 * User being processed
		 *
		 * @var WP_User
		 */
		protected static $user = null;

		/**
		 * Affiliate being processed
		 *
		 * @var YITH_WCAF_Affiliate
		 */
		protected static $affiliate = null;

		/**
		 * Init method.
		 *
		 * @since 2.0.0
		 */
		public static function init() {
			add_action( 'show_user_profile', array( static::class, 'print_profile_fields' ), 20 );
			add_action( 'edit_user_profile', array( static::class, 'print_profile_fields' ), 20 );
			add_action( 'profile_update', array( static::class, 'save_profile_fields' ) );

			// save gateway fields.
			add_action( 'yith_wcaf_after_save_profile_fields', array( self::class, 'save_gateway_specific_fields' ), 10, 2 );

			// update fields status.
			add_action( 'update_option_woocommerce_registration_generate_username', array( self::class, 'update_profile_after_option' ), 10, 3 );
			add_action( 'update_option_woocommerce_registration_generate_password', array( self::class, 'update_profile_after_option' ), 10, 3 );
			add_action( 'update_option_woocommerce_registration_privacy_policy_text', array( self::class, 'update_profile_after_option' ), 10, 3 );
			add_action( 'update_option_wp_page_for_privacy_policy', array( self::class, 'update_profile_after_option' ), 10, 3 );
		}

		/**
		 * Get additional fields for user profile.
		 *
		 * @return array Fields to display which are filtered through yith_wcaf_affiliate_meta_fields before being returned
		 */
		public static function get_profile_fields() {
			/**
			 * APPLY_FILTERS: yith_wcaf_profile_fields
			 *
			 * Filters the additional fields in the user profile.
			 *
			 * @param array $fields Profile fields.
			 */
			$show_fields = apply_filters(
				'yith_wcaf_profile_fields',
				array_merge(
					array(
						'affiliate_details' => array(
							'title'  => _x( 'Affiliate Details', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
							'fields' => array(
								'affiliate'      => array(
									'label'       => _x( 'Affiliate', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'type'        => 'checkbox',
									'description' => _x( 'Check if this user is an affiliate.', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
								),
								'enabled'        => array(
									'label'       => _x( 'Status', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'type'        => 'select',
									'class'       => 'wc-enhanced-select',
									'description' => _x( 'If this user is an affiliate, you can choose to enable or disable it.', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'options'     => self::get_statuses_options(),
								),
								'reject_message' => array(
									'label'       => _x( 'Rejection message', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'type'        => 'textarea',
									'description' => _x( 'Optionally, you can show the affiliate a message explaining why his/her account was rejected.', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'deps'        => array(
										'id'    => 'yith_wcaf_affiliate_meta_enabled',
										'value' => '-1',
									),
								),
								'ban_message'    => array(
									'label'       => _x( 'Ban message', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'type'        => 'textarea',
									'description' => _x( 'Optionally, you can show the affiliate a message explaining why his/her account was banned.', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'deps'        => array(
										'id'    => 'yith_wcaf_affiliate_meta_enabled',
										'value' => 'ban',
									),
								),
								'token'          => array(
									'label'       => _x( 'Token', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'description' => _x( 'Token for the user (default to user ID).', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
								),
								'rate'           => array(
									'label'             => _x( 'Rate', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'type'              => 'number',
									'class'             => 'rate-field',
									'description'       => _x( 'User-specific rate to apply, if any (general rates will be applied if left empty).', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ),
									'step'              => '0.01',
									'min'               => '0',
									/**
									 * APPLY_FILTERS: yith_wcaf_max_rate_value
									 *
									 * Filters the maximum rate value.
									 *
									 * @param int $max_rate_value Maximum rate value.
									 */
									'max'               => apply_filters( 'yith_wcaf_max_rate_value', 100 ),
									'custom_attributes' => array(
										'data-postfix' => '%',
									),
								),
							),
						),
					),
					static::get_gateway_profile_fields()
				)
			);

			return $show_fields;
		}

		/**
		 * Returns additional fields for active payment gateways.
		 *
		 * @return array Fields for active gateways.
		 */
		protected static function get_gateway_profile_fields() {
			$gateway_fields     = array();
			$available_gateways = YITH_WCAF_Gateways::get_gateways();

			if ( ! YITH_WCAF_Gateways::is_valid_gateway( 'paypal' ) ) {
				$gateway_fields = array(
					'affiliate_payment_info' => array(
						'title'  => _x( 'Affiliate payment information', '[ADMIN] Affiliate profile form', 'yith-woocommerce-affiliates' ),
						'fields' => array(
							'payment_email' => array(
								'label'       => _x( 'Payment email', '[ADMIN] Affiliate profile form', 'yith-woocommerce-affiliates' ),
								'description' => _x( 'Email address for the account where the affiliate wants to receive the payments.', '[ADMIN] Affiliate profile form', 'yith-woocommerce-affiliates' ),
								'type'        => 'email',
							),
						),
					),
				);
			}

			if ( empty( $available_gateways ) ) {
				return $gateway_fields;
			}

			foreach ( $available_gateways as $gateway_id => $gateway ) {
				if ( ! $gateway->has_fields() ) {
					continue;
				}

				$fields = array();

				foreach ( $gateway->get_fields() as $field_id => $field ) {
					$fields[ "{$gateway_id}[$field_id]" ] = $field;
				}

				$gateway_fields[ "affiliate_{$gateway_id}_info" ] = array(
					// translators: 1. Gateway name.
					'title'  => sprintf( _x( 'Affiliate %s information', '[ADMIN] Affiliate profile form', 'yith-woocommerce-affiliates' ), $gateway->get_name() ),
					'fields' => $fields,
				);
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_gateway_profile_fields
			 *
			 * Filters the additional gateway fields in the user profile.
			 *
			 * @param array $gateway_fields Gateway fields.
			 */
			return apply_filters( 'yith_wcaf_gateway_profile_fields', $gateway_fields );
		}

		/**
		 * Returns a list of options for the status select
		 *
		 * NOTE: returned values include also "Banned" that usually is a separate value.
		 * If set to this "status", banned flag will be enabled, and status will be set to Accepted.
		 *
		 * @return array array of options for the status select.
		 */
		protected static function get_statuses_options() {
			$statuses = wp_list_pluck( YITH_WCAF_Affiliates::get_available_statuses(), 'name' );

			uksort(
				$statuses,
				function ( $i, $k ) {
					if ( 0 === $i ) {
						return - 1;
					} elseif ( 0 === $k ) {
						return 1;
					} else {
						return $k - $i;
					}
				}
			);

			$statuses['ban'] = _x( 'Banned', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' );

			return $statuses;
		}

		/**
		 * Print profile
		 *
		 * @param string  $mode       Choose what to print (fields/details).
		 * @param WP_User $user       User object.
		 * @param array   $sets       Array of fieldsets of options to print; leave empty to print all.
		 * @param bool    $show_title Whether to show fieldset titles or not.
		 *
		 * @return void
		 */
		public static function print_profile( $mode, $user, $sets = false, $show_title = true ) {
			$callback = false;

			if ( 'fields' === $mode ) {
				$callback = 'print_profile_fields_fieldset';
			} elseif ( 'details' === $mode ) {
				$callback = 'print_profile_details_fieldset';
			}

			if ( ! $callback ) {
				return;
			}

			$show_fields = array_keys( static::get_profile_fields() );

			if ( empty( $sets ) ) {
				$sets = $show_fields;
			} else {
				$sets = (array) $sets;
			}

			foreach ( $sets as $set ) {
				if ( ! in_array( $set, $show_fields, true ) ) {
					continue;
				}

				self::$callback( $user, $set, $show_title );
			}
		}

		/**
		 * Print additional fields on user profile.
		 *
		 * @param WP_User $user       User object.
		 * @param array   $sets       Array of fieldsets of options to print; leave empty to print all.
		 * @param bool    $show_title Whether to show fieldset titles or not.
		 *
		 * @eturn void
		 */
		public static function print_profile_fields( $user, $sets = false, $show_title = true ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_current_user_can_view_profile_fields
			 *
			 * Filters whether the current user can view profile fields.
			 *
			 * @param bool $can_view Whether the current user can view profile fields or not.
			 * @param int  $user_id  User id.
			 */
			if ( ! apply_filters( 'yith_wcaf_current_user_can_view_profile_fields', YITH_WCAF_Admin()->current_user_can_manage_panel(), $user->ID ) ) {
				return;
			}

			self::print_profile( 'fields', $user, $sets, $show_title );
		}

		/**
		 * Print additional details on user profile.
		 *
		 * @param WP_User $user       User object.
		 * @param array   $sets       Array of fieldsets of options to print; leave empty to print all.
		 * @param bool    $show_title Whether to show fieldset titles or not.
		 *
		 * @eturn void
		 */
		public static function print_profile_details( $user, $sets = false, $show_title = true ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_current_user_can_view_profile_details
			 *
			 * Filters whether the current user can view profile details.
			 *
			 * @param bool $can_view Whether the current user can view profile details or not.
			 * @param int  $user_id  User id.
			 */
			if ( ! apply_filters( 'yith_wcaf_current_user_can_view_profile_details', YITH_WCAF_Admin()->current_user_can_manage_panel(), $user->ID ) ) {
				return;
			}

			self::print_profile( 'details', $user, $sets, $show_title );
		}

		/**
		 * Prints one set of additional affiliate fields
		 *
		 * @param WP_User $user         User object.
		 * @param string  $fieldset_key Set key.
		 * @param bool    $show_title   Whether to show fieldset titles or not.
		 */
		protected static function print_profile_fields_fieldset( $user, $fieldset_key, $show_title = true ) {
			self::$user      = $user;
			self::$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $user->ID );

			$show_fields = static::get_profile_fields();

			if ( ! array_key_exists( $fieldset_key, $show_fields ) ) {
				return;
			}

			$fieldset = $show_fields[ $fieldset_key ];
			?>

			<?php if ( $show_title ) : ?>
				<hr/>
				<h2><?php echo esc_html( $fieldset['title'] ); ?></h2>
			<?php endif; ?>

			<table class="form-table" id="<?php echo esc_attr( 'fieldset-' . $fieldset_key ); ?>">
				<?php foreach ( $fieldset['fields'] as $key => $field ) : ?>
					<?php
					$field = static::parse_field( $key, $field );
					$deps  = yith_field_deps_data( $field );

					if ( ! self::should_print_profile_field( $key, $field, 'edit' ) ) {
						continue;
					}

					list( $type, $label, $admin_label, $description ) = yith_plugin_fw_extract( $field, 'type', 'label', 'admin_label', 'description' );

					$admin_label = $admin_label ? $admin_label : $label;
					?>
					<tr <?php echo wp_kses_post( $deps ); ?> >
						<th>
							<?php if ( 'checkbox' !== $type ) : ?>
								<label for="<?php echo esc_attr( $field['id'] ); ?>">
							<?php endif; ?>
							<?php echo esc_html( wp_strip_all_tags( $admin_label ) ); ?>
							<?php if ( 'checkbox' !== $type ) : ?>
								</label>
							<?php endif; ?>
						</th>
						<td>
							<div id="<?php echo esc_attr( $field['id'] ); ?>-container">
								<?php yith_plugin_fw_get_field( $field, 1 ); ?>

								<?php if ( 'checkbox' !== $type && $description ) : ?>
									<p class="description"><?php echo wp_kses_post( $description ); ?></p>
								<?php endif; ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php
		}

		/**
		 * Prints label/value info for a specific fieldset
		 *
		 * @param WP_User $user         User object.
		 * @param string  $fieldset_key Set key.
		 * @param bool    $show_title   Whether to show fieldset titles or not.
		 */
		protected static function print_profile_details_fieldset( $user, $fieldset_key, $show_title = true ) {
			self::$user      = $user;
			self::$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $user->ID );

			$show_fields = static::get_profile_fields();

			if ( ! array_key_exists( $fieldset_key, $show_fields ) ) {
				return;
			}

			$fieldset = $show_fields[ $fieldset_key ];
			?>

			<?php if ( $show_title ) : ?>
				<hr/>
				<h2><?php echo esc_html( $fieldset['title'] ); ?></h2>
			<?php endif; ?>

			<div class="form-table" id="<?php echo esc_attr( 'fieldset-' . $fieldset_key . '-details' ); ?>">
				<?php foreach ( $fieldset['fields'] as $key => $field ) : ?>
					<?php
					$field = static::parse_field( $key, $field, 'view' );

					if ( ! self::should_print_profile_field( $key, $field, 'view' ) ) {
						continue;
					}

					list( $label, $admin_label, $value, $class ) = yith_plugin_fw_extract( $field, 'label', 'admin_label', 'value', 'class' );

					$admin_label = $admin_label ? $admin_label : $label;
					?>
					<p class="form-row <?php echo esc_attr( $class ); ?>">
						<b class="label">
							<?php echo esc_html( wp_strip_all_tags( $admin_label ) ); ?>
						</b>
						<span class="value">
							<?php echo $value ? wp_kses_post( $value ) : '-'; ?>
						</span>
					</p>
				<?php endforeach; ?>
			</div>
			<?php
		}

		/**
		 * Retrieve the value for a specific field
		 *
		 * @param string $key     Key of the field.
		 * @param array  $field   Field to parse.
		 * @param string $context Context of the operation.
		 *
		 * @return mixed Value for the profile field
		 */
		protected static function get_field_value( $key, $field, $context = 'edit' ) {
			$user      = self::$user;
			$affiliate = self::$affiliate;

			if ( ! $user ) {
				if ( 'view' === $context ) {
					return '-';
				}

				return false;
			}

			// get field value.
			if ( ! $affiliate ) {
				$value = get_user_meta( $user->ID, "_yith_wcaf_{$key}", true );
			} elseif ( 'affiliate' === $key ) {
				$value = (bool) $affiliate->get_id();
			} elseif ( 'enabled' === $key ) {
				$banned = $affiliate->is_banned();
				$value  = $banned ? 'ban' : $affiliate->get_enabled();
			} elseif ( 'rate' === $key ) {
				$value = yith_wcaf_get_rate( $affiliate );
			} elseif ( method_exists( $affiliate, "get_{$key}" ) ) {
				$value = $affiliate->{"get_{$key}"}( $context );
			} elseif ( class_exists( 'YITH_WCAF_Gateways' ) && YITH_WCAF_Gateways::is_valid_gateway( $key ) ) {
				$child_key = strtok( '[]' );
				$value     = $affiliate->get_gateway_preference( $key, $child_key );
			} else {
				$value = $affiliate->get_meta( $key );
			}

			// format value when in view mode and field require formatting.
			if ( 'view' === $context ) {
				// get field details.
				list( $type, $options ) = yith_plugin_fw_extract( $field, 'type', 'options' );

				switch ( $type ) {
					case 'select':
					case 'radio':
						if ( $options && isset( $options[ $value ] ) ) {
							$value = $options[ $value ];
							break;
						}

						$value = '-';

						break;
					case 'checkbox':
						if ( '' === $value ) {
							$value = _x( 'N/A', '[ADMIN] Profile fields checkbox values', 'yith-woocommerce-affiliates' );
						} else {
							$value = ! ! $value ? _x( 'Accepted', '[ADMIN] Profile fields checkbox values', 'yith-woocommerce-affiliates' ) : _x( 'Rejected', '[ADMIN] Profile fields checkbox values', 'yith-woocommerce-affiliates' );
						}
						break;
				}
			}

			return $value;
		}

		/**
		 * Checks if we should print a specific field
		 *
		 * @param string $key     Key of the field.
		 * @param array  $field   Field to parse.
		 * @param string $context Context of the operation.
		 *
		 * @return bool Whether we should print the field of nor.
		 */
		protected static function should_print_profile_field( $key, $field, $context = 'edit' ) {
			$should_print = true;

			if ( 'edit' === $context && 'terms' === $key ) {
				$should_print = false;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_should_print_admin_profile_field
			 *
			 * Filters whether a specific field should be printed in the user profile.
			 *
			 * @param bool   $should_print Whether a specific field should be printed or not.
			 * @param string $key          Key of the field.
			 * @param array  $field        Field to parse.
			 * @param string $context      Context of the operation.
			 */
			return apply_filters( 'yith_wcaf_should_print_admin_profile_field', $should_print, $key, $field, $context );
		}

		/**
		 * Parse a field to produce an array that can be used in the profile
		 *
		 * @param string $key     Key of the field.
		 * @param array  $field   Field to parse.
		 * @param string $context Context of the operation.
		 *
		 * @return array Parsed field.
		 */
		protected static function parse_field( $key, $field, $context = 'edit' ) {
			$base_key = strtok( $key, '[]' );
			$value    = self::get_field_value( $base_key, $field, $context );

			// allow third party code customize field.
			/**
			 * APPLY_FILTERS: yith_wcaf_admin_profile_field
			 *
			 * Filters the field in the user profile.
			 *
			 * @param array               $field     Field to parse.
			 * @param string              $key       Key of the field.
			 * @param string              $value     Value of the field.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param WP_User             $user      User object.
			 */
			$field = apply_filters( 'yith_wcaf_admin_profile_field', $field, $key, $value, self::$affiliate, self::$user );

			// get field details.
			list( $type, $description, $options, $data ) = yith_plugin_fw_extract( $field, 'type', 'description', 'options', 'data' );

			// set field type and type-specific attributes.
			$type = ! empty( $type ) ? $type : 'text';

			if ( in_array( $type, array( 'textarea', 'radio', 'datepicker', 'text', 'number' ), true ) ) {
				$field['type'] = $type;
			} elseif ( 'date' === $type ) {
				$field['type'] = 'datepicker';
			} elseif ( 'country' === $type ) {
				$field['type']    = 'select';
				$field['class']   = 'js_field-country';
				$field['options'] = array( '' => _x( 'Select a country / region&hellip;', '[ADMIN] User profile.', 'yith-woocommerce-affiliates' ) ) + WC()->countries->get_allowed_countries();
			} elseif ( 'state' === $type ) {
				$field['type']  = 'text';
				$field['class'] = 'js_field-state';
			} elseif ( 'checkbox' === $type ) {
				$raw_value = 'edit' === $value ? $value : self::get_field_value( $base_key, $field );

				$field['type']        = 'onoff';
				$field['desc-inline'] = $description ?? $field['label'];
				$field['class']       = yith_plugin_fw_is_true( $raw_value ) ? 'accepted-condition' : 'rejected-condition';
			} elseif ( 'select' === $type ) {
				$field['type'] = $type;

				if ( empty( $options ) ) {
					$field['options'] = array();
				}
			} else {
				$field['type'] = 'text';
			}

			// set up id and name.
			$field['id']   = "yith_wcaf_affiliate_meta_$key";
			$field['name'] = preg_replace( '/([^[]*)/', 'yith_wcaf_affiliate_meta[$1]', $key, 1 ); // wrap between [] only first part of the name, on nested fields.

			// set up value.
			$field['value'] = $value;

			// set up data attributes.
			$data_attributes = array();

			if ( ! empty( $data ) ) {
				foreach ( $data as $data_key => $data_value ) {
					$data_attributes[ 'data-' . $data_key ] = esc_attr( $data_value );
				}

				$field['custom_attributes'] = array_merge(
					! empty( $field['custom_attributes'] ) ? $field['custom_attributes'] : array(),
					$data_attributes
				);
			}

			return $field;
		}

		/**
		 * Save additional fields submitted with user profile.
		 *
		 * @param int   $user_id User ID of the user being saved.
		 * @param array $sets    Array of fieldsets of options to print; leave empty to print all.
		 *
		 * @return void
		 */
		public static function save_profile_fields( $user_id, $sets = false ) {
			/**
			 * APPLY_FILTERS: yith_wcaf_current_user_can_edit_profile_fields
			 *
			 * Filters whether the current user can edit profile fields.
			 *
			 * @param bool $can_edit Whether the current user can edit profile fields or not.
			 * @param int  $user_id  User id.
			 */
			if ( ! apply_filters( 'yith_wcaf_current_user_can_edit_profile_fields', YITH_WCAF_Admin()->current_user_can_manage_panel(), $user_id ) ) {
				return;
			}

			if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'update-user_' . $user_id ) ) {
				return;
			}

			$affiliate       = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $user_id );
			self::$user      = get_userdata( $user_id );
			self::$affiliate = $affiliate;

			/**
			 * DO_ACTION: yith_wcaf_before_save_profile_fields
			 *
			 * Allows to trigger some action before saving the fields in the user profile.
			 *
			 * @param int                 $user_id   User id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param array               $sets      Array of fieldsets of options to print; leave empty to print all.
			 */
			do_action( 'yith_wcaf_before_save_profile_fields', $user_id, $affiliate, $sets );

			// checks if user should be an affiliate.
			$is_affiliate = isset( $_POST['yith_wcaf_affiliate_meta']['affiliate'] );

			// delete affiliate and exit if option in unchecked.
			if ( ! $is_affiliate && $affiliate ) {
				$affiliate->delete();

				return;
			}

			// create affiliate if it doesn't exists.
			if ( $is_affiliate && ! $affiliate ) {
				$affiliate = new YITH_WCAF_Affiliate();
				$affiliate->set_user_id( $user_id );
				$affiliate->save();
			}

			// if user isn't an affiliate, we don't need to proceed further.
			if ( ! $affiliate ) {
				return;
			}

			// update affiliate object.
			$save_fields = array_keys( static::get_profile_fields() );

			if ( empty( $sets ) ) {
				$sets = $save_fields;
			} else {
				$sets = (array) $sets;
			}

			foreach ( $save_fields as $fieldset_key ) {
				if ( ! in_array( $fieldset_key, $sets, true ) ) {
					continue;
				}

				self::save_profile_fields_fieldset( $user_id, $fieldset_key );
			}

			/**
			 * DO_ACTION: yith_wcaf_after_save_profile_fields
			 *
			 * Allows to trigger some action after saving the fields in the user profile.
			 *
			 * @param int                 $user_id   User id.
			 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
			 * @param array               $sets      Array of fieldsets of options to print; leave empty to print all.
			 */
			do_action( 'yith_wcaf_after_save_profile_fields', $user_id, $affiliate, $sets );

			/**
			 * Make sure to register role even if we're updating customer, since default WP handling would overwrite it
			 * with anything submitted by "Role" select
			 *
			 * This is placed here, instead of directly inside \YITH_WCAF_Affiliate_Data_Store::update, since most updates
			 * of the affiliate won't require to register role again, while this procedure will always require this action
			 * to be performed.
			 * On the opposite side, \YITH_WCAF_Affiliate_Data_Store::create executes \YITH_WCAF_Affiliate_Data_Store::add_role,
			 * since any addition of affiliate will also require the role to be registered for the user
			 *
			 * @since 1.7.4
			 */
			$data_store = $affiliate->get_data_store();

			if ( $data_store ) {
				$data_store->add_role( $affiliate );
			}
		}

		/**
		 * Save gateway fields in the user profile
		 *
		 * @param int                 $user_id Id of the user being saved.
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
		 */
		public static function save_gateway_specific_fields( $user_id, $affiliate ) {
			if ( ! $affiliate ) {
				return;
			}

			$available_gateways = YITH_WCAF_Gateways::get_gateways();

			if ( empty( $available_gateways ) ) {
				return;
			}

			foreach ( $available_gateways as $gateway_id => $gateway ) {
				if ( ! $gateway->has_fields() ) {
					continue;
				}

				// nonce is already verified in \YITH_WCAF_Admin_Profile::save_profile_fields.
				// sanitization will be applied in \YITH_WCAF_Abstract_Gateway::validate_fields.
				// phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput
				$posted_data = isset( $_POST['yith_wcaf_affiliate_meta'][ $gateway_id ] ) ? $_POST['yith_wcaf_affiliate_meta'][ $gateway_id ] : false;

				if ( ! $posted_data ) {
					continue;
				}

				$affiliate->set_gateway_preferences( $gateway_id, $posted_data );
			}

			$affiliate->save();
		}

		/**
		 * Save additional fields submitted with user profile.
		 *
		 * @param int    $user_id      User ID of the user being saved.
		 * @param string $fieldset_key Set key.
		 *
		 * @return void
		 */
		protected static function save_profile_fields_fieldset( $user_id, $fieldset_key ) {
			$affiliate = YITH_WCAF_Affiliate_Factory::get_affiliate_by_user_id( $user_id );

			// if user isn't an affiliate, we don't need to proceed further.
			if ( ! $affiliate ) {
				return;
			}

			$save_fields = static::get_profile_fields();

			// if fieldset doesn't exist, we don't need to proceed further.
			if ( ! array_key_exists( $fieldset_key, $save_fields ) ) {
				return;
			}

			// nonce verification was already performed in here wp-content/plugins/yith-woocommerce-affiliates-premium/includes/admin/class-yith-wcaf-admin-profile.php:262.
			$posted   = isset( $_POST['yith_wcaf_affiliate_meta'] ) ? $_POST['yith_wcaf_affiliate_meta'] : false; // phpcs:disable WordPress.Security
			$fieldset = $save_fields[ $fieldset_key ];

			try {
				$parsed = yith_wcaf_parse_settings( $posted, $fieldset['fields'], YITH_WCAF_PARSE_SETTINGS_IGNORE_REQUIRED );
			} catch ( Exception $e ) {
				return;
			}

			foreach ( $fieldset['fields'] as $key => $field ) {
				$value = isset( $parsed[ $key ] ) ? $parsed[ $key ] : false;

				if ( 'affiliate' === $key ) {
					continue;
				} elseif ( 'enabled' === $key ) {
					$banned = 'ban' === $value;
					$status = $banned ? 1 : $value;

					$affiliate->set_banned( $banned );

					if ( ! $banned ) {
						$affiliate->set_enabled( $status );
					}

					continue;
				} elseif ( 'rate' === $key && class_exists( 'YITH_WCAF_Rate_Handler_Premium' ) ) {
					$rule = YITH_WCAF_Rate_Handler_Premium::get_best_rule_matching( $affiliate );

					if ( $rule && 'affiliate_ids' === $rule->get_type() && 1 === count( $rule->get_affiliate_ids() ) ) {
						$rule->set_rate( $value );
						$rule->save();

						continue;
					}
				} elseif ( 'token' === $key && ! $value ) {
					continue;
				} elseif ( ! self::should_print_profile_field( $key, $field, 'edit' ) ) {
					continue;
				}

				if ( method_exists( $affiliate, "set_{$key}" ) ) {
					$affiliate->{"set_{$key}"}( $value );
				} elseif ( $value ) {
					$affiliate->update_meta_data( $key, $value );
				} else {
					$affiliate->delete_meta_data( $key );
				}
			}

			$affiliate->save();
		}

		/**
		 * Update status of a field after value of an option
		 *
		 * @param mixed  $old_value Previous option value.
		 * @param mixed  $new_value Current option value.
		 * @param string $option    Option name.
		 */
		public static function update_profile_after_option( $old_value, $new_value, $option ) {
			$field_name = false;
			$force      = false;
			$property   = 'enabled';
			$value      = yith_plugin_fw_is_true( $new_value );

			if ( 'woocommerce_registration_generate_username' === $option ) {
				$field_name = 'username';
				$value      = ! $value;
				$force      = true;
			} elseif ( 'woocommerce_registration_generate_password' === $option ) {
				$field_name = 'password';
				$value      = ! $value;
				$force      = true;
			} elseif ( 'woocommerce_registration_privacy_policy_text' === $option ) {
				$field_name = 'privacy_text';
				$property   = 'label';
				$value      = $new_value;
			} elseif ( 'wp_page_for_privacy_policy' === $option ) {
				$field_name = 'privacy_text';
				$value      = ! ! $new_value;
				$force      = true;
			}

			if ( ! $field_name ) {
				return;
			}

			YITH_WCAF_Affiliates_Profile::update_field_property( $field_name, $property, $value, $force );
		}
	}
}
