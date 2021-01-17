require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', component: require('./components/index.vue').default },
  ]
})

const app = new Vue({
  el: '#app',
  router
})