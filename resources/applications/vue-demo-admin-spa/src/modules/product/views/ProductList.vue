<template>
	<v-container>
		<!--- Introduction --->
		<v-row v-if="!hideTitleBar" align="end">
			<v-col>
				<div class="headline font-weight-bold">Products</div>
				<div class="subtitle-2 grey--text">Products that registered in this system.</div>
			</v-col>
		</v-row>
		<!--- Introduction end --->

		<!--- Search Bar --->
		<v-row
			dense
			align="center"
			class="mt-3"
		>
			<w-search-bar
				:search.sync="search_.search"
				:search-by.sync="search_.searchBy"
				:disabled="model_loading_"
				:items="searchBy_options"
				@search="searchData_()"
			></w-search-bar>
		</v-row>
		<!--- Search Bar end --->

		<v-row align="center" class="mt-3" justify="end">
			<!--- Create Button --->
			<v-col cols="12" md="auto">
				<v-btn
					class="text-capitalize"
					color="primary" small
					@click="newItem_()"
				>
					<v-icon left>mdi-plus</v-icon>New
				</v-btn>
			</v-col>
			<!-- - Create Button end - -->

			<v-spacer></v-spacer>
			<v-col cols="auto">
				<w-action-btn-group
					:items="action_btn_group_items()"
				></w-action-btn-group>
			</v-col>
		</v-row>

		<!--- Table --->
		<v-card class="mt-4" color="transparent" flat>
			<v-data-table
				ref="dataTable"
				:headers="table_headers"
				:items="resourceDataSet_"
				:options.sync="settings_"
				:server-items-length="totalData_"
				:footer-props="{
					'items-per-page-options': [5, 10, 25, 50]
				}"
				:loading="model_loading_"
				disable-sort
				:item-class="row_classes_"
			>
				<template #[`item.image`]="{ item }">
					<v-img
						v-if="item.image"
						width="200px"
						:src="item.image.file_url"
						class="clickable"
						:aspect-ratio="4/3"
						@click="viewImage(item.image)"
					></v-img>
				</template>
				<template #[`item.updated_at`]="{ item }">
					{{ $dayjs(item.updated_at).format('YYYY-MM-DD hh:mma') }}
				</template>
				<template #[`item.action`]="{ item }">
					<v-btn icon small :to="{ name: 'product.info', params : { id: item.id } }">
						<v-icon small>mdi-eye</v-icon>
					</v-btn>
					<w-dropdown-menu
						left bottom
						:items="menu_items(item)"
					></w-dropdown-menu>
				</template>
			</v-data-table>
		</v-card>
		<!--- Table end --->


		<!-- form dialog -->
		<v-dialog
			v-model="form_dialog_" max-width="550px" persistent
			scrollable
		>
			<ProductForm
				:ratio="16/9"
				:item="form_item_"
				:action="form_action_"
				:visible.sync="form_dialog_"
				@initialize="initialize_()"
			></ProductForm>
		</v-dialog>

		<!--- Filter Dialog --->
		<w-side-dialog
			v-model="filter_dialog"
			title="Filters"
			clearable
			@clear="initFilters()"
		>
			<template #default>
				<v-row dense>
					<template v-for="(filter,i) in filter_options">
						<v-col :key="i" cols="12">
							<v-select
								v-model="filters_[filter.model]"
								:label="filter.label"
								:items="filter.items"
								class="caption"
								outlined
								dense hide-details
							></v-select>
						</v-col>
					</template>
					<v-col cols="12">
						<w-data-selection
							v-model="filter_product_category"
							label="Select Category"
							placeholder="Search for Category"
							:data-object="productCategory_dataObj"
							:loading="productCategory_loading"
							@search="searchProductCategory"
						>
							<template #activator="{ on }">
								<v-text-field
									:value="!!filter_product_category ? filter_product_category.name : 'All' "
									label="Category" placeholder="Select Category"
									readonly
									outlined dense
									:append-icon="!!filter_product_category ? 'mdi-close' : null"
									@click="on"
									@click:append="()=>{
										filter_product_category = null
									}"
								></v-text-field>
							</template>
						</w-data-selection>
					</v-col>
				</v-row>
			</template>
			<template #actions>
				<div class="text-right">
					<v-btn
						rounded block color="primary"
						@click="searchData_()"
					>
						Apply
					</v-btn>
				</div>
			</template>
		</w-side-dialog>
		<!--- Filter Dialog emd --->

		<!--- Sort Dialog --->
		<w-side-dialog
			v-model="sort_dialog"
			title="Sort"
		>
			<template #default>
				<v-radio-group
					v-model="sort_"
					dense hide-details
					mandatory
					class="mt-0"
				>
					<template v-for="(sort,i) in sort_options">
						<v-radio :key="i" :label="sort.label" :value="sort.value"></v-radio>
					</template>
				</v-radio-group>
			</template>
			<template #actions>
				<div class="text-right">
					<v-btn
						rounded block color="primary"
						@click="searchData_()"
					>
						Apply
					</v-btn>
				</div>
			</template>
		</w-side-dialog>
		<!--- Sort Dialog end --->

		<v-dialog v-model="viewImageDialog" max-width="550px">
			<v-card>
				<v-img :src="viewImageSrc"></v-img>
			</v-card>
		</v-dialog>
	</v-container>
