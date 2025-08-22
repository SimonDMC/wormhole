import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    server: {
        hmr: {
            // host: "192.168.60.115",
        },
        cors: {
            /* add http://192.168.60.115:8000 */
            origin: /^(https?:\/\/(?:(?:[^:]+\.)?localhost|127\.0\.0\.1|\[::1\])(?::\d+)?)|(http:\/\/192\.168\.60\.115:8000)$/,
        },
    },
    plugins: [
        laravel({
            input: ["resources/js/app.ts"],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
