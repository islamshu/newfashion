import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import '#/assets/css/bootstrap.rtl.min.css';
import '#/assets/css/bootstrap-icons.css';
import '#/assets/css/all.min.css';
import '#/assets/css/nice-select.css';
import '#/assets/css/animate.min.css';
import '#/assets/css/jquery.fancybox.min.css';
import '#/assets/css/fontawesome.min.css';
import '#/assets/css/boxicons.min.css';
import '#/assets/css/swiper-bundle.min.css';
import '#/assets/css/slick-theme.css';
import '#/assets/css/slick.css';
import '#/assets/css/style.css';
import '#/assets/css/style-rtl.css';

createInertiaApp({
    resolve: (name) => {
        const pages =
            import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
});