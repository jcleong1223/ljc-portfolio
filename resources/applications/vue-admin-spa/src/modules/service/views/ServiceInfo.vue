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
											<span v-if="item.status" class="success--text">Active</span>
											<span v-else class="error--text">Inactive</span>
										</div>
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
								</WDataBlock>
								<v-row class="ma-0">
									<v-col cols="12" md="12">
										<div class="font-weight-bold">
											Description
										</div>
									</v-col>
									<v-col cols="12" md="12">
										<div v-html="resourceData_.description"></div>
									</v-col>
								</v-row>
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
				<ServiceForm
					:item="form_item_" :action="form_action_" :visible.sync="form_dialog_"
					@initialize="initialize_()"
				></ServiceForm>
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
import ServiceForm from "./ServiceForm.vue"
import WDataBlock from "@shared/widgets/DataBlock/WDataBlock.vue"
import WDropdownMenu from "@shared/widgets/WDropdownMenu.vue"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import ServiceClient from '../client'
import { DataBlockOption } from '@shared/widgets/DataBlock/DataBlockOption'

export default{
	components:{
		ServiceForm,
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
				DataBlockOption.constructTextValue('Sequence Value', 'seq_value'),
				DataBlockOption.constructTextValue('Status', 'status'),
				DataBlockOption.constructTextValue('Preview Image', 'image.file_url'),
				DataBlockOption.constructTextValue('Capability Images', 'media_contents'),
				DataBlockOption.constructTextValue('Created At', 'created_at'),
				DataBlockOption.constructTextValue('Short Description', 'short_description'),
				// DataBlockOption.constructDivider(),
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
			{ text: 'Capability List', disabled: false, to:  '/capabilities/list' },
			{ text: 'Capability Info', disabled: true },
		];

		this.initialize_()
	},
	methods:{
		getResourceData_(){
			ServiceClient.getServiceInfo(this.infoID).then((res) => {
				this.resourceData_ = res.data.data
			}).catch((err) => {
				this.errorHandler_(err)
			})
		},
		archiveModel_(item){
			let payload = {
				id : item.id
			}
			ServiceClient.archiveService(payload).then((res) => {
				this.initialize_()
				if(!item.deleted_at) {
					this.$router.go(-1)
				}
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
