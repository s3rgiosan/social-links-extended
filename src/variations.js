/**
 * Translatable labels, keyed by icon slug.
 */
const labels = window.socialLinksExtendedIcons ?? {};

/**
 * Icon components, sourced from the bundled SVG files (assets/icons/*.svg).
 *
 * The build runs SVG imports through svgr (see webpack.config.js), so each file
 * resolves to a React component. This keeps the SVG markup as a single source
 * of truth shared with the PHP side.
 */
const iconContext = require.context('../assets/icons', false, /\.svg$/);
const icons = iconContext.keys().reduce((acc, key) => {
	const slug = key.replace(/^\.\//, '').replace(/\.svg$/, '');
	acc[slug] = iconContext(key).ReactComponent;
	return acc;
}, {});

const variations = Object.entries(labels).map(([name, title]) => ({
	name,
	title,
	icon: icons[name],
}));

export default variations;
