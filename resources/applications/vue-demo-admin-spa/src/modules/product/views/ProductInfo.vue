<template>
	<v-container class="mt-6 pa-0">
		<v-breadcrumbs class="pt-0" :items="breadcrumbs_data" large>
		</v-breadcrumbs>
		<v-card
			:class="{
				'card-softdeleted' : resourceData_.deleted_at,
			}"
		>
			<v-card-title class="background-x pa-0">
				<v-row class="ma-0 px-4 py-2">
					<v-col>
						<div class="headline-2 font-weight-bold pt-6">{{ resourceData_.title }}</div>
					</v-col>
					<v-col cols="auto" class="pa-0">
						<w-dropdown-menu
							left bottom
							:items="menu_items(resourceData_)"
						>
							<template #activator="{ on }">
								<v-btn icon v-on="on">
									<v-icon>mdi-dots-vertical</v-icon>
								</v-btn>
							</template>
						</w-dropdown-menu>
					</v-col>
				</v-row>
				<v-tabs
					v-model="tab_model"
					background-color="transparent"
					active-class="opposite--text"
					show-arrows
				>
					<v-tab
						v-for="(tab,i) in tabs"
						:key="i"
						class="text-capitalize"
						:href="'#'+tab.value"
						@change="changeUrlQuery"
					>
						{{ tab.title }}
					</v-tab>
				</v-tabs>
			</v-card-title>
			<v-card-text>
				<v-tabs-items v-model="tab_model">
					<v-tab-item value="overview">
						<v-card>
							<v-card-text>
								<WDataBlock
									:item="resourceData_"
									:data-blocks="datablock_values"
									class="ma-0"
								>
									<template #[`item-block-value.status`]="{ item }">
										<div class="font-weight-bold">
											<span v-if="item.deleted_at" class="error--text">Archived</span>
											<span v-else class="success--text">Active</span>
										</div>
									</template>
									<template #[`item-block-value.file.name`]="{ item }">
										<a
											v-if="item.file"
											:href="item.file.file_url"
											target="_blank"
										>
											{{ item.file.name }}
										</a>
										<div v-else>
											-
										</div>
									</template>
									<template #[`item-block-value.categories`]="{ item }">
										<v-chip
											v-for="category in item.categories"
											:key="category.id"
											small
											class="mb-1 mr-1"
										>
											{{ category.name }}
										</v-chip>
									</template>
									<template #[`item-block-value.model`]="{ item }">
										<div v-html="item.model"></div>
									</template>
									<template #[`item-block-value.created_at`]="{ item }">
										{{ $dayjs(item.created_at).format('YYYY-MM-DD hh:mma') }}
									</template>
									<template #[`item-block-value.image.file_url`]="{ item }">
										<v-row>
											<v-col
												cols="6" sm="4" md="3"
												lg="2"
											>
												<v-card color="background-x">
													<v-img
														v-if="item.image"
														:src="item.image.file_url"
														:aspect-ratio="4/3"
														contain
													>
													</v-img>
												</v-card>
											</v-col>
										</v-row>
									</template>
									<template #[`item-block-value.media_contents`]="{ item }">
										<v-row>
											<v-col
												v-for="(gallery,i) in item.media_contents"
												:key="i"
												cols="6" sm="4" md="3"
												lg="2"
											>
												<v-card color="background-x">
													<v-img
														:src="gallery.content.file_url"
														:aspect-ratio="4/3"
														contain
													>
													</v-img>
												</v-card>
											</v-col>
										</v-row>
									</template>
									<!-- create a template for spec table -->
									<template #[`item-block.specifications`]="{ item }">
										<v-col
											v-for="spec in item.specifications"
											:key="spec.id"
											class="px-3 d-flex" cols="12"
										>
											<v-row style="word-break:break-word;">
												<v-col
													cols="5" md="3"
												>
													{{ spec.title }}
												</v-col>
												<v-col cols="1" class="font-weight-bold text-center px-0">:</v-col>
												<v-col
													cols="5" md="3"
												>
													{{ spec.value }}
												</v-col>
											</v-row>
										</v-col>
									</template>
								</WDataBlock>
							</v-card-text>
						</v-card>
					</v-tab-item>
				</v-tabs-items>
			</v-card-text>

			<!--- Form Dialog --->
			<v-dialog
				v-model="form_dialog_"
				persistent scrollable
				fullscreen
			>
				<ProductForm
					:item="form_item_" :action="form_action_" :visible.sync="form_dialog_"
					@initialize="initialize_()"
				></ProductForm>
			</v-dialog>
			<!--- Form Dialog end --->

			<!--- View Image Dialog --->
			<v-dialog v-model="viewImageDialog" max-width="550px">
				<v-card>
					<v-img :src="viewImageSrc"></v-img>
				</v-card>
			</v-dialog>
			<!--- View Image Dialog end --->
		</v-card>
	</v-container>
