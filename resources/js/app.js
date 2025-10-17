import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import './style.css';

import $ from 'jquery'
window.jQuery = window.$ = $

import './template.js';

import App from './App.vue';
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import 'boxicons/css/boxicons.min.css';

import ElementPlus from 'element-plus';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';

const app = createApp(App);
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

app.use(router);
app.use(pinia);
app.use(ElementPlus);
app.mount('#app');





