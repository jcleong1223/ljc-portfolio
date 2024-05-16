<template>
	<v-card v-if="visible" class="radius-10">
		<v-card-title>
			<span class="text-h6"> {{ (action == 'edit') ? 'Edit Capability Details' : 'Create Capability Details' }}</span>
		</v-card-title>
		<v-divider class="ma-0"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense>
				<v-col cols="12" md="7">
					<w-image-input-field
						v-model="dataForm.image"
						label="Preview Image (1:1)"
						:ratio="1"
						:width="120"
						:error-messages="errors.image"
						class="pb-2"
					>
					</w-image-input-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.title"
						label="Title" placeholder="Title"
						dense
						:error-messages="errors.title"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-textarea
						v-model="dataForm.short_description"
						label="Short Description" placeholder="Short description about this capability"
						dense
						counter
						:error-messages="errors.short_description"
					></v-textarea>
				</v-col>

				<v-col cols="12" md="12">
					<w-image-input-field
						v-model="dataForm.media_contents"
						label="Media Contents (1:1)"
						:ratio="1"
						:width="120"
						:multiple="6"
						:error-messages="errors.media_contents"
					></w-image-input-field>
				</v-col>

				<v-col cols="12" md="12">
					<ckeditor-input
						v-model="dataForm.description"
						label="Description"
						:error-messages="errors.description"
					></ckeditor-input>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.seq_value"
						type="number" step="1"
						label="Sequence (Largest to Lowest)" placeholder="1,2,3..."
						dense
						:error-messages="errors.seq_value"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-select
						v-model="dataForm.status"
						:items="[
							{ text : 'Active', value : 1 },
							{ text : 'Inactive', value : 0 }
						]"
						item-text="text"
						item-value="value"
						label="Status" placeholder="Status"
						dense
						:error-messages="errors.status"
					></v-select>
				</v-col>
			</v-row>
		</v-card-text>
		<v-divider class="mx-0"></v-divider>
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
// import WDataSelection from '@shared/widgets/WDataSelection.vue'
import WImageInputField from '@shared/widgets/FileUpload/WImageInputField.vue'
import ServiceClient from '../client'
import CkeditorInput from '@src/components/CkeditorInput.vue'

export default{
	components: {
		CkeditorInput,
		WImageInputField,
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
	data() {
		return {
			dataForm: {},
			errors: {},
			submit_loading: false,
		}
	},
	watch:{
		'item':{
			handler() {
				this.dataForm = this.item
				if(this.dataForm.status == null){
					this.dataForm.status = 1;
				}
				if(this.dataForm.seq_value == null){
					this.dataForm.seq_value = 1;
				}
				if(this.dataForm.categories == null){
					this.$set(this.dataForm, 'categories', [])
				}
				if(this.dataForm.specifications == null){
					this.$set(this.dataForm, 'specifications', [])
					this.addSpecificationInput()
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
		'visible': {
			handler: function(newVal) {
				if(newVal) {
					//
				} else {
					// reset
					this.dataForm = {}
					this.errors = {}
				}
			},
			immediate: true,
		},
	},
	created(){
	},
	methods: {
		initialize() {
			this.closeDialog()
			this.$emit('initialize')
		},
		closeDialog(){
			this.$emit('update:visible', false)
		},
		submitForm(item){
			this.errors = {}
			this.saveModel(item)
		},
		saveModel(item) {
			this.submit_loading = true

			let payload = new FormData()
			payload.append("id", item.id)
			payload.append("title", item.title ?? '');
			payload.append("short_description", item.short_description ?? '');
			payload.append("description", item.description ?? '');
			payload.append("seq_value", item.seq_value ?? '');
			payload.append("status", item.status ?? '');

			if(item.image){
				payload.append("image", item.image instanceof File ? item.image : item.image.id)
			}

			if(item.media_contents){
				item.media_contents.forEach((item, key)=>{
					payload.append(`media_contents[${key}]`, item instanceof File ? item : item.id)
				})
			}

			let theApi = (this.action == "new") ? ServiceClient.createService(payload) : ServiceClient.updateService(payload)
			theApi.then((res) => {
				this.$toast.success(res.data.message)
				this.initialize()

			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					'title',
					'short_description',
					'description',
					'seq_value',
					'status',
					'image',
				])
			}).finally(() => {
				this.submit_loading = false
			})
		},
	}
}
</script>