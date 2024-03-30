export const searchMixin = {
	methods:{
		searchWithTimer_(second = 1){
			if (this.timer) {
				clearTimeout(this.timer);
				this.timer = null;
			}
			this.timer = setTimeout(() => {
				this.searchData()
			}, 1000 * second);
		},
	}
}