import Vue from 'vue'

import Vuetify from 'vuetify/lib'

Vue.use(Vuetify);

export default new Vuetify({
	theme: {
		dark : true,
		themes: {
			light: {
				'primary': '#527853',
				'secondary': '#FFFFFF',
				// 'tertiary' : '#3EA6FF',
				'background': '#F0F1F2',
				'background-x': '#E6E7E9',
				'opposite': '#202020',
			},
			dark: {
				'primary': '#527853',
				'secondary': '#27282E',
				// 'tertiary' : '#3EA6FF',
				'background': '#232429',
				'background-x': '#2C313B',
				'opposite': '#FFFFFF',
			},
		},
	},
})