import { defineNuxtConfig } from "nuxt/config";
import vuetify, { transformAssetUrls } from "vite-plugin-vuetify";

// https://v3.nuxtjs.org/api/configuration/nuxt.config
export default defineNuxtConfig({
    app: {
        head: {
            title: "Toonie",
        },
    },

    build: {
        transpile: ["vuetify"],
    },

    css: [
        "assets/main.css",
        "assets/main.scss",
        "vuetify/lib/styles/main.sass",
        "@mdi/font/css/materialdesignicons.min.css",
    ],

    modules: [
        (_options, nuxt) => {
            nuxt.hooks.hook("vite:extendConfig", (config) => {
                // @ts-expect-error
                config.plugins.push(vuetify({ autoImport: true }));
            });
        },
        "@pinia/nuxt",
    ],

    vite: {
        vue: {
            template: {
                transformAssetUrls,
            },
        },
    },

    runtimeConfig: {
        public: {
            backendUrl: "http://localhost:8000",
            frontendUrl: "http://localhost:3000",
            title: "Toonie",
        },
    },

    imports: {
        dirs: ["./utils", "./stores"],
    },

    pinia: {
        autoImports: ["defineStore", "acceptHMRUpdate"],
    },
});
