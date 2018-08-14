// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import IdleVue from 'idle-vue'

import GSignInButton from 'vue-google-signin-button'
Vue.use(GSignInButton)

import VueResource from 'vue-resource'
Vue.use(VueResource)

import FullCalendar from 'vue-full-calendar'
Vue.use(FullCalendar);

const eventsHub = new Vue()
 
Vue.use(IdleVue, {
  eventEmitter: eventsHub,
  idleTime: 1000*30*60
})
/**

Vue.config.productionTip = false


/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
