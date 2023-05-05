import { defineNuxtConfig } from 'nuxt/config';

// https://v3.nuxtjs.org/api/configuration/nuxt.config
export default defineNuxtConfig({
	app: {
		head: {
			title: 'BaseApp',
		},
	},

	build: {
		transpile: ['vuetify'],
	},

	css: [
		'vuetify/lib/styles/main.sass',
		'@mdi/font/css/materialdesignicons.min.css',
	],

	modules: ['@pinia/nuxt'],

	runtimeConfig: {
		public: {
			backendUrl: 'http://localhost:8000',
			frontendUrl: 'http://localhost:3000',
		},
	},

	imports: {
		dirs: ['./utils', './stores'],
	},

	pinia: {
		autoImports: ['defineStore', 'acceptHMRUpdate'],
	},
});
