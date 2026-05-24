<?php

namespace S3S\WP\SocialLinksExtended;

/**
 * Integrates the bundled icons with the core Icon block.
 *
 * Requires the Icons Extended plugin (https://github.com/s3rgiosan/icons-extended).
 * The registry filter only fires when that plugin is active, so this integration
 * is a no-op otherwise.
 */
class IconBlock {

	/**
	 * Icon namespace used for the registry slugs.
	 *
	 * @var string
	 */
	const NAMESPACE = 'social-links-extended';

	/**
	 * Setup hooks.
	 */
	public function setup() {
		add_filter( 's3s_icons_registry', [ $this, 'register_icons' ] );
	}

	/**
	 * Register the bundled icons against the core Icon block picker.
	 *
	 * @param array $icons Existing registry.
	 * @return array Modified registry.
	 */
	public function register_icons( $icons ) {

		foreach ( Icons::get_labels() as $slug => $label ) {
			$icons[ self::NAMESPACE . "/{$slug}" ] = [
				'label' => $label,
				'file'  => Icons::get_dir() . "{$slug}.svg",
			];
		}

		return $icons;
	}
}
