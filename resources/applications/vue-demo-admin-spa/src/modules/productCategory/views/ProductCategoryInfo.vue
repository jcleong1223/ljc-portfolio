<template>
	<v-sheet color="transparent">
		<v-container v-if="pageLoading">
			<v-skeleton-loader type="text" max-width="200"></v-skeleton-loader>
			<v-skeleton-loader type="image, paragraph, paragraph"></v-skeleton-loader>
		</v-container>
		<v-container v-else-if="resourceData.id == null">
			No Data
		</v-container>
		<v-container v-else class="mt-6 pa-0">
			<v-breadcrumbs class="pt-0" :items="breadcrumbs_data" large></v-breadcrumbs>
			<v-card
				:class="{
					'card-softdeleted' : resourceData.deleted_at,
				}"
			>
				<v-card-title class="background-x pa-0">
					<v-row class="ma-0 px-4 py-2">
						<v-col cols="auto" class="pa-0">
							<w-dropdown-menu
								left bottom
								:items="menu_items(resourceData)"
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
										:item="resourceData"
										:data-blocks="datablock_values"
										class="ma-0"
									>
										<template #[`item-block-value.status`]="{ item }">
											<div class="font-weight-bold">
												<span v-if="item.deleted_at" class="error--text">Archived</span>
												<span v-else class="success--text">Active</span>
											</div>
										</template>
										<template #[`item-block-value.name`]="{ item }">
											<div>{{ item.name }}</div>
										</template>
										<template #[`item-block-value.description`]="{ item }">
											<div class="text-pre-wrap">{{ item.description }}</div>
										</template>
										<template #[`item-block-value.package_plans`]="{ item }">
											<v-chip
												v-for="package_plan in item.package_plans"
												:key="package_plan.id"
												small
												class="mb-1 mr-1"
											>
												{{ package_plan.name }}
											</v-chip>
										</template>
										<template #[`item-block-value.created_at`]="{ item }">
											{{ $dayjs(item.created_at).format('YYYY-MM-DD hh:mma') }}
										</template>
									</WDataBlock>
								</v-card-text>
							</v-card>
						</v-tab-item>
					</v-tabs-items>
				</v-card-text>
			</v-card>
			<v-dialog v-model="form_dialog_" max-width="550px" persistent>
				<ProductCategoryForm
					:item="form_item_" :action="form_action_" :visible.sync="form_dialog_"
					@initialize="initialize()"
				></ProductCategoryForm>
			</v-dialog>
		</v-container>
	</v-sheet>
</template>


<script>
import ProductCategoryForm from "./ProductCategoryForm.vue"
import WDataBlock from "@shared/widgets/DataBlock/WDataBlock.vue"
import WDropdownMenu from "@shared/widgets/WDropdownMenu.vue"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import ProductCategoryClient from '../client'
export default{
	components: {
		ProductCategoryForm,
		WDataBlock,
		WDropdownMenu,
	},
	mixins: [
		formActionMixin,
		errorHandlerMixin,
	],
	data(){
		return {
			infoID: null,
			datablock_values: [
				{ text: 'Name', value: 'name' },
				{ text: 'Sequence', value: 'seq_value' },
				{ text: 'Created At', value: 'created_at' },
			],
			uploadImageDialog: false,
			upload_progress: null,

			pageLoading: true,
			resourceData: null,
			breadcrumbs_data: [],
			tab_model: null,
			tabs: [
				{ title: 'Overview', value: 'overview' },
			],
		}
	},
	created(){
		if(this.$route.params.id){
			this.infoID = this.$route.params.id;
		}

		this.breadcrumbs_data = [
			{ text: 'Product Category List', disabled: false, to: { name: 'product-category.list' } },
			{ text: 'Product Category Info', disabled: true },
		];

		this.initialize()
	},
	methods:{
		initialize(){
			this.getResourceData()
		},
		getResourceData(){
			ProductCategoryClient.getProductCategoryInfo(this.infoID).then((res) => {
				this.resourceData = res.data.data
			}).catch((err) => {
				this.errorHandler_(err)
			}).finally(()=>{
				this.pageLoading = false
			})
		},
		menu_items(item = {}){
			return [
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
				},
			]
		},
		archiveModel_(item){
			let payload = {
				id : item.id
			}
			ProductCategoryClient.archiveProductCategory(payload).then((res) => {
				this.initialize_();
				this.$toast.success(res.data.message)
			}).catch((err) => {
				this.errorHandler_(err)
			})
		},
	}
}
</script>
