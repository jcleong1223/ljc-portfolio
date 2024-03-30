import VueRouter, { RouteConfig } from 'vue-router'
import { setPageTitle } from '@src/libs/pageTitle'
import i18n from '@src/plugins/i18n'

import * as AuthModule from '@src/modules/auth/router'
import * as BaseModule from '@src/modules/base/router'
import * as _GeneralModule from '@src/modules/_general/router'

// Layout
const BaseLayout = () => import('@src/layouts/BaseLayout.vue')

const routes : Array<RouteConfig> = [

	{ path: '/login', name: 'login', component: AuthModule.Login, meta: { auth: null, title: 'Login' } },
	{ path: '/password/reset/:token', name: 'reset-password', component: AuthModule.ResetPassword, meta: { auth: null, title: 'Reset Password' } },
	{ path: '/forgot-password', name: 'forgot-password', component: AuthModule.ForgotPassword, meta: { auth: null, title: 'Forgot Password' } },

	{ path: '/', name: 'landing-page', component: _GeneralModule.LandingPage, meta: { auth: null, title: 'Home' } },

	// base_layout
	{ path: '/home', component: BaseLayout, children: [
		{ path: '/home', name: 'home-page', component: BaseModule.HomePage, meta: { auth: null, title: i18n.t("home-page.meta-title") } },
		{ path: '/contact-us', name: 'contact-us', component: BaseModule.ContactUsPage, meta: { auth: null, title: i18n.t("contact-us-page.meta-title") } },
	]},

	{ path: '/coming-soon', name: 'coming-soon', component: _GeneralModule.ComingSoon, meta: { auth: null, title: 'Coming Soon' } },
	{ path: '*', name: '404', component: _GeneralModule.Error404, meta: { auth: null, title: '404' } }, // must put last

]

const router = new VueRouter({
	mode: 'history',
	routes,
})

router.beforeEach((to, from, next) => {
	setPageTitle(to.meta.title)
	window.scrollTo(0, 0);
	next()
});

export default router
