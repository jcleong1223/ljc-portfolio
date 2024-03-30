<template>
	<v-container>
		<!--- Introduction --->
		<v-row v-if="!hideTitleBar" align="end">
			<v-col>
				<div class="headline font-weight-bold">Product Category</div>
				<div class="subtitle-2 grey--text">Product Category that registered in this system.</div>
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

		<!--- Create Button --->
		<v-row align="center" class="mt-3" justify="end">
			<v-col cols="12" md="auto">
				<v-btn
					class="text-capitalize"
					color="primary" small
					@click="newItem_()"
				>
					<v-icon left>mdi-plus</v-icon>
					<span>new</span>
				</v-btn>
			</v-col>
			<v-spacer></v-spacer>
			<v-col cols="auto">
				<w-action-btn-group
					:items="action_btn_group_items()"
				></w-action-btn-group>
			</v-col>
		</v-row>
		<!--- Create Button end --->

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
				<template #[`item.name`]="{ item }">
					<div>{{ item.name }}</div>
				</template>
				<template #[`item.created_at`]="{ item }">
					{{ $dayjs(item.created_at).format('YYYY-MM-DD hh:mma') }}
				</template>
				<template #[`item.action`]="{ item }">
					<v-btn icon small :to="{ name: 'product-category.info', params : { id: item.id } }">
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

		<!--- Form Dialog --->
		<v-dialog v-model="form_dialog_" max-width="550px" persistent>
			<ProductCategoryForm
				:item="form_item_" :action="form_action_" :visible.sync="form_dialog_"
				@initialize="initialize_()"
			></ProductCategoryForm>
		</v-dialog>
		<!--- Form Dialog end --->

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
	</v-container>
</template>

<script>
import ProductCategoryForm from "./ProductCategoryForm"
import WActionBtnGroup from "@src/components/ActionBtnGroup.vue"
import WDropdownMenu from "@shared/widgets/WDropdownMenu.vue"
import WSearchBar from "@src/components/SearchBar.vue"
import WSideDialog from "@src/components/SideDialog.vue"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"

import ProductCategoryClient from '../client'

export default{
	components:{
		WActionBtnGroup,
		ProductCategoryForm,
		WDropdownMenu,
		WSearchBar,
		WSideDialog,
		// WModelSelectionDialog,
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
				{ text: 'Name', value: 'name' },
				{ text: 'Sequence value', value: 'seq_value' },
				{ text: 'Created at', value: 'created_at' },
				{ text: 'Actions', value: 'action', class: 'text-center' }
			],

			viewImageDialog : false,
			viewImageSrc : null,

			filter_dialog: false,
			sort_dialog: false,

			filter_options:[],
			sort_options:[],
			searchBy_options: [
				{ value: 'id', text: 'ID' },
				{ value: 'name', text: 'Name' }
			],

			filter_product_category : null,
			product_category_search:  {
				loading: false,
				dialog: false,
			},
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
			this.search_.searchBy = 'name'
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
				...this.sort_,
				product_category_id : this.filter_product_category?.id,
			}
			this.model_loading_ = true
			ProductCategoryClient.getProductCategoryList(payload).then((res)=>{
				let { data, total } = res.data.data
				this.resourceDataSet_ = data
				this.totalData_ = total
			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.model_loading_ = false
			})
		},
		viewImage(img){
			this.viewImageSrc = img.file_url
			this.viewImageDialog = true
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
				{ label: "Oldest (Created At)", value: {sortBy: "created_time", sortDesc : 0 } },
				{ label: "Latest (Created At)", value: {sortBy: "created_time", sortDesc : 1 } },
				{ label: "Sequence", value: {sortBy: "seq_value", sortDesc : 0 } }
			]
			this.sort_ = this.sort_options[4].value
		},
		menu_items(item){
			return [
				{
					icon: "mdi-content-duplicate", title: "Duplicate",
					action: () => { this.duplicateItem_(item) }
				},
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
				},
			]
		},
	}
}
</script>
