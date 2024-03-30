import Vue from 'vue'

import VueI18n from 'vue-i18n'
import Cookies from 'js-cookie'
import lang from "@src/lang/index";

Vue.use(VueI18n)

const locale = Cookies.get('locale')

export function loadLocaleMessages() {
	// console.log(lang)
	return lang
}

export default new VueI18n({
	locale: locale || 'en',
	fallbackLocale: 'en',
	messages: loadLocaleMessages()
})