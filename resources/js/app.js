import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueNotify from 'vue-notifyjs'
import VeeValidate from 'vee-validate'
import lang from 'element-ui/lib/locale/lang/es'
import locale from 'element-ui/lib/locale'
import veeSpanish from 'vee-validate/dist/locale/es'

// Plugins

// router setup
import routes from './routes/routes'

// VueResource http ajax
import VueResource from 'vue-resource'
// library imports

// plugin setup
Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(VueNotify)
// Vue.use(SideBar, {sidebarLinks: sidebarLinks})
Vue.use(VeeValidate, {
    locale: 'es',
    dictionary: {
        es: veeSpanish
    }
});
locale.use(lang)


require('./bootstrap');

/* eslint-disable no-new */
const router = new VueRouter({
  routes, // short for routes: routes
  linkActiveClass: 'active'
});

/* eslint-disable no-new */
new Vue({
  el: '#app',
  render: h => h(App),
  router
});