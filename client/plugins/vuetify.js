import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { light, dark } from "../assets/appThemes";
import DayJsAdapter from "@date-io/dayjs";

export default defineNuxtPlugin((nuxtApp) => {
    const vuetify = createVuetify({
        ssr: true,
        components: {
            ...components,
        },
        date: {
            adapter: DayJsAdapter,
        },
        directives,
        customVariables: ["~/assets/variables.scss"],
        theme: {
            defaultTheme: "light",
            themes: {
                dark,
                light,
            },
        },
    });

    nuxtApp.vueApp.use(vuetify);
});
