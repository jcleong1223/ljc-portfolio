import './plugins/bootstrap'
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-toast-notification/dist/theme-default.css';
import { createPinia, PiniaVuePlugin } from 'pinia'
import * as AuthManager from "@src/libs/AuthManager.js"
// import * as GmapVue from 'gmap-vue'
import appConfig from './config/app'
import auth from './plugins/auth'
import axios from 'axios'
import dayjs from 'dayjs'
import indexVue from './app.vue'
import router from './routes/index'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import VueSweetalert2 from 'vue-sweetalert2';
import vuetifyInstance from './plugins/Vuetify'
import VueToast from 'vue-toast-notification';

// Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
const originalPush = VueRouter.prototype.push;
// # override router.push() error "Avoided redundant navigation to current location"
VueRouter.prototype.push = function push(location) {
	return originalPush.call(this, location).catch(err => err)
};
Vue.use(VueRouter)

// Set Vue authentication
Vue.use(VueAxios, axios)
const baseurl = window.location.protocol + "//" + window.location.host;
axios.defaults.baseURL = baseurl+"/api"
axios.defaults.headers.common['app-version'] = appConfig.version;

Vue.use(VueAuth, auth)

// Vue.use(GmapVue, {
// 	load: {
// 		key: 'some-key',
// 		libraries: 'places',
// 	},
// 	installComponents: true
// })

Vue.use(VueToast);

Vue.use(VueSweetalert2, {
	confirmButtonColor: '#4caf50',
	cancelButtonColor: '#ff5252',
	customClass : {
		container : "swal2-backdrop-show swal2-center swal2-container v-application",
		popup: "swal2-icon-warning swal2-modal swal2-popup swal2-show background-x",
		title: 'swal2-title opposite--text',
		htmlContainer: 'swal2-html-container opposite--text',
		input: 'opposite--text'
	}
});

Vue.use(PiniaVuePlugin)
const pinia = createPinia()

// Prototype
Vue.prototype.$config = appConfig
Vue.prototype.$dayjs = dayjs
Vue.prototype.$authManager = AuthManager

// initialize vue app
new Vue({
	router,
	vuetify: vuetifyInstance,
	pinia,
	render: (h) => h(indexVue),
}).$mount("#app");