<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sftpuser_review_system_23_09' );

/** MySQL database username */
define( 'DB_USER', 'sftpuser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Vision@1' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

define('FS_METHOD','direct');

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0138uOnnUh6d1G-Q#g$}bD=Y6BS`#1TyuL|+;{<zH_l&cFohigzRju6E&z/)G38n' );
define( 'SECURE_AUTH_KEY',  '$<1HNiMv;W(HQR5NF;Af!IeZ.`B?0~Y<gCMMypfA:#tS{@Q^hK9RRK~#EB.2b9]A' );
define( 'LOGGED_IN_KEY',    'h@LCBLm%oqzO>UOf`!KL1jHb5 eT^M^.V*z@k]-iO]umfv3$N)#Ki1b~@YcQJw{)' );
define( 'NONCE_KEY',        'T22]rm/~BE8_<mKKd/^jQ3cgv^0pOl)Ug0.;@^lL-D3uydC^)_zM K]M>$^>m1#0' );
define( 'AUTH_SALT',        'AX[?S-8Nqi?;?W`Qjz$V8d+r>;dWK2gb^FYp?zdXb}*uGJV/f^6t|g))VnHlot|6' );
define( 'SECURE_AUTH_SALT', 'uW1i1x/{*ni!H{|fH{|]gGR2,xcguV$kci_O^?z>^!4Dl2k4@Y(4^%L&4^Uw=SnO' );
define( 'LOGGED_IN_SALT',   'gA>9hD}W4NTwY@(q[/;pe#=k]ev.CT4+%UyD?0-Qdo>kW4gfFh2e^zf!NEqFGGA-' );
define( 'NONCE_SALT',       '_dW/,8{0v6Z`4@/Y$gfy/EQ94ljovDOC%3QymsCM6OL>5.7wke[Z& ;q[M/9A*xz' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
