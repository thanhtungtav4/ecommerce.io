=== YITH WooCommerce Affiliates ===

Contributors: yithemes
Tags:  affiliate, affiliate marketing, affiliate plugin, affiliate tool, affiliates, woocommerce affiliates, woocommerce referral, lead, link, marketing, money, partner, referral, referral links, referrer, sales, woocommerce, wp e-commerce, affiliate campaign, affiliate marketing, affiliate plugin, affiliate program, affiliate software, affiliate tool, track affiliates, tracking, affiliates manager, yit, yith, yithemes, yit affiliates, yith affiliates, yithemes affiliates
Requires at least: 5.8
Tested up to: 6.0
Stable tag: 2.6.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

YITH WooCommerce Affiliates allows you to create affiliate profiles and grant your affiliates earnings each time someone purchases from their link.

== Description ==

YITH WooCommerce Affiliate allows you to run a powerful affiliate campaign to drive traffic to your shop, get new customers and grow revenue.

With this plugin you can easily build partnerships with customers, bloggers, influencers, etc. and ask them to drive traffic to your shop through articles in their blog, posts in their social channels and so on. It’s a win-win relationship because **you will get quality leads, traffic and sales** and your affiliates will earn a commission on the generated sales.

Affiliate marketing is very popular and more than **80% of the online companies** (like Amazon, Zalando, Shein, etc.) **offer an affiliate program** to its users.

With **YITH WooCommerce Affiliate** you can quickly launch an affiliate program in your shop: the free version has all you need to manage affiliates, commissions and check the stats (visits, commissions, conversion rates, etc.)

= Features of the free version =

* Use the default form included for your affiliate registration process: you can enable/disable the fields Name, Surname, E-mail, Password and choose which of these fields are mandatory
* Show the Terms and Conditions checkbox and make it mandatory
* Show the affiliate registration form as part of the default WooCommerce registration form shown in the user’s My Account page
* Use the affiliate registration form shortcode to create a custom registration page for your affiliates
* Choose to reject or ban an affiliate and show a message to explain the reason
* Add an affiliate manually choosing from an existing user or by creating a new one
* Get the referrer ID via query string during the user’s purchase
* Enter a name to identify cookies that will store the referral token
* Set an expiration time for referral cookies (in this way, if the visit and the purchase do not happen in the same session, commissions can still be credited correctly)
* Execute an AJAX call to set up affiliate cookies whenever the system finds a referral query string in the URL
* Enable the affiliate dashboard in a specific endpoint inside the My Account page
* Create a custom affiliate dashboard page using the shortcode
* In their dashboard, affiliates can easily monitor visits, commissions and the status of each payment received
* Allow affiliates to share their referral link on social media
* Set a default commission rate for all affiliates
* Prevent affiliates from getting commissions from their own purchases
* Exclude taxes and discounts from commissions
* Associate old commissions to new users with same token
* Pay commissions manually via direct bank/wire transfer
* Automatically deduct the total of affiliate commissions in case of order refunds

