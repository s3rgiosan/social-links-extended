/**
 * WordPress dependencies
 */
import { _x } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import {
	CalcomIcon,
	BoardGameArenaIcon,
	BoardGameGeekIcon,
	TripAdvisorIcon,
	PhoneIcon,
	ImdbIcon,
	KofiIcon,
	LetterboxdIcon,
	SignalIcon,
	YoutubeMusicIcon,
	PaypalIcon,
	NotionIcon,
	StravaIcon,
	ApplePodcastsIcon,
	CalendlyIcon,
	SquarespaceIcon,
} from './icons';

const variations = [
	{
		name: 'kofi',
		title: _x('Ko-fi', 'social link name', 'social-links-extended'),
		icon: KofiIcon,
	},
	{
		name: 'phone',
		title: _x('Phone', 'social link name', 'social-links-extended'),
		icon: PhoneIcon,
	},
	{
		name: 'signal',
		title: _x('Signal', 'social link name', 'social-links-extended'),
		icon: SignalIcon,
	},
	{
		name: 'boardgamearena',
		title: _x('Board Game Arena', 'social link name', 'social-links-extended'),
		icon: BoardGameArenaIcon,
	},
	{
		name: 'boardgamegeek',
		title: _x('Board Game Geek', 'social link name', 'social-links-extended'),
		icon: BoardGameGeekIcon,
	},
	{
		name: 'imdb',
		title: _x('IMDb', 'social link name', 'social-links-extended'),
		icon: ImdbIcon,
	},
	{
		name: 'letterboxd',
		title: _x('Letterboxd', 'social link name', 'social-links-extended'),
		icon: LetterboxdIcon,
	},
	{
		name: 'calendly',
		title: _x('Calendly', 'social link name', 'social-links-extended'),
		icon: CalendlyIcon,
	},
	{
		name: 'calcom',
		title: _x('Cal.com', 'social link name', 'social-links-extended'),
		icon: CalcomIcon,
	},
	{
		name: 'strava',
		title: _x('Strava', 'social link name', 'social-links-extended'),
		icon: StravaIcon,
	},
	{
		name: 'tripadvisor',
		title: _x('TripAdvisor', 'social link name', 'social-links-extended'),
		icon: TripAdvisorIcon,
	},
	{
		name: 'paypal',
		title: _x('PayPal', 'social link name', 'social-links-extended'),
		icon: PaypalIcon,
	},
	{
		name: 'youtubemusic',
		title: _x('YouTube Music', 'social link name', 'social-links-extended'),
		icon: YoutubeMusicIcon,
	},
	{
		name: 'applepodcasts',
		title: _x('Apple Podcasts', 'social link name', 'social-links-extended'),
		icon: ApplePodcastsIcon,
	},
	{
		name: 'notion',
		title: _x('Notion', 'social link name', 'social-links-extended'),
		icon: NotionIcon,
	},
	{
		name: 'squarespace',
		title: _x('Squarespace', 'social link name', 'social-links-extended'),
		icon: SquarespaceIcon,
	},
];

export default variations;