</template>

<script>
import WActionBtnGroup from "@src/components/ActionBtnGroup.vue"
import WDropdownMenu from "@shared/widgets/WDropdownMenu.vue"
import WSearchBar from "@src/components/SearchBar"
import ProductForm from "./ProductForm.vue"
import WSideDialog from "@src/components/SideDialog.vue"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import ProductClient from '../client'
import ProductCategoryClient from '@src/modules/productCategory/client'
import WDataSelection from '@shared/widgets/WDataSelection.vue'

export default{
	components:{
		WActionBtnGroup,
		WDropdownMenu,
		WSearchBar,
		ProductForm,
		WSideDialog,
		WDataSelection,
	},
	mixins: [
		resourceMixin,
		formActionMixin,
		errorHandlerMixin
	],
	props:{
		hideTitleBar:{
			type: Boolean,
			default: false,
		},
		foreignProps:{
			type: Object,
			default: ()=>{
				return {}
			}
		}
	},
	data(){
		return {
			table_headers: [
				{ text: 'Id', value: 'id' },
				{ text: 'Image', value: 'image' },
				{ text: 'Title', value: 'title' },
				{ text: 'Price (RM)', value: 'price' },
				{ text: 'Updated at', value: 'updated_at' },
				{ text: 'Actions', value: 'action', class: 'text-center' }
			],
			show_statistics: false,

			filter_dialog: false,
			sort_dialog: false,

			filter_options:[],
			sort_options:[],
			searchBy_options: [
				{ value: 'id', text: 'ID' },
				{ value: 'title', text: 'Name' },
			],
			product_category_search:  {
				result: [],
				total: null,
				loading: false,
				dialog: false
			},
			uploadImageDialog: false,
			viewImageDialog: false,
			viewImageSrc: null,
			productCategory_dataObj : {},
			productCategory_loading : false,
			filter_product_category : null,

			resourceData: null,
		}
	},
	computed:{
		filtering(){
			return Object.assign(this.filters_, this.foreignProps)
		}
	},
	created(){
		this.options_.activity = this.getActivityRefs_()

		this.getAllRefs_([
			// async methods
		]).then(()=>{
			this.setupFilterBar()
			this.initFilters()
			this.setupSortOptions()
			this.search_.searchBy = 'id'
		}).then(()=>{
			this.initialize_()
		})
	},
	methods:{
		initFilters(){
			this.filters_ = {
				activity : 1
			}
		},
		getResourceData_(){
			let payload = {
				...this.setPagination_(),
				...this.search_,
				...this.filtering,
				...this.sort_
			}
			this.model_loading_ = true
			ProductClient.getProductList(payload).then((res)=>{
				let { data, total } = res.data.data
				this.resourceDataSet_ = data
				this.totalData_ = total
			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.model_loading_ = false
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
		setupFilterBar(){
			this.filter_options = [
				{
					cols: 12,
					model: "activity",
					label: "Activity",
					items: this.options_.activity
				}
			]
		},
		setupSortOptions(){
			this.sort_options = [
				{ label: "id (ASC)", value: {sortBy: "id", sortDesc : 0 } },
				{ label: "id (DESC)", value: {sortBy: "id", sortDesc : 1 } },
				{ label: "Newest", value: {sortBy: "created_time", sortDesc : 0 } },
				{ label: "Latest", value: {sortBy: "created_time", sortDesc : 1 } },
			]
			this.sort_ = this.sort_options[3].value
		},
		menu_items(item){
			return [
				{
					icon: "mdi-square-edit-outline", title: "Edit",
					action: () => { this.editItem_({...item }) }
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
		action_btn_group_items(){
			return [
				{
					icon: "mdi-refresh",
					disabled: this.model_loading_,
					action: () => { this.searchData_() }
				},
				{
					icon: "mdi-filter-outline",
					action: () => { this.filter_dialog = true }
				},
				{
					icon: "mdi-sort",
					action: () => { this.sort_dialog = true }
				}
			]
		},
		newProduct() {
			this.form_action_ = "new",
			this.uploadImageDialog = true
		},
		editProduct(item) {
			this.bindAction_('edit',item)
			this.uploadImageDialog = true
		},

		viewImage(img){
			this.viewImageSrc = img.file_url
			this.viewImageDialog = true
		},
		searchProductCategory(w_payload){
			let payload = {
				page: w_payload.page,
				itemsPerPage: w_payload.itemsPerPage,
				search: w_payload.search,
				searchBy: "name",
			}
			this.productCategory_loading = true
			ProductCategoryClient.getProductCategoryList(payload).then((res)=>{
				this.productCategory_dataObj = res.data.data
				this.productCategory_dataObj
			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.productCategory_loading = false
			})
		},
	}
}
</script>