
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

import Vue from 'vue'

import VueProgressBar from './router/vueProgressBar.js'

import App from './App/App.vue'

import router from './router'

import store from './vuex'

import AuthPersistence from './plugins/AuthPersistence/'

Vue.use(AuthPersistence, store)

Vue.component('vue-table', require('./components/VueTable.vue'))

const app = new Vue({
  router,
  store,
  mode: 'history',
  render: h => h(App)  
}).$mount('#app')
