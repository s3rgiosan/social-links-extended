<?php

namespace S3S\WP\SocialLinksExtended;

/**
 * Single source of truth for the bundled icons.
 *
 * SVG markup lives in assets/icons/{slug}.svg. Labels live here so both the
 * Social Icons block (Plugin::register_services) and the Icon block (IconBlock)
 * share one definition.
 */
class Icons {

	/**
	 * Map of icon slugs to their translatable labels.
	 *
	 * @return array<string, string>
	 */
	public static function get_labels() {
		return [
			'kofi'           => _x( 'Ko-fi', 'social link name', 'social-links-extended' ),
			'phone'          => _x( 'Phone', 'social link name', 'social-links-extended' ),
			'signal'         => _x( 'Signal', 'social link name', 'social-links-extended' ),
			'boardgamearena' => _x( 'Board Game Arena', 'social link name', 'social-links-extended' ),
			'boardgamegeek'  => _x( 'Board Game Geek', 'social link name', 'social-links-extended' ),
			'imdb'           => _x( 'IMDb', 'social link name', 'social-links-extended' ),
			'letterboxd'     => _x( 'Letterboxd', 'social link name', 'social-links-extended' ),
			'calendly'       => _x( 'Calendly', 'social link name', 'social-links-extended' ),
			'calcom'         => _x( 'Cal.com', 'social link name', 'social-links-extended' ),
			'strava'         => _x( 'Strava', 'social link name', 'social-links-extended' ),
			'tripadvisor'    => _x( 'TripAdvisor', 'social link name', 'social-links-extended' ),
			'paypal'         => _x( 'PayPal', 'social link name', 'social-links-extended' ),
			'youtubemusic'   => _x( 'YouTube Music', 'social link name', 'social-links-extended' ),
			'applepodcasts'  => _x( 'Apple Podcasts', 'social link name', 'social-links-extended' ),
			'notion'         => _x( 'Notion', 'social link name', 'social-links-extended' ),
			'squarespace'    => _x( 'Squarespace', 'social link name', 'social-links-extended' ),
		];
	}

	/**
	 * Absolute path to the directory holding the bundled SVG files.
	 *
	 * @return string Trailing-slashed directory path.
	 */
	public static function get_dir() {
		return S3S_SOCIAL_LINKS_EXTENDED_PATH . 'assets/icons/';
	}

	/**
	 * Full icon data keyed by slug.
	 *
	 * Combines the labels with the SVG markup read from disk. Result is memoized
	 * for the request so the files are read once even when called by both the
	 * service registration and the editor localization.
	 *
	 * @return array<string, array{label: string, svg: string}>
	 */
	public static function get_data() {
		static $data = null;

		if ( null !== $data ) {
			return $data;
		}

		$data = [];

		foreach ( self::get_labels() as $slug => $label ) {
			$data[ $slug ] = [
				'label' => $label,
				'svg'   => self::read_file( self::get_dir() . "{$slug}.svg" ),
			];
		}

		return $data;
	}

	/**
	 * Read a file using WP_Filesystem.
	 *
	 * @param string $file Absolute path to the file.
	 * @return string File contents or empty string on failure.
	 */
	private static function read_file( $file ) {
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
