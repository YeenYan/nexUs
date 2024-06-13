import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { ZiggyVue } from "ziggy";
import store from "./store";
import "../css/app.css";
import AOS from "aos";
import "aos/dist/aos.css"; // You can also use <link> for styles
// ..
AOS.init();

InertiaProgress.init({
    delay: 0,
    color: "#d946ef",
    includeCSS: true,
    showSpinner: true,
});

createInertiaApp({
    progress: false,
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue");

        return await pages[`./Pages/${name}.vue`]();
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(store)
            .mount(el);
    },
});
