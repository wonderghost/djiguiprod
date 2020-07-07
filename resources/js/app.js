/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
window.axios = require('axios')


Vue.component('home-component',require('./components/HomeComponent.vue').default)
Vue.component('header-component',require('./components/HeaderComponent.vue').default)
Vue.component('footer-component',require('./components/FooterComponent.vue').default)
Vue.component('news-home',require('./components/NewsHomeComponent.vue').default)
Vue.component('add-article',require('./components/AddArticleComponent.vue').default)
Vue.component('news-detail',require('./components/NewsDetailComponent.vue').default)
Vue.component('users',require('./components/UserComponent.vue').default)
Vue.component('category-news',require('./components/CategoryNewsComponent.vue').default)
Vue.component('contact-form',require('./components/ContactComponent.vue').default)
Vue.component('manage-page',require('./components/PageManagementComponent.vue').default)
Vue.component('prestation-page',require('./components/PrestationComponent.vue').default)
Vue.component('login-tag',require('./components/LoginComponent.vue').default)
Vue.component('footer-news',require('./components/FooterNewsComponent.vue').default)
Vue.component('about-us',require('./components/AboutUsComponent.vue').default)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue'
import Vuex from 'vuex'
import store from './store'

Vue.use(Vuex)

const app = new Vue({
    el: '#app',
    store
});
