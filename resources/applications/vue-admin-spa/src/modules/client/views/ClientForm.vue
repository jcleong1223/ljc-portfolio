<template>
	<v-card class="radius-10">
		<v-card-title>
			<span class="text-h5">{{ (action == 'edit') ? 'Edit' : 'New' }} Client</span>
		</v-card-title>
		<v-divider class="ma-0"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense class="form-gap-2">
				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.name"
						label="Name" placeholder="Name"
						dense
						:error-messages="errorCollector.name"
					></v-text-field>
				</v-col>
				<v-col cols="12" md="12">
					<w-image-input-field
						v-model="dataForm.web_image"
						label="Image (16:9)"
						:ratio="16/9"
						:width="160"
						:error-messages="errorCollector.web_image"
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
				<v-col cols="12" md="12">
					<v-select
						v-model="dataForm.status"
						:items="[
							{ text: 'Active', value: 1 },
							{ text: 'Inactive', value : 0 }
						]"
						item-text="text"
						item-value="value"
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
import ClientClient from '../client'
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
			payload.append("name", item.name)
			payload.append("seq_value", item.seq_value ?? '')
			payload.append("status", item.status ?? '');
			if(item.web_image){
				payload.append("web_image", item.web_image instanceof File ? item.web_image : item.web_image.id)
			}

			let theApi = (this.action == "new") ? ClientClient.createClient(payload) : ClientClient.updateClient(payload)
			theApi.then((res)=>{
				this.$toast.success(res.data.message)
				this.initialize()
			}).catch((err)=>{
				this.errorCollector = this.errorHandler_(err, [
					'name',
					'web_image',
					'seq_value',
					'status',
				])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
	}
}
</script>