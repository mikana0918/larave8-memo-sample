require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import vuetify from './plugins/vuetify'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueRouter)
Vue.use(VueAxios, axios)

const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', component: require('./components/index.vue').default },
  ]
})

const app = new Vue({
  el: '#app',
  router,
  vuetify,
})