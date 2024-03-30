<template>
	<v-card class="radius-10">
		<v-card-title>
			<span class="text-h5">{{ (action == 'edit') ? 'Edit' : 'New' }} Banner</span>
		</v-card-title>
		<v-divider class="ma-0"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense class="form-gap-2">
				<v-col cols="12" md="6">
					<w-image-input-field
						v-model="dataForm.web_image"
						label="Web Image (16:9)"
						:ratio="16/9"
						:width="160"
						:error-messages="errorCollector.web_image"
					></w-image-input-field>
				</v-col>
				<v-col cols="12" md="6">
					<w-image-input-field
						v-model="dataForm.mobile_image"
						label="Mobile Image (4:3)"
						:ratio="4/3"
						:error-messages="errorCollector.mobile_image"
					></w-image-input-field>
				</v-col>
				<v-col cols="12" md="12">
					<v-text-field
						v-model.number="dataForm.seq_value"
						label="Sequence (Largest to Lowest)"
						type="number" step="1"
						dense
						:error-messages="errorCollector.seq_value"
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
				@click="submitForm(dataForm)"
			>
				Save
			</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import BannerClient from '../client'
import WImageInputField from '@shared/widgets/FileUpload/WImageInputField.vue'
export default{
	components:{
		WImageInputField,
	},
	mixins: [
		errorHandlerMixin,
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
			dataForm : {},
			errorCollector : {},
			submit_loading : false,
		}
	},
	watch:{
		'item':{
			handler(){
				this.dataForm = this.item
				if(this.dataForm.seq_value == null){
					this.dataForm.seq_value = 1;
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
					this.errorCollector = {}
					this.submit_loading = false
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
			this.errorCollector = {}
			this.saveModel(item)
		},
		saveModel(item){
			this.submit_loading = true
			let payload = new FormData()
			payload.append("id", item.id)
			payload.append("seq_value", item.seq_value)
			if(item.web_image){
				payload.append("web_image", item.web_image instanceof File ? item.web_image : item.web_image.id)
			}
			if(item.mobile_image){
				payload.append("mobile_image", item.mobile_image instanceof File ? item.mobile_image : item.mobile_image.id)
			}

			let theApi = (this.action == "new") ? BannerClient.create(payload) : BannerClient.update(payload)
			theApi.then((res)=>{
				this.$toast.success(res.data.message)
				this.initialize()
			}).catch((err)=>{
				this.errorCollector = this.errorHandler_(err, [
					'web_image',
					'mobile_image',
					'seq_value',
				])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
	}
}
</script>