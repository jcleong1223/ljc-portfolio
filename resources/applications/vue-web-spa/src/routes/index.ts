import VueRouter, { RouteConfig } from 'vue-router'
import { setPageTitle } from '@src/libs/pageTitle'
import i18n from '@src/plugins/i18n'

import * as AuthModule from '@src/modules/auth/router'
import * as BaseModule from '@src/modules/base/router'
import * as _GeneralModule from '@src/modules/_general/router'
import AOS from 'aos';

// Layout
const BaseLayout = () => import('@src/layouts/BaseLayout.vue')
const SideBarBaseLayout = () => import('@src/layouts/SideBarBaseLayout.vue')

const routes : Array<RouteConfig> = [

	{ path: '/login', name: 'login', component: AuthModule.Login, meta: { auth: null, title: 'Login' } },
	{ path: '/password/reset/:token', name: 'reset-password', component: AuthModule.ResetPassword, meta: { auth: null, title: 'Reset Password' } },
	{ path: '/forgot-password', name: 'forgot-password', component: AuthModule.ForgotPassword, meta: { auth: null, title: 'Forgot Password' } },

	// { path: '/', name: 'landing-page', component: _GeneralModule.LandingPage, meta: { auth: null, title: 'Home' } },

	// base_layout
	{ path: '/', component: BaseLayout, children: [
		{
			path: '', component: SideBarBaseLayout, children: [
				{ path: '/', name: 'home-page', component: BaseModule.HomePortfolioPage, meta: { auth: null, title: i18n.t("home-page.meta-title") } },
				{ path: '/contact-me', name: 'contact-me', component: BaseModule.ContactMePage, meta: { auth: null, title: i18n.t("contact-us-page.meta-title") } },
				{ path: '/about-us', name: 'about-us', component: BaseModule.AboutUsPage, meta: { auth: null, title: i18n.t("about-us-page.meta-title") } },
				// { path: '/projects', name: 'projects', component: BaseModule.ProjectsPage, meta: {auth: null, title: i18n.t("projects-page.meta-title")}},
				{ path: '/capabilities', name: 'capabilities', component: BaseModule.CapabilitiesPage, meta: { auth: null, title: i18n.t("capabilities-page.meta-title") } },
				{ path: '/capabilities/:id', name: 'capability.info', component: BaseModule.CapabilityDetailPage, meta: { auth: null, title: i18n.t("capability-detail-page.meta-title") } },
				{ path: '/fabrications', name: 'fabrications', component: BaseModule.FabricationsPage, meta: { auth: null, title: i18n.t("fabrications-page.meta-title")}},
				{ path: '/careers', name: 'careers', component: BaseModule.CareerPage, meta: { auth: null, title: i18n.t("career-page.meta-title")}},
				{ path: '/career-detail/:id', name: 'career-detail', component: BaseModule.CareerDetailPage, meta: { auth: null, title: i18n.t("career-detail-page.meta-title")}},
				{ path: '/term-and-condition', name: 'term-condition-page', component: _GeneralModule.TermsAndConditionsPage, meta: {auth: null, title: i18n.t("term-condition-page.meta-title")} },
				{ path: '/privacy-policy', name: 'privacy-policy-page', component: _GeneralModule.PrivacyPolicy, meta: {auth: null, title: i18n.t("privacy-policy-page.meta-title")}},
			]
		},

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

// AOS will not work when changing routes without reloading the page, so need to add this
router.afterEach((to, from) => {
	setTimeout(() => {
		AOS.refresh();
	},800)
});


export default router
