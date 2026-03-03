<?php

namespace S3S\WP\SocialLinksExtended;

class Plugin {

	/**
	 * Plugin singleton instance.
	 *
	 * @var Plugin $instance Plugin Singleton instance
	 */
	public static $instance = null;

	/**
	 * Get the singleton instance.
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Setup hooks.
	 */
	public function setup() {
		add_filter( 'block_core_social_link_get_services', [ $this, 'register_services' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_assets' ] );
		add_filter( 'block_type_metadata', [ $this, 'block_metadata' ] );
	}

	/**
	 * Register additional social networks on the server side.
	 *
	 * @param array $services Existing social networks.
	 * @return array Modified social networks.
	 */
	public function register_services( $services ) {

		$icons_dir = S3S_SOCIAL_LINKS_EXTENDED_PATH . 'assets/icons/';

		$custom_services = array(
			'kofi'           => array(
				'name' => _x( 'Ko-fi', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'kofi.svg' ),
			),
			'phone'          => array(
				'name' => _x( 'Phone', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'phone.svg' ),
			),
			'signal'         => array(
				'name' => _x( 'Signal', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'signal.svg' ),
			),
			'boardgamearena' => array(
				'name' => _x( 'Board Game Arena', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'boardgamearena.svg' ),
			),
			'boardgamegeek'  => array(
				'name' => _x( 'Board Game Geek', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'boardgamegeek.svg' ),
			),
			'imdb'           => array(
				'name' => _x( 'IMDb', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'imdb.svg' ),
			),
			'letterboxd'     => array(
				'name' => _x( 'Letterboxd', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'letterboxd.svg' ),
			),
			'calendly'       => array(
				'name' => _x( 'Calendly', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'calendly.svg' ),
			),
			'calcom'         => array(
				'name' => _x( 'Cal.com', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'calcom.svg' ),
			),
			'strava'         => array(
				'name' => _x( 'Strava', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'strava.svg' ),
			),
			'tripadvisor'    => array(
				'name' => _x( 'TripAdvisor', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'tripadvisor.svg' ),
			),
			'paypal'         => array(
				'name' => _x( 'PayPal', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'paypal.svg' ),
			),
			'youtubemusic'   => array(
				'name' => _x( 'YouTube Music', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'youtubemusic.svg' ),
			),
			'applepodcasts'  => array(
				'name' => _x( 'Apple Podcasts', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'applepodcasts.svg' ),
			),
			'notion'         => array(
				'name' => _x( 'Notion', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'notion.svg' ),
			),
			'squarespace'    => array(
				'name' => _x( 'Squarespace', 'social link name', 'social-links-extended' ),
				'icon' => $this->read_file( $icons_dir . 'squarespace.svg' ),
			),
		);

		return array_merge( $services, $custom_services );
	}

	/**
	 * Register assets for the block.
	 *
	 * @return void
	 */
	public function enqueue_assets() {

		$asset_file = sprintf(
			'%s/build/index.asset.php',
			untrailingslashit( S3S_SOCIAL_LINKS_EXTENDED_PATH )
		);

		$asset        = file_exists( $asset_file ) ? require $asset_file : null;
		$dependencies = isset( $asset['dependencies'] ) ? $asset['dependencies'] : [];
		$version      = isset( $asset['version'] ) ? $asset['version'] : filemtime( $asset_file );

		wp_register_script(
			'social-links-extended-editor-script',
			sprintf(
				'%s/build/index.js',
				untrailingslashit( S3S_SOCIAL_LINKS_EXTENDED_URL )
			),
			$dependencies,
			$version,
			true
		);

		wp_set_script_translations( 'social-links-extended-editor-script', 'social-links-extended' );

		wp_register_style(
			'social-links-extended-style',
			S3S_SOCIAL_LINKS_EXTENDED_URL . 'assets/style.css',
			[],
			$version,
		);
	}

	/**
	 * Attach assets to the Social Links block.
	 *
	 * @param  array $metadata Metadata for registering a block type.
	 * @return array
	 */
	public function block_metadata( $metadata ) {

		if ( empty( $metadata['name'] ) ) {
			return $metadata;
		}

		if ( 'core/social-links' !== $metadata['name'] ) {
			return $metadata;
		}

		$field_mappings = [
			'editorScript' => 'editor-script',
			'style'        => 'style',
		];

		foreach ( $field_mappings as $field_name => $asset_handle ) {

			if ( ! isset( $metadata[ $field_name ] ) ) {
				$metadata[ $field_name ] = [];
			}

			if ( ! is_array( $metadata[ $field_name ] ) ) {
				$metadata[ $field_name ] = [ $metadata[ $field_name ] ];
			}

			$metadata[ $field_name ][] = "social-links-extended-$asset_handle";
		}

		return $metadata;
	}

	/**
	 * Read a file using WP_Filesystem.
	 *
	 * @param string $file Absolute path to the file.
	 * @return string File contents or empty string on failure.
	 */
	private function read_file( $file ) {
		global $wp_filesystem;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! WP_Filesystem() ) {
			return '';
		}

		return (string) $wp_filesystem->get_contents( $file );
	}
}
