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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'webdocsach' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'Nj-]Lt8RudLnPD,&b1j@LnUH4h`;T7_HQ6X$= @xfCss2&XI.Zt^y<(|!Hu*YQ]I' );
define( 'SECURE_AUTH_KEY',  'l,#}3$i~$FGVqnOHkh!8KpVd#7-C058qC!a0}:bM@~ib&JFgi?>P2;f e9OX6-dJ' );
define( 'LOGGED_IN_KEY',    'ZP8AYx(-${YYm&Eb5fu`|@F]D;X#<%2Xc#oS.(p|tYEd<c[E:fEUA*aSSb!]PILa' );
define( 'NONCE_KEY',        'ID5)MB&DnjHPlMjL:{>O~P&?e*2?+M.jq{2rGT+gQ=zbjZXHSEX4<T|`Nj4woIXN' );
define( 'AUTH_SALT',        'E-BbrE/By~IR*m@u2<uBhIW/obF.US#,TUko C}w/msBF|x/io|i+_]I%pM9UsS*' );
define( 'SECURE_AUTH_SALT', '&h[=Uf]aejp=exTi&rd=4dm49:lkpa&<3|~1ahAfG03iPw8#7RyiNgjil#qL`z-m' );
define( 'LOGGED_IN_SALT',   'dk!5lEC4y]BX6f!4yMdF:S~5,E:m(CO^+11IVb$DcXSgE_L4Vet+O_m?lm@xI%mn' );
define( 'NONCE_SALT',       'E2 %-e QP|C J([YK)4c+3%%vonIHHCl_*f-+yu[BZf?`E$T_lGd^AAuq1VZjHSR' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
