import Vue from 'vue'

import Vuetify from 'vuetify/lib'

Vue.use(Vuetify);

export default new Vuetify({
	theme: {
		dark : false,
		themes: {
			light: {
				'primary': '#01847F',
				'secondary': '#FFFFFF',
				'background': '#F0F1F2',
				'background-x': '#E6E7E9',
				'opposite': '#202020',
				// 'custom-yellow': '#FFB300',
				// 'custom-blue': '#0B47CE',
			},
			dark: {
				'primary': '#01847F',
				'secondary': '#27282E',
				'background': '#232429',
				'background-x': '#2C313B',
				'opposite': '#FFFFFF',
				// 'custom-yellow': '#FFB300',
				// 'custom-blue': '#0B47CE',
			},
		},
	}
})