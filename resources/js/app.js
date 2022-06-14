/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue').default;
import vuetify from "./vuetify";
import * as d3 from "d3";
import {store} from "../../store";

window.d3 = d3;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('login-form', require('./components/LoginForm.vue').default);
Vue.component('admin-page', require('./components/AdminPage.vue').default);
Vue.component('teachers-presenter', require('./components/TeachersPresenter.vue').default);
Vue.component('disciplines-presenter', require('./components/DisciplinesPresenter.vue').default);
Vue.component('pair-infos-presenter', require('./components/PairInfosPresenter.vue').default);
Vue.component('science-ranks-presenter', require('./components/ScienceRanksPresenter.vue').default);
Vue.component('floors-presenter', require('./components/FloorsPresenter.vue').default);
Vue.component('floor-component', require('./components/FloorDrawer.vue').default);
Vue.component('auditoriums-presenter', require('./components/AuditoriumsPresenter.vue').default);
Vue.component('secondary-object-types-presenter', require('./components/SecondaryObjectTypesPresenter.vue').default);
Vue.component('secondary-objects-presenter', require('./components/SecondaryObjectsPresenter.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify,
    d3,
    store
});