</template>

<script>
import ProductForm from "./ProductForm.vue"
import WDataBlock from "@shared/widgets/DataBlock/WDataBlock.vue"
import WDropdownMenu from "@shared/widgets/WDropdownMenu.vue"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import ProductClient from '../client'
import { DataBlockOption } from '@shared/widgets/DataBlock/DataBlockOption'

export default{
	components:{
		ProductForm,
		WDataBlock,
		WDropdownMenu,
	},
	mixins: [
		resourceMixin,
		formActionMixin,
		errorHandlerMixin
	],
	data(){
		return {
			breadcrumbs_data: [],
			datablock_values: [
				DataBlockOption.constructTextValue('Title', 'title'),
				DataBlockOption.constructTextValue('Price', (data)=> `RM ${data.price}`),
				DataBlockOption.constructTextValue('Preview Image', 'image.file_url'),
				DataBlockOption.constructTextValue('Product Images', 'media_contents'),
				DataBlockOption.constructTextValue('PDF File', 'file.name'),
				DataBlockOption.constructTextValue('Description', 'description'),
				DataBlockOption.constructTextValue('Category', 'categories'),
				DataBlockOption.constructTextValue('Status', 'status'),
				DataBlockOption.constructTextValue('Created At', 'created_at'),
				DataBlockOption.constructDivider(),
				DataBlockOption.constructTitle('Specifications'),
				DataBlockOption.constructTextValue('Specifications', 'specifications'),
			],
			tab_model: null,
			tabs: [
				{ title: 'Overview', value: 'overview' },
			],
			viewImageDialog : false,
			viewImageSrc : null,
			uploadImageDialog: false,
			upload_progress: null,
		}
	},
	created(){
		if(this.$route.params.id){
			this.infoID = this.$route.params.id;
		}

		if(this.$route.query.tab){
			this.tab_model = this.$route.query.tab
		}

		this.breadcrumbs_data = [
			{ text: 'Product List', disabled: false, to:  '/products/list' },
			{ text: 'Product Info', disabled: true },
		];

		this.initialize_()
	},
	methods:{
		getResourceData_(){
			ProductClient.getProductInfo(this.infoID).then((res) => {
				this.resourceData_ = res.data.data
			}).catch((err) => {
				this.errorHandler_(err)
			})
		},
		archiveModel_(item){
			let payload = {
				id : item.id
			}
			ProductClient.archiveProduct(payload).then((res) => {
				this.initialize_();
				this.$toast.success(res.data.message)
			}).catch((err) => {
				this.errorHandler_(err)
			})
		},
		menu_items(item = {}){
			let menu_items = [
				{
					icon: "mdi-square-edit-outline", title: "Edit",
					action: () => { this.editItem_(item) }
				},
				{
					icon: (item.deleted_at ? "mdi-delete-off" : "mdi-delete"),
					title: (item.deleted_at ? "Activate" : "Archive"),
					icon_class: "red--text",
					title_class: "red--text",
					action: () => { this.archiveModel_(item) }
				}
			]

			return menu_items;
		},
		changeUrlQuery(){
			this.$nextTick(()=>{
				window.history.replaceState(null, null, '?tab='+ this.tab_model);
			});
		},
		viewImage(img){
			this.viewImageSrc = img.file_url
			this.viewImageDialog = true
		},
		saveImage(image){
			let item = this.form_item_

			let file = this.$refs.image_input.dataURLtoBlob(image)
			if(file.size > (10 * 1024*1024) ){
				this.$toast.error("Image may not greater than 10mb.")
				return null;
			}

			let progress = (progressEvent) => {
				var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
				this.upload_progress = percentCompleted
			}

			let payload = new FormData();
			payload.append("product_id", item.id);
			if(item.avatar){
				payload.append("id", item.avatar?.id);
			}
			payload.append("image", file);
			this.$api.updateProductImage(payload, progress).then((res)=>{
				this.$toast.success(res.data.message)
				this.uploadImageDialog = false
				this.initialize_()
			}).catch((err) => {
				this.errorHandler_(err)
			}).finally(()=>{
				this.upload_progress = null
			})
		}
	}
}
</script>