[Check the Live Demo of the free version >](https://plugins.yithemes.com/yith-woocommerce-affiliates-free/)

= Features of the premium version =

The free version of our plugin works like a charm, but the premium one is even more interesting.

By upgrading to the premium version, you can:

* Create a custom advanced form for your affiliate registration process: add unlimited fields to the form, such as Website or Blog URL, Links of their social channels, a small bio, etc. Ask anything you want and choose which fields are mandatory
* Automatically approve all affiliates after their registration to avoid the manual enabling
* Exclude specific products, categories or tags from affiliates commissions
* Exclude specific users or user roles from the affiliate program
* Register visits and visitors’ IPs
* Assign coupons to affiliates: the affiliate can use the coupon to promote your site and each order that uses the coupon will generate a commission for him/her
* Override the default commission rate and set a different rate for specific users, user roles or products
* Pay commissions automatically when the affiliate reaches a threshold; on a specific day of the month (e.g. each 1st day of the month); on a specific day of the month, only if the threshold is achieved; or schedule a daily payment
* Let affiliates ask for the payment of their commissions (and upload or generate invoices for their withdrawal requests)
* Set a minimum and maximum amount for the withdrawal request
* Affiliates can get an email notification when a new commission is generated
* Affiliates can get an email notification when a commission is paid
* Pay commissions through PayPal, PayPal Payout (with YITH PayPal Payouts for WooCommerce), Stripe (with YITH Stripe Connect for WooCommerce) or Account Funds (with YITH WooCommerce Account Funds)
* Send an email to the admin when a payment is issued
* Monitor advanced reports (visits, commissions, earnings, popular affiliates, popular products, etc.) in the new integrated dashboard
* Detailed report of visits generated from referrers in a summary table with the main information and their conversion status
* Access to the affiliate’s detail page from the affiliates table to check the affiliate’s personal info, commissions, statistics, etc.
* Associate an order with a specific affiliate
* Replace the referral cookie if another referral link is visited
* Save cookies history
* Choose to delete the affiliate cookie after the user’s checkout
* Set the time lapse after which the same user’s visit with same referrer ID counts as a new visit
* Automatically delete the visits log after a specific time interval
* Export commissions and affiliates into a CSV file

[Check the Live Demo of the premium version >](https://plugins.yithemes.com/yith-woocommerce-affiliates/)

== Installation ==

1. Unzip the downloaded zip file.
2. Upload the plugin folder into the `wp-content/plugins/` directory of your WordPress site.
3. Activate `YITH WooCommerce Affiliates` from Plugins page

YITH WooCommerce Affiliates will add a new submenu called "Affiliates" under "YITH" menu. Here you are able to configure all the plugin settings.

== Screenshots ==

1. [Backend] List of affiliates
2. [Backend] Add existing user as affiliate
3. [Backend] Add new user as affiliate
4. [Backend] User profile
5. [Backend] Ban affiliate
6. [Backend] Reject affiliate
7. [Backend] List of commissions
8. [Backend] List of payments
9. [Settings] General options
10. [Settings] Affiliate registration
11. [Settings] Affiliate dashboard
12. [Settings] Commissions & Payments
13. [Affiliate Dashboard] Summary
14. [Affiliate Dashboard] Commissions
15. [Affiliate Dashboard] Visits
16. [Affiliate Dashboard] Payments
17. [Affiliate Dashboard] Link Generator
18. [Affiliate Dashboard] Settings
19. [Frontend] Registration form
20. [Frontend] Rejected Affiliate

== Changelog ==

= 2.6.0 - Released on 8 September 2022 =

* New: support for WooCommerce 6.9
* Update: YITH plugin framework
* Fix: removed parameter from yith_wcaf_settings_form_start action to avoid a possible fatal error
* Dev: added new filter yith_wcaf_show_login_section

= 2.5.0 - Released on 4 August 2022 =

* New: support for WooCommerce 6.8
* Update: YITH plugin framework

= 2.4.0 - Released on 11 July 2022 =

* New: support for WooCommerce 6.7
* Update: YITH plugin framework

= 2.3.0 - Released on 28 June 2022 =

* New: support for WooCommerce 6.6
* Update: YITH plugin framework

= 2.2.0 - Released on 25 May 2022 =

* New: support for WordPress 6.0
* New: support for WooCommerce 6.5
* Update: YITH plugin framework
* Tweak: whenever possible use placeholders for query generation, avoiding direct concatenation of strings
* Dev: added new filter yith_wcaf_share_title

= 2.1.1 - Released on 04 May 2022 =

* Update: YITH plugin framework
* Tweak: changed affiliates table structure, to allow for 3 digits rates (100%)
* Tweak: improved link-generator template attributes
* Tweak: use GET method for List views (fix pagination and filtering problems on admin side)
* Dev: added filter yith_wcaf_affiliate_{$gateway_id}_gateway_preferences to allow third party code filter affiliate gateway preferences
* Dev: replaced yith_wcaf_is_hosted filter with yith_wcaf_is_url_hosted (corrected value being filtered)
* Fix: prevent unnecessary action scheduling during upgrade to version 2.x.x

= 2.1.0 - Released on 21 April 2022 =

* New: support for WooCommerce 6.4
* Update: YITH plugin framework
* Tweak: improvements to dependencies system
* Tweak: make sure gateway is correctly assigned to the payment record when processing payment
* Tweak: special handling for first/last name field value (fallback to user first/last name when empty)
* Fix: prevent notice when processing bulk actions to process payments
* Fix: avoid saving empty token from user profile screen

= 2.0.1 - Released on 07 April 2022 =

* Update: YITH plugin framework
* Fix: typo in readme.txt
* Fix: possible fatal error on order page

= 2.0.0 - Released on 06 April 2022 =

* New: redesigned UI / improved UX of the plugin
* New: option to show Affiliate Dashboard as endpoints of My Account page
* New: improved Gateways handling, with specific options for each gateway
* New: BACS gateway to request your affiliate Bank account for offline payments
* New: modal to create user as an affiliate from admin panel
* Update: YITH plugin framework
* Tweak: completely refactored plugin code
* Tweak: improved privacy class
* Tweak: refactored Gutenberg blocks / Elementor widget with new parameters
* Fix: prevent creation of two affiliates records for the same user
* Dev: added yith_wcaf_should_register_hit filter
* Dev: added new yith_wcaf_instance_check filter
* Dev: added new yith_wcaf_use_dashboard_pretty_permalinks filter
* Dev: added new {$tag}_shortcode_template_atts filter, to allow third party dev to change shortcode attributes
* Dev: added new yith_wcaf_{$field_key}_type filter, to allow third party dev to change each field type
* Dev: added new yith_wcaf_{$field_key}_label filter, to allow third party dev to change each field label
* Dev: added new yith_wcaf_{$field_key}_required filter, to allow third party dev to change each field required flag

= 1.15.0 - Released on 07 March 2022 =

* New: support for WooCommerce 6.3
* Update: YITH Plugin Framework

= 1.14.0 - Released on 27 January 2022 =

* New: support for WooCommerce 6.2
* Update: YITH Plugin Framework
* Fix: WooCommerce Version error on update

= 1.13.0 - Released on 11 January 2022 =

* New: support for WordPress 5.9
* New: support for WooCommerce 6.1
* Update: YITH Plugin Framework

= 1.12.0 - Released on 15 December 2021 =

* New: support for WooCommerce 6.0
* Update: YITH Plugin Framework

= 1.11.0 - Released on 08 November 2021 =

* New: support for WooCommerce 5.9
* Update: YITH Plugin Framework

= 1.10.0 - Released on 11 October 2021 =

* New: support for WooCommerce 5.8
* Update: YITH Plugin Framework

= 1.9.1 - Released on 27 September 2021 =

* Update: YITH Plugin Framework
* Fix: debug info feature removed for all logged in users

= 1.9.0 - Released on 23 September 2021 =

* New: support for WooCommerce 5.7
* Update: YITH Plugin Framework
* Fix: product search box in Affiliate Dashboard page

= 1.8.7 - Released on 05 August 2021 =

* New: support for WooCommerce 5.6
* New: support for WordPress 5.8
* Update: YITH Plugin Framework
* Dev: new params on filter 'yith_wcaf_use_percentage_rates'
* Dev: added yith_wcaf_show_if_affiliate_result filter, to allow custom rules for yith_wcan_show_if_affiliate shortcode

= 1.8.5 - Released on 16 June 2021 =

* New: support for WooCommerce 5.4
* Update: YITH Plugin Framework
* Tweak: minor style improvements for admin panel

= 1.8.4 - Released on 13 May 2021 =

* New: support for WooCommerce 5.3
* Update: YITH Plugin Framework
* Tweak: minor style improvements for admin view
* Dev: added new yith_wcaf_payments_table_column_amount filter

= 1.8.3 - Released on 20 April 2021 =

* New: support for WooCommerce 5.2
* Update: YITH Plugin Framework
* Update: new panel style
* Dev: added new yith_wcaf_requester_origin filter

= 1.8.2 - Released on 12 March 2021 =

* New: support for WordPress 5.7
* New: support for WooCommerce 5.1
* Update YITH Plugin Framework
* Update: Italian language
* Dev: added new yith_wcaf_set_ref_cookie filter

= 1.8.1 - Released on 18 January 2021 =

* New: support for WooCommerce 5.0
* New: German language
* Update: YITH Plugin Framework
* Update: Dutch language

= 1.8.0 - Released on 12 January 2021 =

* New: support for WooCommerce 4.9
* Update: plugin framework
* Dev: added function yith_wcaf_number_format to format the rates

= 1.7.9 - Released on 09 December 2020 =

* New: support for WooCommerce 4.8
* Update: plugin framework
* Dev: added filter yith_wcaf_display_format in order to allow to change the format on conversion rate and rate section

= 1.7.7 - Released on 10 November 2020 =

* New: support for WordPress 5.6
* New: support for WooCommerce 4.7
* New: possibility to update plugin via WP-CLI
* Update: plugin framework
* Dev: removed deprecated method .ready from scripts

= 1.7.6 - Released on 15 October 2020 =

* New: support for WooCommerce 4.6
* Update: plugin framework
* Tweak: show correct currency for commissions on admin table
* Tweak: removed usage of deprecated jQuery method $.fn.toggle from admin assets
* Dev: added new filter yith_wcaf_commissions_dashboard_commissions

= 1.7.5 - Released on 17 August 2020 =

* New: support for WooCommerce 4.5
* Update: plugin framework
* Tweak: improved show_if_affiliates shortcode, to accept more than one rule, and to accept negated rules too
* Fix: plugin not consider bottom select for bulk actions on Commissions, Payments and Affiliates views

= 1.7.4 - Released on 13 August 2020 =

* New: support for WordPress 5.5
* New: support for WooCommerce 4.4
* New: breadcrumb for Affiliate Dashboard now contains link to get back to Dashboard home
* Update: plugin framework
* Tweak: added affiliate handling to REST api that creates order
* Tweak: affiliate now logs out directly from affiliate dashboard
* Fix: improved affiliate profile update, to avoid affiliate not having correct role
* Dev: added yith_wcaf_max_rate_value filter
* Dev: added yith_wcaf_line_item_commission_total filter
* Dev: added yith_wcaf_line_total_check_amount_total filter

= 1.7.3 - Released on 09 June 2020 =

* New: support for WooCommerce 4.2
* Tweak: fixed wrong text domain for some strings
* Fix: losing status selection after filtering on admin views
* Dev: added yith_wcaf_create_item_commission filter
* Dev: added yith_wcaf_enqueue_fontello_stylesheet filter
* Dev: add second parameter on yith_wcaf_use_percentage_rates hook

= 1.7.2 - Released on 08 May 2020 =

* New: support for WooCommerce 4.1
* Update: plugin framework
* Tweak: hotfix paypal return url, to set back affiliate cookie when getting back to site after cancelling order
* Fix: removed translation on screen id, that was causing missing assets on admin on non-english sites

= 1.7.1 - Released on 20 April 2020 =

* Update: plugin framework
* Update: Italian language
* Tweak: moved script localization just after script registration
* Tweak: minor improvements to frontend layouts, for better theme integration
* Tweak: removed not-pertinent CSS rules (this styling should be demanded by theme)
* Tweak: added affiliate dashboard shortcode as gutenberg block on brand new Dashboard page

= 1.7.0 - Released on 09 March 2020 =

* New: support for WordPress 5.4
* New: support for WooCommerce 4.0
* New: Greek translation
* New: added option to set up affiliates cookie via AJAX call (to better work with cache systems)
* New: added Elementor widgets
* Tweak: include commissions metabox into WC Subscription edit page
* Tweak: code reformat and improvements for PHPCS
* Update: plugin framework

= 1.6.9 – Released on 23 December 2019 =

* New: support for WooCommerce 3.9
* Update: plugin framework

= 1.6.8 - Released on 12 December 2019 =

* Update: plugin framework

= 1.6.7 - Released on 29 November 2019 =

* New: added category column to commissions table
* Tweak: check if dependencies are registered in order to prevent error in gutenberg pages
* Update: notice handler
* Update: plugin framework
* Fix: prevent warning when global $post do not contain WP_Post object

= 1.6.6 - Released on 06 November 2019 =

* Tweak: changed Fontello class names to avoid conflicts with themes
* Tweak: added checks before Fontello style inclusion, to load it just when needed

= 1.6.5 – Released on 05 November 2019 =

* New: support for WordPress 5.3
* New: support for WooCommerce 3.8
* New: Added social sharing for referral link
* Update: Plugin Framework
* Update: Italian language
* Update: Spanish language
* Update: Dutch language
* Tweak: added cache for commission status count
* Tweak: optimized has_unpaid_commissions method
* Tweak: optimized affiliates per_status_count, using wp_cache
* Fix: notices related to missing variables, or unhandled exception return values
* Fix: reset button not appearing on commission page when filtering by status
* Fix: exclude trashed commissions from commission count on the commission page
* Dev: added new filter yith_wcaf_link_generator_generated_url
* Dev: added new filter yith_wcaf_display_symbol
* Dev: added new action yith_wcaf_process_checkout_with_affiliate

= 1.6.4 - Released on 30 October 2019 =

* Update: Plugin framework

= 1.6.3 - Released on 09 August 2019 =

* New: WooCommerce 3.7.0 RC2 support
* Update: internal plugin framework
* Update: Italian language
* Fix: allow copy button from iphone/ipad
* Dev: added new filter yith_wcaf_check_affiliate_val_error
* Dev: added new filter yith_wcaf_dashboard_navigation_menu

= 1.6.2 - Released on 13 June 2019 =

* Update: internal plugin framework
* Tweak: improved uninstall procedure
* Tweak: Changed all doubleval() function to floatval() function

= 1.6.1 - Released on 23 April 2019 =

* Tweak: added rel nofollow to sorting urls
* Update: internal plugin framework

= 1.6.0 - Released on 03 April 2019 =

* New: WooCommerce 3.6.0 RC1 support
* Update: internal plugin framework
* Fix: DB error on backend
* Dev: added new filter yith_wcaf_prepare_items_commissions

= 1.5.1 - Released on 31 January 2019 =

* New: WooCommerce 3.5.3 support
* Tweak: fixed wrong text-domains
* Update: internal plugin framework
* Dev: added filter yith_wcaf_add_affiliate_role

= 1.5.0 - Released on 12 December 2019 =

* New: support to WordPress 5.0
* New: support to WooCommerce 3.5.2
* New: Gutenberg block for yith_wcaf_registration_form shortcode
* New: Gutenberg block for yith_wcaf_affiliate_dashboard shortcode
* New: Gutenberg block for yith_wcaf_link_generator shortcode
* Tweak: updated plugin framework
* Fix: notice in affiliate dashboard
* Fix: notice "trying to retrieve user_login from non-object" on commission table
* Fix: prevent Notice when get_userdata returns a non-object
* Fix: doubled input fields on custom registration form
* Dev: added missing actions on link generator template

= 1.4.1 - Released on 24 October 2018 =

* Tweak: updated plugin framework
* Updated: dutch language
* Fix: minor issues introduced with last update

= 1.4.0 - Released on 03 October 2018 =

* New: support to WooCommerce 3.5-RC1
* New: support to WordPress 4.9.8
* New: updated plugin framework
* New: added new Reject status for affiliates
* New: added commissions Trash
* Fix: affiliate backend creation
* Fix: fixed some queries on various admin views
* Tweak: improved balance calculation
* Dev: added filter get_referral_url filter

= 1.3.1 - Released on 19 July 2018 =

* New: added new fields during affiliate registration
* Fixed: warning occurring when WooCommerce does not send all params to woocommerce_email_order_meta action
* Dev: added filter yith_wcaf_dashboard_affiliate_message

= 1.3.0 - Released on 28 May 2018 =

* New: WooCommerce 3.4 compatibility
* New: WordPress 4.9.6 compatibility
* New: updated plugin-fw
* New: GDPR compliance
* New: admin can now ban Affiliates
* Update: Italian Language
* Update: Spanish language
* Tweak: improved pagination of dashboard sections
* Fix: preventing notice when filtering by date payments

= 1.2.4 - Released on 05 April 2018 =

* New: "yith_wcaf_show_if_affiliate" shortcode
* New: added "process orphan commissions" procedure
* New: added shortcodes for Affiliate Dashboard sections ( [yith_wcaf_show_clicks], [yith_wcaf_show_commissions], [yith_wcaf_show_payments], [yith_wcaf_show_settings] )
* Tweak: remove user_trailingslashit from get_referral_url to improve compatibility
* Tweak: improved user capability handling, now all admin operations require at least manage_woocommerce capability
* Dev: added yith_wcaf_requester_link filter to let third party code change requester link
* Dev: new filter "yith_wcaf_panel_capability" to let third party code change minimum required capability for admin operations
* Dev: added "order_id" param for "yith_wcaf_affiliate_rate" filter

= 1.2.2 - Released on 01 February 2018 =

* New: added WooCommerce 3.3.x support
* New: added WordPress 4.9.2 support
* New: added Dutch translation
* Tweak: added SAMEORIGIN header to Affiliate Dashboard page
* Tweak: fixed error with wrong Affiliate ID when adding new affiliate to database

= 1.2.1 - Released on Nov, 14 - 2017 =

* Fix: added check over user before adding role

= 1.2.0 - Released on 10 November 2017 =

* New: WooCommerce 3.2.x support
* New: new affiliate role
* New: added login form in "Registration form" template
* New: added copy button for generated referral url
* Fix: removed profile panel when customer have permissions lower then shop manager
* Dev: added yith_wcaf_settings_form_start action
* Dev: added yith_wcaf_settings_form action
* Dev: added yith_wcaf_save_affiliate_settings action
* Dev: added yith_wcaf_show_dashboard_links filter to let dev show navigation menu on all affiliates dashboard pages

= 1.1.0 - Released on 04 April 2017 =

* New: WordPress 4.7.3 compatibility
* New: WooCommerce 3.0-RC2 compatibility
* New: Delete bulk action for payments
* Tweak: text domain to yith-woocommerce-affiliates. IMPORTANT: this will delete all previous translations
* Tweak: delete notes while deleting commission
* Fix: delete method for payments
* Fix: commission delete process
* Fix: commission notes delete process
* Dev: added yith_wcaf_affiliate_rate filter to let third party plugin customize affiliate commission rate
* Dev: added yith_wcaf_use_percentage_rates filter to let switch from percentage rate to fixed amount (use it at your own risk, as no control over item total is performed)
* Dev: added yith_wcaf_become_an_affiliate_redirection filter to let third party plugin customize redirection after "Become an Affiliate" butotn is clicked
* Dev: added yith_wcaf_become_affiliate_button_text filter to let third party plugin change Become Affiliate button label
* Dev: added yith_wcaf_payment_email_required filter to let third party plugin to remove payment email from affiliate registration form
* Dev: added yith_wcaf_create_order_commissions filter, to let dev skip commission handling
* Dev: added filters yith_wcaf_before_dashboard_section and yith_wcaf_after_dashboard_section
* Dev: added yith_wcaf_get_current_affiliate_token function to get current affiliate token
* Dev: added yith_wcaf_get_current_affiliate function to get current affiliate object
* Dev: added yith_wcaf_get_current_affiliate_user function to get current affiliate user object

= 1.0.9 - Released on 03 October 2016 =

* Added: function yith_wcaf_get_current_affiliate_token to get current affiliate token
* Added: function yith_wcaf_get_current_affiliate to get current affiliate object
* Added: function yith_wcaf_get_current_affiliate_user to get current affiliate user object
* Added: Delete bulk action for payments
* Added: option to force commissions delete
* Added: filter yith_wcaf_persistent_rate to let dev filter persistent rate
* Tweak: changed text domain to yith-woocommerce-affiliates
* Fixed: Delete method for payments
* Fixed: commissions and notes delete methods

= 1.0.8 - Released on 08 June 2016 =

* Added: support WC 2.6 RC1
* Added: style for #yith_wcaf_order_referral_commissions, #yith_wcaf_payment_affiliate, #yith_wcaf_commission_payments
* Added: per page input in affiliate dashboard
* Tweak: added filter yith_wcaf_is_hosted to filter check over submitted host / server name match in link_generator callback
* Fixed: column ordering anchor in affiliate dashboard

= 1.0.7 - Released on 05 May 2016 =

* Added: WordPress 4.5.x support
* Fixed: removed useless library invocation
* Fixed: generate link shortcode (removed protocol before check for local url)

= 1.0.6 - Released on 05 April 2016 =

* Added filter "yith_wcaf_is_valid_token" to is_valid_token
* Tweak changed EOL to LF
* Tweak: Performance improved with new plugin core 2.0
* Fixed order awaiting payment handling
* Fixed view problems due to new YITH menu page slug
* Fixed generate link shortcode (url parsing improvements)
* Fixed affiliate research
* Fixed plugin-fw loading

= 1.0.5 - Released on 16 October 2015 =

* Added: Option to prevent referral cookie to expire
* Tweak: Increased expire seconds limit
* Tweak: Changed disabled attribute in readonly attribute for link-generator template
* Fixed: Commissions/Payment status now translatable from .po files
* Fixed: Fatal error occurring sometimes when using YOAST on backend

= 1.0.4 - Released on 13 August 2015 =

* Added: Compatibility with WC 2.4.2
* Tweak: Added missing text domain on link-generator template (thanks to dabodude)
* Tweak: Updated internal plugin-fw

= 1.0.3 - Released on 05 August 2015 =

* Fixed: minor bugs

= 1.0.2 - Released on 03 April 2015 =

* Tweak: Improved older PHP versions compatibility (removed dynamic class invocation)

= 1.0.1 - Released on 31 July 2015 =

* Fixed: fatal error for PHP version older then 5.5

= 1.0.0 - Released on 30 July 2015 =

* Initial release
