require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import Multiselect from 'vue-multiselect'

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(Vuetify);



// register globally
Vue.component('multiselect', Multiselect)

const app = document.getElementById('app');

new Vue({
    vuetify: new Vuetify(),
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./components/${name}`).default,
            },
        }),
}).$mount(app);
