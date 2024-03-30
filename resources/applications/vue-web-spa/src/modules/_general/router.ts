const ComingSoon = () => import( './views/Comingsoon.vue')
const Error404 = () => import( './views/404.vue')
const LandingPage = () => import( './views/LandingPage.vue')
const TermsAndConditionsPage = () => import('./views/TermsAndConditionsPage.vue')
const PrivacyPolicy = () => import('./views/PrivacyPolicy.vue')

export {
	ComingSoon,
	Error404,
	LandingPage,
	TermsAndConditionsPage,
	PrivacyPolicy
}