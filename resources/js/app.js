/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import 'bootstrap';
global.$ = global.jQuery = require('jquery');

window.Vue = require('vue');
window.axios = require('axios');

import VueRouter from 'vue-router'

Vue.use(VueRouter);

const example = require('./components/SampleComponent.vue').default;
const tasks = require('./components/TaskComponent.vue').default;

const routes =[
    {
        path : "/",
        component : tasks
    },
    {
        path : "/example",
        component : example
    }
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: '#app',
    router,
});




