export const resourceMixin = {
	data() {
		return {
			view_item_ : {},
			view_dialog_ : false,
			model_loading_: false,
			settings_: {},
			totalData_ : 0,
			resourceData_ : {},
			resourceDataSet_ : [],
			options_ : {},

			filters_ : {},
			sort_: {},
			search_ : {
				search : null,
				searchBy : null,
			},
			isReady: false,
		}
	},
	watch: {
		"settings_": {
			handler(){
				if(this.isReady){
					this.getResourceData_()
				}else{
					this.isReady = true;
				}
			},
			deep: true,
		},
	},
	methods:{
		initialize_(){
			this.getResourceData_()
		},
		getAllRefs_(promiseList){
			return Promise.allSettled(promiseList)
		},
		row_classes_(item){
			if(item.deleted_at){
				return 'grey--text font-italic opacity-7'
			}
		},
		searchData_(){
			if(this.search_.search == ''){
				this.search_.search = null
			}
			this.settings_.page = 1
			this.getResourceData_()
		},
		getResourceData_(){
			console.log("getResourceData_ :: remember to overwrite me.")
		},
		viewMore_(item = {}){
			this.view_item_ = this.cloneDeep_(item)
			this.view_dialog_ = true
		},
		setPagination_(){
			const { page, itemsPerPage } = this.settings_
			let pagination = {
				"page": page,
				"itemsPerPage": itemsPerPage
			}
			return pagination;
		},
		getActivityRefs_(){
			return [
				{ 'value': 1, 'text': 'Active Only', },
				{ 'value': 0, 'text': 'Archived Only', },
				{ 'value': 2, 'text': 'All', },
			]
		},
		downloadFile_(url, fileName){
			let fileLink = document.createElement("a");
			fileLink.setAttribute("download", fileName);
			fileLink.setAttribute("href", url);
			document.body.appendChild(fileLink);
			fileLink.click();
			document.body.removeChild(fileLink);
		},
	}
}
