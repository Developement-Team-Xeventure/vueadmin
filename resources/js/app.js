import './plugins/main';
import './bootstrap';

import "bootstrap/dist/js/bootstrap.min.js"
import '@fortawesome/fontawesome-free/css/all.css';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'

import App from './App.vue';
import router from './router';
import Vuex from 'vuex';

// Global variables and functions
import helper from './helper/helper';
import global from './helper/global';

import "vuetify/styles";
import { createVuetify  } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";




import Auth from './Auth.js';

const applicationTheme = {
    dark: false,
    colors: {
      background: '#FFFFFF',
      surface: '#FFFFFF',

      primary: '#007bff',
      secondary: '#6c757d',
      success:' #28a745',
      info: '#17a2b8',
      warning:' #ffc107',
      danger: '#dc3545',

      error: '#B00020',
      info: '#2196F3',
      success: '#4CAF50',
      warning: '#FB8C00',
    },
  }

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'applicationTheme',
        themes: {
            applicationTheme,
        },
    },
});


import helperStore from './store';

const app = createApp(App);

app.use(Vuex)
.use(vuetify)
.use(Auth)
.use(router)
.use(global)
.use(helperStore)
.use(LaravelPermissionToVueJS)
.mixin(helper)
.mount("#app");



