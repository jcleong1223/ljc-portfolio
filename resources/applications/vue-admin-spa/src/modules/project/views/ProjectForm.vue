<template>
	<v-card v-if="visible" class="radius-10">
		<v-card-title>
			<span class="text-h6"> {{ (action == 'edit') ? 'Edit Project Details' : 'Create Project Details' }}</span>
		</v-card-title>
		<v-divider class="ma-0"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense>
				<v-col cols="12" md="7">
					<w-image-input-field
						v-model="dataForm.web_image"
						label="Preview Image (1:1)"
						:ratio="1"
						:width="120"
						:error-messages="errors.web_image"
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
					<v-text-field
						v-model="dataForm.website_url"
						label="Website URL"
						placeholder="Website URL"
						dense
						:error-messages="errors.website_url"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-textarea
						v-model="dataForm.short_description"
						label="Short Description" 
						placeholder="Short description about this project"
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

				<v-col cols="12" md="12">
					<v-menu
						ref="menu"
						v-model="menu"
						:close-on-content-click="true"
						transition="scale-transition"
						offset-y
						max-width="100%"
						min-width="auto"
					>
						<template #activator="{ on, attrs }">
							<v-text-field
								v-model="dataForm.project_date"
								label="Project Date"
								prepend-icon="mdi-calendar"
								readonly
								v-bind="attrs"
								v-on="on"
							></v-text-field>
						</template>
						<v-date-picker
							v-model="dataForm.project_date"
							type="month"
							no-title
							scrollable
						>
							<v-spacer></v-spacer>
							<v-btn
								text
								color="primary"
								@click="menu = false"
							>
								Cancel
							</v-btn>
							<v-btn
								text
								color="primary"
								@click="$refs.menu.save(dataForm.project_date)"
							>
								OK
							</v-btn>
						</v-date-picker>
					</v-menu>
				</v-col>

				<v-col cols="12" md="12">
					<v-select
						v-model="dataForm.tags"
						:items="tags"
						label="Tag"
						chips
						multiple
						item-text="text"
						item-value="value"
						placeholder="Tag"
						dense
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
import WImageInputField from '@shared/widgets/FileUpload/WImageInputField.vue'
import ProjectClient from '../client'
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
			tags: [],
			menu: false,
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
				if(this.dataForm.tags?.length > 0 && this.action == 'edit'){
					this.dataForm.tags = this.dataForm.tags.map(tag => tag.id);
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
		this.fetchAllTagsData();
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
			payload.append("website_url", item.website_url ?? '');
			payload.append("short_description", item.short_description ?? '');
			payload.append("description", item.description ?? '');
			payload.append("seq_value", item.seq_value ?? '');
			payload.append("status", item.status ?? '');

			if(item.project_date){
				const [year, month] = item.project_date.split('-');
				item.project_date = `${year}-${month}-01`;
				payload.append("project_date", item.project_date ?? '');
			}

			if(item.web_image){
				payload.append("web_image", item.web_image instanceof File ? item.web_image : item.web_image.id)
			}

			if(item.media_contents){
				item.media_contents.forEach((item, key)=>{
					payload.append(`media_contents[${key}]`, item instanceof File ? item : item.id)
				})
			}

			if(item.tags){
				item.tags.forEach((tagId, key) => {
					payload.append(`tags[${key}]`, tagId)
				})
			
			}

			let theApi = (this.action == "new") ? ProjectClient.create(payload) : ProjectClient.update(payload)
			theApi.then((res) => {
				this.$toast.success(res.data.message)
				this.initialize()

			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					'title',
					'website_url',
					'short_description',
					'description',
					'seq_value',
					'status',
					'tags',
					'web_image',
					'project_date'
				])
			}).finally(() => {
				this.submit_loading = false
			})
		},

		fetchAllTagsData(){
			let payload = {
				...this.search_,
				...this.filtering,
				...this.sort_
			}
			this.model_loading_ = true
			ProjectClient.getTagsList(payload).then((res)=>{
				let tagsData = res.data.data
				this.tags = tagsData.map(tag => ({
					text: tag.title,
					value: tag.id,
				}))

			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.model_loading_ = false
			})
		},
	}
}
</script>