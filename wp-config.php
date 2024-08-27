<?php
/**
 * This config file is yours to hack on. It will work out of the box on Pantheon
 * but you may find there are a lot of neat tricks to be used here.
 *
 * See our documentation for more details:
 *
 * https://pantheon.io/docs
 */

/**
 * Pantheon platform settings. Everything you need should already be set.
 */
if (file_exists(dirname(__FILE__) . '/wp-config-pantheon.php') && isset($_ENV['PANTHEON_ENVIRONMENT'])) {
	require_once(dirname(__FILE__) . '/wp-config-pantheon.php');

/**
 * Local configuration information.
 *
 * If you are working in a local/desktop development environment and want to
 * keep your config separate, we recommend using a 'wp-config-local.php' file,
 * which you should also make sure you .gitignore.
 */
} elseif (file_exists(dirname(__FILE__) . '/wp-config-local.php') && !isset($_ENV['PANTHEON_ENVIRONMENT'])){
	# IMPORTANT: ensure your local config does not include wp-settings.php
	require_once(dirname(__FILE__) . '/wp-config-local.php');

/**
 * This block will be executed if you are NOT running on Pantheon and have NO
 * wp-config-local.php. Insert alternate config here if necessary.
 *
 * If you are only running on Pantheon, you can ignore this block.
 */
} else {
	define('DB_NAME',          "worldflow");
	define('DB_USER',          "root");
	define('DB_PASSWORD',      "");
	define('DB_HOST',          "localhost");
	define('DB_CHARSET',       'utf8mb4');
	define('DB_COLLATE',       '');
	define('AUTH_KEY',         'GIIQAm11J66D4RhUS12J76Im56izcl/0UwKIH2yUxUk=');
	define('SECURE_AUTH_KEY',  'iZCFPwiSfHZnCXCbAbhOfHAm2/JAPJSjeL0l/Cu1Mcs=');
	define('LOGGED_IN_KEY',    '5qMi9fIO5/ZSYFXd+f97pqAlGGPKyGt4e8nDwm/ZE3g=');
	define('NONCE_KEY',        'kIc9AzfL6jlVZjvCnn6bslZ5Pg662jJ53U8yOoK29+A=');
	define('AUTH_SALT',        'BKQimDEXZrX1thuYoR1r9yPXthXESdPxjPm8nOuuWM8=');
	define('SECURE_AUTH_SALT', '7FMBHzQ1ehUy88s9apSh/KEx58RiNnC6R7xf7T9RgCE=');
	define('LOGGED_IN_SALT',   '7CjshLYLDTosOPbJ0IZ3MZTSFtx5jpHDm/J1ZfHKGzo=');
	define('NONCE_SALT',       'fyDhtakJqpTrXqh4EDP4N/kZkxu6Xj+/qb82ME9zVLM=');
}


/** Standard wp-config.php stuff from here on down. **/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * You may want to examine $_ENV['PANTHEON_ENVIRONMENT'] to set this to be
 * "true" in dev, but false in test and live.
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'DUPLICATOR_AUTH_KEY', 'Oof2*x;!fb(_RbrzPq;{w<D1zi4&E1l2{b^Rv:nLONveBA2D7yJ1QTB=L7lm0qND' );
/* That's all, stop editing! Happy Pressing. */




/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
