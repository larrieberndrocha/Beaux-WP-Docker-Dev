<?php
/* Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/* Get Server Name */
$server_name = $_SERVER['SERVER_NAME'];

/* Force Define of HOME and SITEURL */
//define( 'WP_HOME', "https://$server_name" );
//define( 'WP_SITEURL', "https://$server_name" );

/* Possible Environments */
$environments = array('local' => array('.local', 'local.'),'development' => 'dev.','staging' => array('staging.','stage.'));

/* Define ENVIRONMENT */
foreach($environments AS $key => $env){
	if(is_array($env)){
		foreach ($env as $option){
			if(stristr($server_name, $option)){
				define('ENVIRONMENT', $key);
				break 2;
			}
		}
	} else {
		if(stristr($server_name, $env)){
			define('ENVIRONMENT', $key);
			break;
		}
	}
}
if(!defined('ENVIRONMENT')) define('ENVIRONMENT', 'production');

// ** https://developer.wordpress.org/apis/wp-config-php/ **//
// ** Database settings - You can get this info from your web host ** //

/* Set Database Connection depending on ENVIRONMENT */
switch(ENVIRONMENT){
  case 'local':
    define('DB_HOST', '');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASSWORD', '');
    $table_prefix  = 'wp_';
    break;

	case 'development':
    define('DB_HOST', '');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASSWORD', '');
    $table_prefix  = 'wp_';
		break;

	case 'staging':
    define('DB_HOST', '');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASSWORD', '');
    $table_prefix  = 'wp_';
		break;

  case 'production': default:
    define('DB_HOST', '');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASSWORD', '');
    $table_prefix  = 'wp_';
    break;
}

define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );


// ** Authentication unique keys and salts. ** //
define( 'AUTH_KEY',         'lpd3umruobawcoestfft5zspkhtydfu9oyivteq3nomrsmzoq2kcr2mykmr3tgzb' );
define( 'SECURE_AUTH_KEY',  'rusfsvjpl3u12hzbe3iottjvtlzubg7auwht7r7aftazzy5ofxopqlrlzjsvqjrc' );
define( 'LOGGED_IN_KEY',    'carcclrs9fochw2mhrqchl5xvqadbhcyavsik9ycrz7nbmrdwdbrxch5zzp03hsn' );
define( 'NONCE_KEY',        'wabuvo5li5elmjjl4ujxwtdbphntj0zrcd9knelbcp3obkn6vedmqsgwc1usprka' );
define( 'AUTH_SALT',        '01evqgvhyv8apkwitns8hbmfcmvjo62azkpmuknuqrzumvknewbheroafw5bowpn' );
define( 'SECURE_AUTH_SALT', 'l8mjfr6jxv541bdlujnigfz5al4kg9vckng9x392qbx7cee1tcbq49g60qlbgq9h' );
define( 'LOGGED_IN_SALT',   'ahzuwcqmioapmtpbbeehbykyzv8mrva5gishufw3xdbtw1owfcxhara6zy1xm8oy' );
define( 'NONCE_SALT',       'uvqlgz3ozeurie7upwl0gcdup67fh2hczmoumtj6nkkir6alh5h7quyhrxrc62aa' );


// ** DEBUG SETTINGS. ** //
// Define different debug settings depending on environment
switch( ENVIRONMENT ) {
  case 'local': case 'development': case 'staging':
    @ini_set( 'log_errors', 'On' );
    @ini_set( 'display_errors', 'Off' );
    @ini_set( 'error_log', '/var/log/php_error.log' );
    define( 'WP_DISABLE_FATAL_ERROR_HANDLER', false );
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );
    define( 'WP_DEBUG_DISPLAY', false );  
    define( 'SCRIPT_DEBUG', true);
    define( 'IMPORT_DEBUG', true );
    break;
  case 'production': default: 
    @ini_set( 'log_errors', 'On' );
    @ini_set( 'display_errors', 'Off' );
    @ini_set( 'error_log', '/var/log/php_error.log' );
    define( 'WP_DISABLE_FATAL_ERROR_HANDLER', false );   // 5.2 and later
    define( 'WP_DEBUG', false) );
    define( 'WP_DEBUG_LOG', false );
    define( 'WP_DEBUG_DISPLAY', false );
    define( 'SCRIPT_DEBUG', false);   
    break;
}


// ** EXTRA SETTINGS ** 
define( 'WP_MEMORY_LIMIT', '256M' ); // Front-end Memory Limit
define( 'WP_MAX_MEMORY_LIMIT', '512M' ); // WP Admin Memory Limit
define( 'CONCATENATE_SCRIPTS', false );	// concatenated into one URL all JavaScript files in administration screens
define( 'ALLOW_UNFILTERED_UPLOADS', true); // Allow xlsx and other disallowed file types


/* Add any custom values between this line and the "stop editing" line. */

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
