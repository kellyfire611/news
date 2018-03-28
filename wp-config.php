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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'aigf2bdf_store');

/** MySQL database username */
define('DB_USER', 'aigf2bdf');

/** MySQL database password */
define('DB_PASSWORD', 'Pcdeptrai89@#');

/** MySQL hostname */
define('DB_HOST', '112.78.2.195');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'F:jdsR,)%PElVPmyn:E5UssTPEXciw=]}dqb7aFgpSY O&q/F71dM%_3Rfm_^F9c');
define('SECURE_AUTH_KEY',  '2=hJ(0Ax24CXjX~+qy.#IaHU4M.U(X2`EOLar=.ClCit@~;x$oWFY|N^Ru>l:.>?');
define('LOGGED_IN_KEY',    'wSKduWPGcDzK*:tXHZ{vYzf%SMifK33X}^ky3H<O!yMfPTWM{(0[#SmB0RbD}jt)');
define('NONCE_KEY',        '/I}zg{&Htgj._$V[2b^r)An#OLO!mp!25E}CI,ztFojaPa`%k#z=f^Om?XDP/&q+');
define('AUTH_SALT',        'IMJJ h->71eB],Mj7Bi]Q|VG~5;c-mnxcvyAW%?!4bj;IVAmv%1y6!I|z8AA]l41');
define('SECURE_AUTH_SALT', 'tHeMd_e,V2jMBMg9v<#,q*kF_fw#F&Z$iJt%K{wzD}dV8lv~>wI9BxVA9]ecMhDh');
define('LOGGED_IN_SALT',   '$f4G4k04{=l!+f(/ME]-Z2P16#jBmb~ ^qT6:lj}K&]/S~z~)@vCU X2ZD-aeyX`');
define('NONCE_SALT',       '1!`IKw8]p,M;T^8zvJ5]D!!|U7x}j/Y.K|_KWe)*tV=U0QLD,JkX%p[+Y<|nU,Cz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
