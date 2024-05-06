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
define( 'DB_NAME', 'leasing_wp629' );

/** Database username */
define( 'DB_USER', 'leasing_wp629' );

/** Database password */
define( 'DB_PASSWORD', '9@!0ESt87p' );

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
define( 'AUTH_KEY',         'kipeplwto2u2sanfefpe0w6mmw30smmzzckmojytloag5s1xc4ej25gz0y5bb0jj' );
define( 'SECURE_AUTH_KEY',  'gndkxuxdtsgipl34qqhv0kbto4ooqqbhif11bypupqa3g0asrpdmidngohn5iheu' );
define( 'LOGGED_IN_KEY',    'nrvxxmkpmphcomt66lim6vwc1cukhzarwpoesmupzrloaa0m0pgn66k2vnpx3och' );
define( 'NONCE_KEY',        'vwhmhg0evkzcn9zf5xrmylxmdjt543prqf4jh6dniudipfxcsbcjyw4gufyzye0k' );
define( 'AUTH_SALT',        'c7tqx9bf2qlnno2mho0e4wb8eiz0njcmtfv17uhr53xumhpc5dfzwlgoboyhcg9e' );
define( 'SECURE_AUTH_SALT', 'yb8zsetmupdxnvnamhhyxoegrzxp5vepvfcjzvlj7yvhy255zgs9tqwrx916lmcv' );
define( 'LOGGED_IN_SALT',   'sm8ww0me8vgjlbdqmdox77xsiwsfj8v3mpgwgyau8onymdpnik7fzzgti6p8khx7' );
define( 'NONCE_SALT',       'agqsmsg9gpuqzuho2lewhhbnvlfhbjtpsadz5cuxigxn15yj4tcuasjgyoyh0b1z' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp0g_';

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
