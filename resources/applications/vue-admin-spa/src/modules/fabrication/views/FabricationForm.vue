<template>
	<v-card class="radius-10">
		<v-card-title>
			<span class="text-h5">{{ (action == 'edit') ? 'Edit' : 'New' }} Fabrication</span>
		</v-card-title>
		<v-divider class="ma-0"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense class="form-gap-2">
				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.title"
						label="Title" placeholder="Title"
						dense
						:error-messages="errorCollector.title"
					></v-text-field>
				</v-col>
				<v-col cols="12" md="7">
					<w-image-input-field
						v-model="dataForm.image"
						label="Preview Image (1:1)"
						:ratio="1"
						:width="120"
						:error-messages="errorCollector.image"
						class="pb-2"
					>
					</w-image-input-field>
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
				<v-col cols="12" md="12">
					<w-image-input-field
						v-model="dataForm.media_contents"
						label="Media Contents (1:1)"
						:ratio="1"
						:width="120"
						:multiple="6"
						:error-messages="errorCollector.media_contents"
					></w-image-input-field>
				</v-col>
				<v-col cols="12" md="12">
					<v-select
						v-model="dataForm.status"
						:items="[
							{ text : 'Active' , value : 1 },
							{ text :'Inactive' , value : 0 }
						]"
						item-value="value"
						item-text="text"
						label="Status" placeholder="Status"
						dense
						:error-messages="errorCollector.status"
					></v-select>
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
import FabricationClient from '../client'
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
				if(this.dataForm.status == null){
					this.dataForm.status = 1;
				}
				if(this.dataForm.seq_value == null){
					this.dataForm.seq_value = 1;
				}
				if(this.dataForm.media_contents){
					this.dataForm.media_contents = this.dataForm.media_contents.map((item)=>{
						item.file_url = item.content.file_url
						return item
					})
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
			payload.append("title", item.title ?? '')
			payload.append("seq_value", item.seq_value ?? '')
			payload.append("status", item.status ?? '')
			if(item.image){
				payload.append("image", item.image instanceof File ? item.image : item.image.id)
			}

			if(item.media_contents){
				item.media_contents.forEach((item, key)=>{
					payload.append(`media_contents[${key}]`, item instanceof File ? item : item.id)
				})
			}

			let theApi = (this.action == "new") ? FabricationClient.createFabrication(payload) : FabricationClient.updateFabrication(payload)
			theApi.then((res)=>{
				this.$toast.success(res.data.message)
				this.initialize()
			}).catch((err)=>{
				this.errorCollector = this.errorHandler_(err, [
					'seq_value',
					'title',
					'status',
					'image',
				])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
	}
}
</script>
