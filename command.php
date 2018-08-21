<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

use WP_CLI\Utils;

/**
 * Combines finding and checking whether the installation is still hosted.
 *
 * First, runs `wp find` to find all potential WordPress installations under
 * a given path, and builds a list of all potential paths. Next, runs
 * `wp host-check` to determine whether the installation is still hosted on
 * the server.
 *
 * Installation list is only output at the end of execution. Data for each
 * installation includes:
 *
 * * wp_path - Path to the WordPress installation.
 * * version - WordPress version.
 * * db_host - Host name for the database.
 * * db_user - User name for the database.
 * * db_name - Database name for the database.
 * * status - Hosting status (documented next).
 *
 * Potential statuses include:
 *
 * * `check-failed` - Something about the host check process failed.
 * * `no-wp-exists` - WordPress doesn't exist at the path.
 * * `no-wp-config` - No wp-config.php file was found for the installation.
 * * `error-db-connect` - Couldn't connect to the database using defined credentials.
 * * `error-db-select` - Connected to the database but couldn't select specific database.
 * * `missing-<http-code>` - WordPress installation isn't on the server.
 * * `hosted-maintenance` - WordPress installation is hosted but renders maintenance page.
 * * `hosted-php-fatal` - WordPress installation is hosted but has a PHP fatal.
 * * `hosted-broken-wp-login` - WordPress installation is hosted but the login page is broken.
 * * `hosted-valid-login` - WordPress installation is hosted on server and login page loads.
 *
 * ## OPTIONS
 *
 * <path>
 * : Path to search the subdirectories of.
 *
 * [--fields=<fields>]
 * : Limit the output to specific row fields.
 *
 * [--field=<field>]
 * : Output a specific field for each row.
 *
 * [--format=<format>]
 * : Render output in a specific format.
 * ---
 * default: table
 * options:
 *   - table
 *   - json
 *   - csv
 *   - yaml
 *   - count
 * ---
 *
 * @when before_wp_load
 */
WP_CLI::add_command( 'dh-find-check', function( $args, $assoc_args ){

	list( $find_path ) = $args;

	$installations = WP_CLI::runcommand( "find {$find_path} --fields=wp_path,version,db_host,db_name,db_user --format=json", array(
		'return' => true,
		'parse'  => 'json',
	) );
	foreach ( $installations as $i => $installation ) {
		$host_check = WP_CLI::runcommand( "host-check --path={$installation['wp_path']}", array(
			'return'     => true,
			'exit_error' => false,
		) );
		$installations[ $i ]['status'] = 'check-failed';
		if ( preg_match( '#Summary:[^,]+,([^,]+),#', $host_check, $matches ) ) {
			$installations[ $i ]['status'] = trim( $matches[1] );
		}
	}

	$fields = array( 'wp_path', 'version', 'db_host', 'db_name', 'db_user', 'status' );
	if ( ! empty( $assoc_args['fields'] ) ) {
		$fields = explode( ',', $assoc_args['fields'] );
	}

	WP_CLI\Utils\format_items( $assoc_args['format'], $installations, $fields );

} );
