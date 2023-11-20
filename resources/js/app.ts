import './bootstrap';
import './font-awesome';
import '../css/app.css';

import { createApp, h } from 'vue';
import type { DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { i18nVue } from 'laravel-vue-i18n';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
	title: (title) => `${title} - ${appName}`,
	resolve: (name) => resolvePageComponent(
		`./Pages/${name}.vue`,
		import.meta.glob<DefineComponent>('./Pages/**/*.vue')
	),
	// @ts-ignore
	setup({ el, App, props, plugin }) {
		return createApp({ render: () => h(App, props) })
			.use(plugin)
			.use(ZiggyVue, (window as any).Ziggy)
			.use(i18nVue, {
				resolve: async lang => {
					const langs = import.meta.glob('../../lang/*.json');
					return await langs[`../../lang/${lang}.json`]();
				}
			})
			.component('font-awesome-icon', FontAwesomeIcon)
			.mount(el);
	},
	progress: {
		color: '#4B5563',
	},
});
