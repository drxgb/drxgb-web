import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./vendor/laravel/jetstream/**/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.vue',
	],
	darkMode: 'class',
	theme: {
		extend: {
			animation: {
				'heart': 'heart 1s ease-in-out infinite',
			},
			backgroundImage: {
				'hero-pattern': "url('/img/bg/1.png')",
			},
			colors: {
				google: '#4285F4',
				twitch: '#9146FF',
				youtube: '#FF0000',
				github: '#000000',
				twitter: '#000000',
				itchio: '#FA5C5C',
			},
			fontFamily: {
				sans: ['Ubuntu', ...defaultTheme.fontFamily.sans],
			},
			keyframes: {
				heart: {
					'0%,100%': {scale: '100%'},
					'50%': {scale: '110%'},
				},
			},
		},
	},
	plugins: [
		forms,
		typography,
	],
};
