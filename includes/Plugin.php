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

		( new IconBlock() )->setup();
	}

	/**
	 * Register additional social networks on the server side.
	 *
	 * @param array $services Existing social networks.
	 * @return array Modified social networks.
	 */
	public function register_services( $services ) {

		foreach ( Icons::get_data() as $slug => $data ) {
			$services[ $slug ] = array(
				'name' => $data['label'],
				'icon' => $data['svg'],
			);
		}

		return $services;
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

		// Co-located with registration so the handle is guaranteed to exist; the
		// editor script reads these labels from the global. PHP is the single
		// source for the labels. Editor only.
		if ( is_admin() ) {
			wp_localize_script(
				'social-links-extended-editor-script',
				'socialLinksExtendedIcons',
				Icons::get_labels()
			);
		}

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
}
