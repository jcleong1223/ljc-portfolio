<template>
	<v-card v-if="visible" class="radius-10">
		<v-card-title>
			<span class="text-h6"> {{ (action == 'edit') ? 'Edit Product' : 'Create Product' }}</span>
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
					<v-text-field
						v-model="dataForm.price"
						type="number" step="0.01" min="0"
						label="Price" placeholder="Price"
						dense
						:error-messages="errors.price"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-row dense align="center" class="pb-2">
						<v-col cols="auto">Categories:</v-col>
						<v-col>
							<w-data-selection
								v-model="dataForm.categories"
								title="Select Category"
								label="Search for Categories"
								multiple
								:data-object="product_category_search.data_object"
								:loading="product_category_search.loading"
								@search="searchProductCategory"
							>
								<template #activator="{ on }">
									<v-btn
										icon
										x-small
										outlined
										class="mb-1"
										@click="on"
									>
										<v-icon x-small>mdi-plus</v-icon>
									</v-btn>
								</template>
							</w-data-selection>
						</v-col>
						<v-col v-if="dataForm.categories.length > 0" cols="12">
							<template v-for="(category,i) in dataForm.categories">
								<v-chip
									:key="i"
									small
									close
									class="mr-1 mb-1"
									@click:close="dataForm.categories.splice(i,1)"
								>
									{{ category.name }}
								</v-chip>
							</template>
						</v-col>
						<v-col v-if="errors.product_category_ids" cols="12" class="red--text text-caption">{{ errors.product_category_ids[0] }}</v-col>
					</v-row>
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
					<w-file-input-field
						v-model="dataForm.file"
						label="PDF"
						accept="application/pdf"
						:error-messages="errors.file"
					></w-file-input-field>
				</v-col>

				<v-col cols="12">
					<v-row dense>
						<v-col cols="auto" class="font-weight-bold text-body-1">Specifications:</v-col>
						<v-col>
							<v-btn
								x-small
								outlined
								icon
								class="ml-1"
								@click="addSpecificationInput()"
							>
								<v-icon x-small>mdi-plus</v-icon>
							</v-btn>
						</v-col>
					</v-row>
					<v-row dense>
						<template v-for="(input, i) in dataForm.specifications">
							<v-col :key="i" cols="12">
								<v-row dense class="mt-1" align="baseline">
									<v-col cols="5">
										<v-text-field
											v-model="input.title"
											label="Title"
											outlined
											dense
											:hide-details="!errors[`specifications.${i}.title`]"
											:error-messages="errors[`specifications.${i}.title`]"
										>
										</v-text-field>
									</v-col>
									<v-col cols="6">
										<v-text-field
											v-model="input.value"
											label="Value"
											outlined
											dense
											:hide-details="!errors[`specifications.${i}.value`]"
											:error-messages="errors[`specifications.${i}.value`]"
										>
										</v-text-field>
									</v-col>
									<v-col cols="auto">
										<v-btn
											small
											icon
											outlined
											color="error"
											@click="removeSpecificationInput(i)"
										>
											<v-icon small color="error">mdi-delete</v-icon>
										</v-btn>
									</v-col>
								</v-row>
							</v-col>
						</template>
					</v-row>
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
import WDataSelection from '@shared/widgets/WDataSelection.vue'
import ProductCategoryClient from '@src/modules/productCategory/client'
import WImageInputField from '@shared/widgets/FileUpload/WImageInputField.vue'
import ProductClient from '../client'
import CkeditorInput from '@src/components/CkeditorInput.vue'
import WFileInputField from '@shared/widgets/FileUpload/WFileInputField.vue'

export default{
	components: {
		WImageInputField,
		WDataSelection,
		CkeditorInput,
		WFileInputField,
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
			product_category_search: {
				result: [],
				total: null,
				loading: false,
				dialog: false,
			},
			file_upload_progress: false,
		}
	},
	watch:{
		'item':{
			handler() {
				this.dataForm = this.item
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
			payload.append("title", item.title);
			payload.append("price", item.price);
			payload.append("description", item.description);
			payload.append("specifications", JSON.stringify(item.specifications));
			payload.append("product_category_ids", JSON.stringify(item.categories.map((i) => i.id)));

			if(item.image){
				payload.append("image", item.image instanceof File ? item.image : item.image.id)
			}

			if(item.file){
				payload.append("file", item.file instanceof File ? item.file : item.file.id)
			}

			if(item.media_contents){
				item.media_contents.forEach((item, key)=>{
					payload.append(`media_contents[${key}]`, item instanceof File ? item : item.id)
				})
			}

			let theApi = (this.action == "new") ? ProductClient.createProduct(payload) : ProductClient.updateProduct(payload)
			theApi.then((res) => {
				this.$toast.success(res.data.message)
				this.initialize()

			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					'image',
					'title',
					'price',
					'description',
					'file',
					... item.specifications.map((item, key)=>{
						return [`specifications.${key}.title`,`specifications.${key}.value`]
					}).flat(),
					'product_category_ids'
				])
			}).finally(() => {
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
			ProductCategoryClient.getProductCategoryList(payload).then((res)=>{
				this.product_category_search.data_object = res.data.data
			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.product_category_search.loading = false
			})
		},

		addSpecificationInput(){
			this.dataForm.specifications.push({
				"title" : null,
				"value" : null
			});
		},
		removeSpecificationInput(i){
			this.dataForm.specifications.splice(i,1);
		},
	}
}
</script>