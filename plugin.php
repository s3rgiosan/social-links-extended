<?php
/**
 * Plugin Name:       Social Links Extended
 * Description:       Extends the Social Icons block with additional features.
 * Plugin URI:        https://github.com/s3rgiosan/social-links-extended
 * Requires at least: 6.9
 * Requires PHP:      7.4
 * Version:           1.0.0
 * Author:            Sérgio Santos
 * Author URI:        https://s3rgiosan.dev/?utm_source=wp-plugins&utm_medium=social-links-extended&utm_campaign=author-uri
 * License:           GPL-3.0-or-later
 * License URI:       https://spdx.org/licenses/GPL-3.0-or-later.html
 * Update URI:        https://s3rgiosan.dev/
 * GitHub Plugin URI: https://github.com/s3rgiosan/social-links-extended
 * Text Domain:       social-links-extended
 */

namespace S3S\WP\SocialLinksExtended;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'S3S_SOCIAL_LINKS_EXTENDED_PATH', plugin_dir_path( __FILE__ ) );
define( 'S3S_SOCIAL_LINKS_EXTENDED_URL', plugin_dir_url( __FILE__ ) );

if ( file_exists( S3S_SOCIAL_LINKS_EXTENDED_PATH . 'vendor/autoload.php' ) ) {
	require_once S3S_SOCIAL_LINKS_EXTENDED_PATH . 'vendor/autoload.php';
}

PucFactory::buildUpdateChecker(
	'https://github.com/s3rgiosan/social-links-extended/',
	__FILE__,
	'social-links-extended'
);

( Plugin::get_instance() )->setup();
