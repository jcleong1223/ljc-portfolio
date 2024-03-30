<template>
	<v-card v-if="visible" class="radius-10">
		<v-card-title>
			<span class="headline">{{ (action == 'edit') ? 'Edit Product Category' : 'Create Product Category' }}</span>
		</v-card-title>
		<v-divider class="mb-2"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense class="form-gap-2">
				<v-col cols="12" md="12">
					<v-text-field
						v-model="form.name"
						label="Name" placeholder="Name"
						dense
						:error-messages="errors.name"
					></v-text-field>
				</v-col>
				<v-col cols="12" md="12">
					<v-text-field
						v-model.number="form.seq_value"
						label="Seq Value (Lowest to Largest)"
						type="number" step="1"
						dense
						:error-messages="errors.seq_value"
					></v-text-field>
				</v-col>
			</v-row>
		</v-card-text>
		<v-card-actions>
			<v-spacer></v-spacer>
			<v-btn
				color="blue darken-1" text title="Cancel"
				@click="closeDialog()"
			>
				Cancel
			</v-btn>
			<v-btn
				color="blue darken-1"
				text title="Save"
				:loading="submit_loading"
				@click="submitForm(form)"
			>
				Save
			</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import ProductCategoryClient from '../client'

export default{
	components:{
	},
	mixins: [
		errorHandlerMixin
	],
	props:{
		visible: {
			type: Boolean,
			required: true,
		},
		item: {
			type: Object,
			required: true,
			default: ()=>{
				return {}
			}
		},
		action: {
			type: String,
			required: true,
		},
	},
	data () {
		return {
			form : {},
			errors : {},
			submit_loading : false,
			product_category_search: {
				result: [],
				total: null,
				loading: false,
				dialog: false
			},
		}
	},
	watch:{
		'item':{
			handler(){
				this.form = this.item
				if(this.form.seq_value == null){
					this.form.seq_value = 1;
				}
			},
			immediate: true,
		},
		'visible':{
			handler: function (newVal){
				if(newVal){
					//
				}else{
					// reset
					this.form = {}
					this.errors = {}
				}
			},
			immediate : true,
		},
	},
	created(){
	},
	methods: {
		initialize(){
			this.closeDialog()
			this.$emit('initialize')
		},
		closeDialog(){
			this.$emit('update:visible', false)
		},
		submitForm(item){
			this.saveModel(item)
		},
		saveModel(item){
			this.submit_loading = true
			this.errors = {}

			let payload = item
			let theApi = (this.action == "new") ? ProductCategoryClient.createProductCategory(payload) : ProductCategoryClient.updateProductCategory(payload)

			theApi.then((res)=>{
				this.$toast.success(res.data.message)
				this.initialize()
				this.image_val = null;
			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					"name",
					'seq_value',
				])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
		searchProductCategory(w_payload){
			let payload = {
				page: w_payload.page,
				itemsPerPage: w_payload.itemsPerPage,
				search: w_payload.search,
				searchBy: "name",
			}
			this.product_category_search.loading = true
			this.$api.getProductCategoryList(payload).then((res)=>{
				this.product_category_search.data_object = res.data.data
			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.product_category_search.loading = false
			})
		},

	}
}
</script>
