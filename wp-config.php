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

define('DB_NAME', 'shakedg1_dblevi');



/** MySQL database username */

//define('DB_USER', 'shakedg1_ulevi');
define('DB_USER', 'root');
//define('DB_USER', 'root');



/** MySQL database password */

//define('DB_PASSWORD', 'ulevi%#!#%');
define('DB_PASSWORD', '');
//define('DB_PASSWORD', '');



/** MySQL hostname */

define('DB_HOST', 'localhost');



/** Database Charset to use in creating database tables. */

define('DB_CHARSET', 'utf8');



/** The Database Collate type. Don't change this if in doubt. */

define('DB_COLLATE', 'utf8_general_ci');



/**#@+

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY',         '7wxoqsu7buna4fb24nakmdandergmhy4aqshr0gj6wwm6wytik5m2ptrach9ddxn');

define('SECURE_AUTH_KEY',  '9vuf09ktxn8rfm49tdjoj1fye8gjihsbjhcsogfaasedw2rfnpcy3vnzzksuxxru');

define('LOGGED_IN_KEY',    '2vxjz0oderqnh9uqukaiq1avsaizn65wpibyn5q2vyyhwl2ryzr6wc3nmo0bra6f');

define('NONCE_KEY',        'pksglcvy7ph4s8ojzrkj99ziqphck7r6pr6zjnb9cv63bajo9zrb5kgb5qm3t6ml');

define('AUTH_SALT',        '72glmxbk4l1zwkbchsg3a9dn5yjvr9noiwas04sjomphqs9bogedxrqhsenosu3t');

define('SECURE_AUTH_SALT', 'weiggtol5iud0lkbgttj5xo10q0uc8ftix2gvsgjl699fyvc0ergri6xcxyotf4q');

define('LOGGED_IN_SALT',   'ornlnm5whp9u6utvxdnybd63eodjjzaopylarblgoyigyes9vrppommg2bscsi5q');

define('NONCE_SALT',       'jwhrxlgtwyzgwtxqzaygharkehfzk87becbyyr07czw2em5xlrfqabg1iueuz6ii');



/**#@-*/



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'wpb8_';



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

define( 'WP_MEMORY_LIMIT', '128M' );



/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');



# Disables all core updates. Added by SiteGround Autoupdate:

define( 'WP_AUTO_UPDATE_CORE', false );
