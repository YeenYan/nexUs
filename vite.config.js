import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { resolve } from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                base: null,
                includesAbsolute: false,
            },
        }),
    ],
    resolve: {
        alias: {
            "@public": resolve(__dirname, "./public"),
            "@resource": resolve(__dirname, "./resources"),
            ziggy: resolve("vendor/tightenco/ziggy/dist/vue.es.js"),
        },
    },
});
