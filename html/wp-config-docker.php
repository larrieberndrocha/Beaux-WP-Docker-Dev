<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


// ** Loookup "env_FILE", "env", then fallback ** //
if (!function_exists('getenv_docker')) {
	// https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker($env, $default) {
    // taken from the value of the ($env)_FILE (example: WORDPRESS_DB_HOST_FILE)
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
    // taken from the wordpress environment at docker-compose.yml
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

// ** https://developer.wordpress.org/apis/wp-config-php/ **//
// ** Database settings - You can get this info from your web host ** //

define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', '') );
define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', '') );
define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', '') );
define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', '') );
define( 'DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', '') );
define( 'DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', '') );
$table_prefix = getenv_docker('WORDPRESS_DB_TABLE_PREFIX', '');

// ** Authentication unique keys and salts. ** //
define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'put your unique phrase here') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'put your unique phrase here') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'put your unique phrase here') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        'put your unique phrase here') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        'put your unique phrase here') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', 'put your unique phrase here') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'put your unique phrase here') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       'put your unique phrase here') );

// If no environment is set default to production. Possible values: local, development, staging or production
if(!defined('ENVIRONMENT')) define('ENVIRONMENT', getenv_docker('WORDPRESS_ENVIRONMENT_TYPE','production') ); 

// ** DEBUG SETTINGS. ** //
// Define different debug settings depending on environment
switch( ENVIRONMENT ) {
  case 'local': case 'development': case 'staging':
    @ini_set( 'log_errors', 'On' );
    @ini_set( 'display_errors', 'Off' );
    @ini_set( 'error_log', '/var/log/php_error.log' );
    define( 'WP_DISABLE_FATAL_ERROR_HANDLER', false );
    define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', 'true') );
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
    define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', 'false') );
    define( 'WP_DEBUG_LOG', false );
    define( 'WP_DEBUG_DISPLAY', false );
    define( 'SCRIPT_DEBUG', false);   
    break;
}

// ** EXTRA SETTINGS ** define( 'WP_MEMORY_LIMIT', getenv_docker('WORDPRESS_MEMORY_LIMIT', '64M') );

define( 'CONCATENATE_SCRIPTS', false );	// concatenated into one URL all JavaScript files in administration screens
define( 'ALLOW_UNFILTERED_UPLOADS', true); // Allow xlsx and other disallowed file types


/* Add any custom values between this line and the "stop editing" line. */

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
