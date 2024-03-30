import { defineStore } from 'pinia'

export const useScreenSizeStore = defineStore('screenSize', {
	state: () => {
		return {
			screenHeight: 0,
		}
	},
	actions: {
		syncViewHeight(){
			this.screenHeight = `${window.innerHeight}px`
		},
	},
})