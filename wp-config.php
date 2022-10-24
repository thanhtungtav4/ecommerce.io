<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
define('WP_POST_REVISIONS', 5);
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'mysql' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


//define( 'OTGS_INSTALLER_SITE_KEY_WPML', 'd9tb1dxttk' );
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Tjs0Uks=qDdh&H,pMqL>a@aDfN*y$^Z4T?rZuNWU&X=>l|V^Q_+-NN6E:.<yPS?|');
define('SECURE_AUTH_KEY',  '4@_?^-PSGKyS80d{7yHYJ9RT+03J}t[lc,WZG-4<4dhi]^Pf9gS3?|L:W_B<.+&(');
define('LOGGED_IN_KEY',    'Cbup xHw:;:tf3 -2G0ib}VnhZ8`R=,I6@D/OMCNBx7A& 7}PrsyTjM~fs4nP+*5');
define('NONCE_KEY',        '35Sy=B*V`IROxBYtpE8D]F6ZiA*imtcq>LaN-8J9`<P+&DR]y-fXuzyBMe(TB}+L');
define('AUTH_SALT',        '+@|qJTX*4I8[f5uO?i)&hHUAzpf;=VESr.c|$QJ%+DbU{dwrDA-gI:?<sq6`[lNv');
define('SECURE_AUTH_SALT', '|%|-ppw(ElYB6x$~ITC&i]bAlR3v3>u<%+x4C@oCtyg3o1`skW6xW;4+Xte+>~1|');
define('LOGGED_IN_SALT',   'DDnmAy~vDhJ5pO2mrFKKl0nqU+:qFxXMa2GCpKF3kd$|jV;@~:HPciu*|UlU0~JX');
define('NONCE_SALT',       '?v]7;x+Wk5-grwHNdvT.5#sV!Y}KhN|Y%5skx%S+|E_3w6UuL:&gPn?z0_!f-1RT');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
