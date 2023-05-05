// import colors from 'vuetify/es5/util/colors'

import { ThemeDefinition } from "vuetify/lib/framework.mjs";

export const light: ThemeDefinition = {
    dark: false,
    colors: {
        background: "#FFFFFF",
        surface: "#FFFFFF",

        primary: "#fbd87f",
        "primary-light": "#ffd260",
        "primary-dark": "#ffc023",

        secondary: "#41c1ba",
        "secondary-light": "#78e9e3",
        "secondary-dark": "#19918b",

        error: "#D32F2F",
        info: "#2196F3",
        success: "#45CB85",
        warning: "#F9A825",
    },
};

export const dark: ThemeDefinition = {
    dark: true,
    colors: {
        background: "#121212",
        surface: "#121212",

        primary: "#6d6d6d",
        "primary-light": "#b2b2b2",
        "primary-dark": "#5e5d5d",

        secondary: "#AAADC4",
        "secondary-light": "#CFD1DE",
        "secondary-dark": "#6F749B",

        error: "#CF6679",
        info: "#2196F3",
        success: "#03DAC5",
        warning: "#F9A825",
    },
};
