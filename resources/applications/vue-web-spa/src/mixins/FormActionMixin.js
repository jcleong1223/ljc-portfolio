import cloneDeep from 'lodash/cloneDeep'
export const formActionMixin = {
	data() {
		return {
			form_dialog_ : false,
			form_item_: {},
			form_action_: null,
		}
	},
	methods:{
		emptyModel_(){
			return {}
		},
		archiveModel_(item){
			console.log("archiveModel_ :: remember to overwrite me.",item)
		},
		newItem_(item = {}){
			let model = this.cloneDeep_(item)
			this.bindAction_('new',model)
			this.form_dialog_ = true
		},
		editItem_(item = {}){
			let model = this.cloneDeep_(item)
			this.bindAction_('edit',model)
			this.form_dialog_ = true
		},
		duplicateItem_(item = {}){
			let model = this.cloneDeep_(item)
			this.form_item_.id = null
			this.bindAction_('new',model)
			this.form_dialog_ = true
		},
		bindAction_(action, item){
			this.form_action_ = action
			this.form_item_ = item
		},
		confirmArchive_(item){
			this.$swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
			}).then((res)=>{
				if(res.value){
					this.archiveModel_(item)
				}
			})
		},
		cloneDeep_(data){
			return cloneDeep(data)
		},
		
	}
}

