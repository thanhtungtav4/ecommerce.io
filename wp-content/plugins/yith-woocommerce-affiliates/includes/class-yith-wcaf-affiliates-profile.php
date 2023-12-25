<?php
/**
 * Static class that offers methods to handle, retrieve and update affiliates' profile fields
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Affiliates\Classes
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCAF' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_Affiliates_Profile' ) ) {
	/**
	 * Affiliates Profile
	 *
	 * @since 2.0.0
	 */
	class YITH_WCAF_Affiliates_Profile {

		/**
		 * An array of fields defined for affiliates' profile
		 *
		 * @var array
		 */
		protected static $profile_fields = array();

		/**
		 * Init profile handling
		 */
		public static function init() {
			// show fields.
			add_action( 'woocommerce_register_form', array( self::class, 'show_fields' ) );
			add_action( 'yith_wcaf_register_form', array( self::class, 'show_fields' ) );
			add_action( 'yith_wcaf_become_an_affiliate_form', array( self::class, 'show_fields' ) );
			add_action( 'yith_wcaf_settings_form_start', array( self::class, 'show_fields' ) );
		}

		/* === HELPER METHODS === */

		/**
		 * Returns array of supported field types
		 *
		 * @return array Supported field types
		 */
		public static function get_supported_field_types() {
			/**
			 * APPLY_FILTERS: yith_wcaf_affiliates_profile_supported_field_types
			 *
			 * Filters the supported field types.
			 *
			 * @param array $field_types Supported field types.
			 */
			return apply_filters(
				'yith_wcaf_affiliates_profile_supported_field_types',
				array(
					'text'     => esc_attr_x( 'Text', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'email'    => esc_attr_x( 'Email', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'password' => esc_attr_x( 'Password', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'tel'      => esc_attr_x( 'Phone', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'textarea' => esc_attr_x( 'Textarea', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'radio'    => esc_attr_x( 'Radio button', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'checkbox' => esc_attr_x( 'Checkbox', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'select'   => esc_attr_x( 'Select', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'country'  => esc_attr_x( 'Country', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'state'    => esc_attr_x( 'State', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'date'     => esc_attr_x( 'Date', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
				)
			);
		}

		/**
		 * Returns array of supported field validations
		 *
		 * @return array Supported field validations
		 */
		public static function get_supported_field_validations() {
			/**
			 * APPLY_FILTERS: yith_wcaf_affiliates_profile_supported_field_validations
			 *
			 * Filters the supported field validations.
			 *
			 * @param array $field_validations Supported field validations.
			 */
			return apply_filters(
				'yith_wcaf_affiliates_profile_supported_field_validations',
				array(
					'text'  => esc_attr_x( 'Plain text', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'email' => esc_attr_x( 'Email', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'tel'   => esc_attr_x( 'Phone', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'url'   => esc_attr_x( 'URL', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
				)
			);
		}

		/**
		 * Returns array of supported locations where to show the field
		 *
		 * @return array Supported field locations
		 */
		public static function get_supported_show_locations() {
			/**
			 * APPLY_FILTERS: yith_wcaf_affiliates_profile_supported_show_locations
			 *
			 * Filters the supported field locations.
			 *
			 * @param array $field_locations Supported field locations.
			 */
			return apply_filters(
				'yith_wcaf_affiliates_profile_supported_show_locations',
				array(
					'settings'            => esc_html_x( 'Show also in the Affiliate Dashboard', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
					'become_an_affiliate' => esc_html_x( 'Show also in the Become an Affiliate form', '[ADMIN] Add Affiliate field modal', 'yith-woocommerce-affiliates' ),
				)
			);
		}

		/* === PRINT METHODS === */

		/**
		 * Show affiliate profile fields when necessary
		 *
		 * @param YITH_WCAF_Abstract_Object $item Affiliate object or anything with ->get_affiliate() method; if not provided, current affiliate will be used instead.
		 *
		 * @return void
		 */
		public static function show_fields( $item = false ) {
			if ( ! self::should_show_fields() ) {
				return;
			}

			if ( ! $item ) {
				$affiliate = YITH_WCAF_Affiliate_Factory::get_current_affiliate();
			} elseif ( method_exists( $item, 'get_affiliate' ) ) {
				$affiliate = $item->get_affiliate();
			} elseif ( $item instanceof YITH_WCAF_Affiliate ) {
				$affiliate = $item;
			} else {
				$affiliate = false;
			}

			$fields    = self::get_fields_to_show();
			$affiliate = $affiliate instanceof YITH_WCAF_Affiliate ? $affiliate : YITH_WCAF_Affiliate_Factory::get_current_affiliate();

			if ( empty( $fields ) ) {
				return;
			}

			self::maybe_open_form_container();

			foreach ( $fields as $field_key => $field ) {
				$field_name    = self::get_field_name( $field_key );
				$field['id']   = self::get_field_id( $field_key );
				$field_default = self::get_field_value( $field_key, $affiliate );

				/**
				 * APPLY_FILTERS: yith_wcaf_$field_key_type
				 *
				 * Filters the field type.
				 * <code>$field_key</code> will be replaced with the key for each field.
				 *
				 * @param string $field_type Field type.
				 * @param array  $field      Field.
				 */
				$field['type'] = apply_filters( "yith_wcaf_{$field_key}_type", $field['type'], $field );

				/**
				 * APPLY_FILTERS: yith_wcaf_$field_key_label
				 *
				 * Filters the field label.
				 * <code>$field_key</code> will be replaced with the key for each field.
				 *
				 * @param string $field_label Field label.
				 * @param array  $field       Field.
				 */
				$field['label'] = apply_filters( "yith_wcaf_{$field_key}_label", $field['label'], $field );

				/**
				 * APPLY_FILTERS: yith_wcaf_$field_key_required
				 *
				 * Filters whether the field will be required.
				 * <code>$field_key</code> will be replaced with the key for each field.
				 *
				 * @param bool  $is_field_required Whether the field is required or not.
				 * @param array $field             Field.
				 */
				$field['required'] = apply_filters( "yith_wcaf_{$field_key}_required", $field['required'], $field );

				if ( ! empty( $field['error_message'] ) ) {
					$field['custom_attributes']               = array();
					$field['custom_attributes']['data-error'] = $field['error_message'];
				}

				if ( ! in_array( $field['type'], array_keys( self::get_supported_field_types() ), true ) ) {
					self::maybe_show_paragraph( $field['label'], $field['class'] );
					continue;
				}

				woocommerce_form_field( $field_name, $field, YITH_WCAF_Form_Handler::get_posted_data( $field_name, $field_default ) );
			}

			self::maybe_close_form_container();
		}

		/**
		 * Check if should print affiliate profile fields for current action
		 *
		 * @return bool Whether we should show fields or not
		 */
		public static function should_show_fields() {
			$curren_action = current_action();

			if ( 'woocommerce_register_form' === $curren_action ) {
				return ! YITH_WCAF_Shortcodes::$is_registration_form && yith_plugin_fw_is_true( get_option( 'yith_wcaf_referral_registration_use_wc_form' ) );
			} elseif ( 'yith_wcaf_register_form' === $curren_action ) {
				return true;
			} elseif ( 'yith_wcaf_become_an_affiliate_form' === $curren_action ) {
				return true;
			} elseif ( 'yith_wcaf_settings_form_start' === $curren_action ) {
				return true;
			}

			return false;
		}

		/**
		 * Returns an array of fields to show
		 *
		 * @reutrn array Array of fields to show.
		 */
		public static function get_fields_to_show() {
			$curren_action = current_action();
			$fields        = array();

			if ( 'woocommerce_register_form' === $curren_action ) {
				$fields = self::get_enabled_fields( 'view', array( 'reserved' => false ) );
			} elseif ( 'yith_wcaf_register_form' === $curren_action ) {
				$fields = self::get_enabled_fields( 'view' );
			} elseif ( 'yith_wcaf_become_an_affiliate_form' === $curren_action ) {
				$fields = self::get_become_an_affiliate_fields( 'view' );
			} elseif ( 'yith_wcaf_settings_form_start' === $curren_action ) {
				$fields = self::get_settings_fields( 'view' );
			}

			return $fields;

		}

		/**
		 * Returns ID to use for a specific field
		 *
		 * @param string $field_key Key of the field.
		 * @return string ID to use for the field.
		 */
		public static function get_field_id( $field_key ) {
			return "profile_$field_key";
		}

		/**
		 * Returns name to use for a specific field
		 *
		 * @param string $field_key Key of the field.
		 * @return string Name to use for the field.
		 */
		public static function get_field_name( $field_key ) {
			$current_action = current_action();
			$field_name     = $field_key;

			if ( 'yith_wcaf_settings_form_start' === $current_action ) {
				$field_name = "profile[$field_name]";
			}

			return $field_name;
		}

		/**
		 * Returns value to use for a specific field
		 *
		 * @param string              $field_key Key of the field.
		 * @param YITH_WCAF_Affiliate $affiliate Affiliate object.
		 *
		 * @return mixed Value to use for the field.
		 */
		public static function get_field_value( $field_key, $affiliate = null ) {
			$value = null;

			if ( $affiliate ) {
				$value = $affiliate->get_meta( $field_key );
			}

			if ( ! $value && $affiliate && in_array( $field_key, array( 'first_name', 'last_name' ), true ) ) {
				$user  = $affiliate->get_user();
				$value = $user ? $user->$field_key : $value;
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_$field_key_value
			 *
			 * Filters the field value.
			 * <code>$field_key</code> will be replaced with the key for each field.
			 *
			 * @param string              $field_value Field value.
			 * @param YITH_WCAF_Affiliate $affiliate   Affiliate object.
			 */
			return apply_filters( "yith_wcaf_{$field_key}_value", $value, $affiliate );
		}

		/**
		 * Wrap fields when required
		 */
		public static function maybe_open_form_container() {
			$current_action = current_action();

			if ( 'yith_wcaf_settings_form_start' === $current_action ) :
				?>
				<div class="settings-box">
					<h3><?php echo esc_html_x( 'Profile info', '[FRONTEND] Billing fields form', 'yith-woocommerce-affiliates' ); ?></h3>
				<?php
			endif;
		}

		/**
		 * Closes fields wrap when was previously opened
		 */
		public static function maybe_close_form_container() {
			$current_action = current_action();

			if ( 'yith_wcaf_settings_form_start' === $current_action ) :
				?>
				</div>
				<?php
			endif;
		}

		/**
		 * Show a paragraph of text inside the settings form
		 *
		 * @param string $text    Textual content of the paragraph.
		 * @param array  $classes Optional array of classes to assign to paragraph tag.
		 */
		public static function maybe_show_paragraph( $text, $classes = array() ) {
			if ( empty( $text ) ) {
				return;
			}

			$callbacks = array(
				'wc_replace_policy_page_link_placeholders',
				'do_shortcode',
			);

			foreach ( $callbacks as $callback ) {
				$text = $callback( $text );
			}

			?>
			<p class="form-row">
				<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
					<?php echo wp_kses_post( $text ); ?>
				</span>
			</p>
			<?php
		}

		/* === GETTERS === */

		/**
		 * Returns profile's fields
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Optional array of filters, to narrow down fields.
		 *
		 * @return array Affiliates' profile field.
		 */
		public static function get_fields( $context = 'edit', $args = array() ) {
			$fields = self::maybe_read_profile_fields();

			if ( ! empty( $args ) ) {
				// manage show_in filter.
				if ( ! empty( $args['show_in'] ) ) {
					foreach ( $fields as $field_name => $field ) {
						foreach ( $args['show_in'] as $show_param => $show_value ) {
							if ( isset( $field['show_in'][ $show_param ] ) && $show_value === $field['show_in'][ $show_param ] ) {
								continue;
							}

							unset( $fields[ $field_name ] );
							break;
						}
					}

					unset( $args['show_in'] );
				}

				// apply remaining filters.
				$fields = wp_list_filter( $fields, $args );
			}

			if ( 'view' === $context ) {
				$fields = array_map( array( self::class, 'get_formatted_field' ), $fields );
			}

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_profile_fields
			 *
			 * Filters the fields in the affiliate's profile.
			 *
			 * @param array $fields Fields.
			 */
			return apply_filters( 'yith_wcaf_affiliate_profile_fields', $fields );
		}

		/**
		 * Returns enabled profile's fields
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Optional array of filters, to narrow down fields.
		 *
		 * @return array Affiliates' enabled profile field.
		 */
		public static function get_enabled_fields( $context = 'edit', $args = array() ) {
			$fields = self::get_fields(
				$context,
				array_merge(
					$args,
					array(
						'enabled' => true,
					)
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_enabled_profile_fields
			 *
			 * Filters the enabled fields in the affiliate's profile.
			 *
			 * @param array $fields Enabled fields.
			 * @param array $args   Array with arguments.
			 */
			return apply_filters( 'yith_wcaf_affiliate_enabled_profile_fields', $fields, $args );
		}

		/**
		 * Returns fields to show in Become an Affiliate form
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Array of arguments to filter fields.
		 *
		 * @return array Array of found fields.
		 */
		public static function get_become_an_affiliate_fields( $context = 'edit', $args = array() ) {
			$fields = self::get_enabled_fields(
				$context,
				array_merge(
					$args,
					array(
						'show_in' => array(
							'become_an_affiliate' => true,
						),
					)
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_become_an_affiliate_profile_fields
			 *
			 * Filters the fields to show in the form to become an affiliate.
			 *
			 * @param array $fields Fields.
			 * @param array $args   Array with arguments.
			 */
			return apply_filters( 'yith_wcaf_affiliate_become_an_affiliate_profile_fields', $fields, $args );
		}

		/**
		 * Returns fields to show in Settings form
		 *
		 * @param string $context Context of the operation.
		 * @param array  $args    Array of arguments to filter fields.
		 *
		 * @return array Array of found fields.
		 */
		public static function get_settings_fields( $context = 'edit', $args = array() ) {
			$fields = self::get_enabled_fields(
				$context,
				array_merge(
					$args,
					array(
						'show_in' => array(
							'settings' => true,
						),
					)
				)
			);

			/**
			 * APPLY_FILTERS: yith_wcaf_affiliate_settings_profile_fields
			 *
			 * Filters the fields to show in the settings form.
			 *
			 * @param array $fields Fields.
			 * @param array $args   Array with arguments.
			 */
			return apply_filters( 'yith_wcaf_affiliate_settings_profile_fields', $fields, $args );
		}

		/**
		 * Returns a single field from the array
		 * If field doesn't exists, it returns false
		 *
		 * @param string $field_name Field name.
		 * @param string $context    Context of the operation.
		 *
		 * @return bool|array Field or false on failure.
		 */
		public static function get_field( $field_name, $context = 'edit' ) {
			if ( ! self::field_exists( $field_name ) ) {
				return false;
			}

			$fields = self::get_fields( $context );

			return $fields[ $field_name ];
		}

		/**
		 * Returns field array, formatted as required by functions that print fields
		 *
		 * @param array $field Field array, as saved in database.
		 *
		 * @return array Formatted field, as required by print functions.
		 */
		public static function get_formatted_field( $field ) {
			$formatted = $field;

			// format options.
			if ( ! empty( $field['options'] ) ) {
				$formatted_options = array();

				foreach ( $field['options'] as $option ) {
					list( $key, $label ) = yith_plugin_fw_extract( $option, 'value', 'label' );

					$formatted_options[ trim( $key ) ] = trim( $label );
				}

				$formatted['options'] = $formatted_options;
			}

			// format classes.
			$formatted['class']       = ! empty( $field['class'] ) ? explode( ' ', $field['class'] ) : array();
			$formatted['label_class'] = ! empty( $field['label_class'] ) ? explode( ' ', $field['label_class'] ) : array();

			// give default to radio fields.
			if ( 'radio' === $field['type'] && empty( $field['default'] ) ) {
				$formatted['default'] = ! empty( $formatted['options'] ) ? current( array_keys( $formatted['options'] ) ) : '';
			}

			// assign special values.
			switch ( $field['name'] ) {
				case 'custom_promote':
					$formatted['custom_attributes'] = array(
						'data-dep-target' => self::get_field_id( $field['name'] ),
						'data-dep-id'     => self::get_field_id( 'how_promote' ),
						'data-dep-value'  => 'others',
					);
					break;
				case 'terms':
					$formatted['label']   = wc_replace_policy_page_link_placeholders( $field['label'] );
					$formatted['class'][] = 'terms-label';
					break;
			}

			return $formatted;
		}

		/**
		 * Checks whether a field_name already exists in current set
		 *
		 * @param string $field_name Name of the field to check.
		 * @return bool Whether the field exists or not.
		 */
		public static function field_exists( $field_name ) {
			return array_key_exists( $field_name, self::get_fields() );
		}

		/**
		 * Checks whether a specific field is reserved
		 *
		 * @param string $field_name Name of the field to check.
		 * @return bool Whether the field exists and is reserved.
		 */
		public static function is_field_reserved( $field_name ) {
			if ( ! self::field_exists( $field_name ) ) {
				return false;
			}

			$field = self::get_field( $field_name );

			return $field['reserved'];
		}

		/* === FIELDS HANDLING === */

		/**
		 * Add a field to current set
		 *
		 * @param array  $field Field to add.
		 * @param string $where Position where to add the field (top/bottom/before/after(.
		 * @param string $pivot Additional position parameter; when $where is before or after, this specify which field to use as a pivot.
		 * @throws Exception When there is a validation error with the submitted field.
		 */
		public static function add_field( $field, $where = 'bottom', $pivot = false ) {
			$fields = self::get_fields();
			$field  = self::parse_field( $field );

			// check if field is valid.
			if ( empty( $field['name'] ) ) {
				throw new Exception( _x( 'Empty field name: you must specify a name for the field', '[ADMIN] Generic error thrown while adding a new Affiliate\'s form field', 'yith-woocommerce-affiliates' ) );
			} elseif ( self::field_exists( $field['name'] ) ) {
				throw new Exception( _x( 'Field with the same name already exists; you must specify a unique field name.', '[ADMIN] Generic error thrown while adding a new Affiliate\'s form field', 'yith-woocommerce-affiliates' ) );
			}

			// check for invalid $where values.
			if ( in_array( $where, array( 'top', 'bottom' ), true ) && ( ! $pivot || ! array_key_exists( $pivot, $fields ) ) ) {
				$where = 'bottom';
			}

			// add new field to existing ones.
			switch ( $where ) {
				case 'top':
					self::$profile_fields = array_merge(
						array(
							$field['name'] => $field,
						),
						$fields
					);
					break;
				case 'before':
				case 'after':
					self::$profile_fields = yith_wcaf_append_items(
						$fields,
						$pivot,
						array(
							$field['name'] => $field,
						),
						$where
					);
					break;
				default:
					self::$profile_fields = array_merge(
						$fields,
						array(
							$field['name'] => $field,
						)
					);
					break;
			}

			self::sync_fields();
		}

		/**
		 * Enable a field
		 *
		 * @param string $field_name Field to enable.
		 */
		public static function enable_field( $field_name ) {
			self::change_field_status( $field_name, true );
		}

		/**
		 * Disable a field
		 *
		 * @param string $field_name Field to enable.
		 */
		public static function disable_field( $field_name ) {
			self::change_field_status( $field_name, false );
		}

		/**
		 * Change field status
		 *
		 * @param string $field_name Field name.
		 * @param bool   $status     Status to set.
		 * @param bool   $force      Whether to force operation for reserved fields.
		 */
		public static function change_field_status( $field_name, $status, $force = false ) {
			if ( ! self::field_exists( $field_name ) || self::is_field_reserved( $field_name ) && ! $force ) {
				return;
			}

			$field = self::get_field( $field_name );

			$field['enabled'] = $status;

			try {
				self::update_field( $field_name, $field, $force );
			} catch ( Exception $e ) {
				return;
			}
		}

		/**
		 * Add a field to current set
		 *
		 * @param string $field_name Field to update.
		 * @param array  $field      New field contents.
		 * @param bool   $force      Whether to force operation for reserved fields.
		 * @throws Exception When there is a validation error with the submitted field.
		 */
		public static function update_field( $field_name, $field, $force = false ) {
			$fields = self::get_fields();
			$field  = self::parse_field( $field );

			// check if field is valid.
			if ( empty( $field_name ) ) {
				throw new Exception( _x( 'Empty field name: you must specify a name for the field.', '[ADMIN] Generic error thrown while adding a new Affiliate\'s form field', 'yith-woocommerce-affiliates' ) );
			} elseif ( ! self::field_exists( $field_name ) ) {
				throw new Exception( _x( 'No field found for the specified name.', '[ADMIN] Generic error thrown while adding a new Affiliate\'s form field', 'yith-woocommerce-affiliates' ) );
			} elseif ( $field['name'] !== $field_name && self::field_exists( $field['name'] ) ) {
				throw new Exception( _x( 'A field with the same name already exists; you must enter a unique field name.', '[ADMIN] Generic error thrown while adding a new Affiliate\'s form field', 'yith-woocommerce-affiliates' ) );
			}

			// double check if field is reserved; if this is the case, preserve protected properties.
			if ( self::is_field_reserved( $field_name ) && ! $force ) {
				$saved_field     = self::$profile_fields[ $field_name ];
				$protected_props = array(
					'name',
					'type',
					'show_in',
					'validation',
					'options',
					'required',
					'enabled',
					'show_in',
					'reserved',
				);

				foreach ( $protected_props as $prop ) {
					$field[ $prop ] = $saved_field[ $prop ];
				}
			}

			if ( $field['name'] === $field_name ) {
				// if field name is the same, just update existing item.
				self::$profile_fields[ $field_name ] = $field;
			} else {
				// otherwise add a new item just after existing one, and remove previous.
				self::$profile_fields = yith_wcaf_append_items(
					$fields,
					$field_name,
					array(
						$field['name'] => $field,
					)
				);

				unset( self::$profile_fields[ $field_name ] );
			}

			self::sync_fields();
		}

		/**
		 * Add a field to current set
		 *
		 * @param string $field_name Field to update.
		 * @param string $property   Property to update.
		 * @param mixed  $value      Value to assign to the property.
		 * @param bool   $force      Whether to force operation for reserved fields.
		 */
		public static function update_field_property( $field_name, $property, $value, $force = false ) {
			$field = self::get_field( $field_name );

			$field[ $property ] = $value;

			try {
				self::update_field( $field_name, $field, $force );
			} catch ( Exception $e ) {
				return;
			}
		}

		/**
		 * Clone an existing field and place it at the end of field's list
		 *
		 * @param string $field_name Field name.
		 * @param bool   $force      Whether to force operation for reserved fields.
		 */
		public static function clone_field( $field_name, $force = false ) {
			if ( ! self::field_exists( $field_name ) || self::is_field_reserved( $field_name ) && ! $force ) {
				return;
			}

			$field = self::get_field( $field_name );

			// alter field_name to keep uniqueness.
			$field_name = $field['name'];
			$counter    = 0;

			// address fields' names ending in integer values.
			if ( preg_match( '/(.*)_([0-9]+)/', $field_name, $matches ) ) {
				$field_name = $matches[1];
				$counter    = (int) $matches[2];
			}

			do {
				$counter++;
			} while ( self::field_exists( "{$field_name}_{$counter}" ) );

			$field['name'] = "{$field_name}_{$counter}";

			try {
				self::add_field( $field );
			} catch ( Exception $e ) {
				return;
			}
		}

		/**
		 * Removes a field from the profile configuration, given its name
		 *
		 * @param string $field_name Field to remove.
		 * @param bool   $force      Whether to force operation for reserved fields.
		 * @return void
		 */
		public static function remove_field( $field_name, $force = false ) {
			if ( ! self::field_exists( $field_name ) || self::is_field_reserved( $field_name ) && ! $force ) {
				return;
			}

			unset( self::$profile_fields[ $field_name ] );

			self::sync_fields();
		}

		/**
		 * Sorts currently existing fields, using a new order
		 * Fields that aren't specified in the submitted order, will be appended to the sorted list.
		 *
		 * @param array $fields_order Array of field names, in the order we should apply.
		 * @return void.
		 */
		public static function sort_fields( $fields_order ) {
			// if order is malformed, just do nothing.
			if ( ! is_array( $fields_order ) || empty( $fields_order ) ) {
				return;
			}

			$fields        = self::get_fields();
			$sorted_fields = array();

			foreach ( $fields_order as $field_name ) {
				if ( ! isset( $fields[ $field_name ] ) ) {
					continue;
				}

				$sorted_fields[ $field_name ] = $fields[ $field_name ];

				unset( $fields[ $field_name ] );
			}

			if ( ! empty( $fields ) ) {
				$sorted_fields = array_merge_recursive(
					$sorted_fields,
					$fields
				);
			}

			self::$profile_fields = $sorted_fields;

			self::sync_fields();
		}

		/**
		 * Restore default value for the fields
		 *
		 * @return void.
		 */
		public static function restore_default_fields() {
			self::maybe_read_profile_fields( true );

			// avoid to save defaults if array is empty.
			if ( empty( self::$profile_fields ) ) {
				return;
			}

			self::sync_fields();
		}

		/**
		 * Read profile's fields from database and return them
		 *
		 * @param bool $restore_defaults Whether we should revert to system defaults.
		 *
		 * @return array Array of profile's fields.
		 */
		protected static function maybe_read_profile_fields( $restore_defaults = false ) {
			if ( empty( self::$profile_fields ) || $restore_defaults ) {
				$option_name = 'yith_wcaf_affiliate_profile_fields';

				if ( $restore_defaults ) {
					$option_name .= '_defaults';
				}

				// retrieve stored option, and parse items to match basic structure.
				$profile_fields = array_map(
					array(
						self::class,
						'parse_field',
					),
					get_option( $option_name, array() )
				);

				// use fields names as index for profile_field array.
				$profile_fields = array_combine( wp_list_pluck( $profile_fields, 'name' ), $profile_fields );

				self::$profile_fields = $profile_fields;
			}

			return self::$profile_fields;
		}

		/**
		 * Sync current fields with database
		 *
		 * @return void
		 */
		protected static function sync_fields() {
			update_option( 'yith_wcaf_affiliate_profile_fields', array_values( self::$profile_fields ) );
		}

		/**
		 * Parse field, to make sure it matches expected structure
		 *
		 * @param array $raw_field Raw field, as read from database.
		 * @return array Parsed field.
		 */
		protected static function parse_field( $raw_field ) {
			$default_field = array(
				'name'          => '',
				'label'         => '',
				'admin_label'   => '',
				'admin_tooltip' => '',
				'error_message' => '',
				'type'          => 'text',
				'placeholder'   => '',
				'class'         => '',
				'label_class'   => '',
				'validation'    => 'text',
				'options'       => array(),
				'required'      => false,
				'enabled'       => false,
				'show_in'       => array(
					'settings'            => false,
					'become_an_affiliate' => false,
				),
				'reserved'      => false,
				'editable'      => true,
			);

			return wp_parse_args( $raw_field, $default_field );
		}
	}
}
