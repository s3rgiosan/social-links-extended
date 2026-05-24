const defaultConfig = require('@wordpress/scripts/config/webpack.config');

/**
 * Allow SVGs to be imported as React components from anywhere, including
 * require.context() (whose synthetic module is neither a JS nor a CSS issuer,
 * so the default @svgr rule skips it).
 *
 * No CSS in this project imports SVGs, so dropping the issuer restriction is
 * safe. This lets src/variations.js auto-discover the bundled icons in
 * assets/icons/*.svg instead of maintaining a hand-written import list.
 */
const svgRule = defaultConfig.module.rules.find(
	(rule) => rule.test && rule.test.toString() === /\.svg$/.toString() && Array.isArray(rule.use),
);

if (svgRule) {
	delete svgRule.issuer;
}

module.exports = defaultConfig;
