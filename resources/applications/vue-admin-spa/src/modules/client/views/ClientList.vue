<template>
	<v-sheet color="transparent">
		<v-container>
			<!--- Introduction --->
			<v-row align="end">
				<v-col>
					<div class="text-h5 font-weight-bold">Clients</div>
					<div class="subtitle-2 grey--text">Clients that registered in this system.</div>
				</v-col>
			</v-row>
			<!--- Search Bar --->
			<v-row
				dense
				align="center"
				class="mt-3"
			>
				<search-bar
					:search.sync="search_.search"
					:search-by.sync="search_.searchBy"
					:disabled="model_loading_"
					:items="searchBy_options"
					@search="searchData_()"
				></search-bar>
			</v-row>
			<v-row align="center" class="mt-3" justify="end">
				<v-col cols="12" md="auto">
					<v-btn
						class="text-capitalize"
						color="primary" small
						@click="newItem_()"
					>
						<v-icon left>mdi-plus</v-icon>New
					</v-btn>
				</v-col>
				<v-spacer></v-spacer>
				<v-col cols="auto">
					<action-btn-group
						:items="action_btn_group_items()"
					></action-btn-group>
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
					<template #[`item.web_image`]="{ item }">
						<v-img
							v-if="item.web_image"
							max-width="150"
							:aspect-ratio="16/9"
							:src="item.web_image.file_url"
							class="clickable"
							@click="viewImage(item.web_image)"
						></v-img>
					</template>
					<template #[`item.url`]="{ item }">
						<span v-if="item.url">{{ item.url }}</span>
						<span v-else-if="item.url==null">-</span>
						<span v-else>-</span>
					</template>
					<template #[`item.status`]="{ item }">
						{{ item.status ? 'Active' : 'Inactive' }}
					</template>
					<template #[`item.updated_at`]="{ item }">
						{{ $dayjs(item.updated_at).format('YYYY-MM-DD hh:mma') }}
					</template>
					<template #[`item.action`]="{ item }">
						<w-dropdown-menu
							left bottom
							:items="menu_items(item)"
						></w-dropdown-menu>
					</template>
				</v-data-table>
			</v-card>
		</v-container>

		<!-- form dialog -->
		<v-dialog
			v-model="form_dialog_"
			max-width="550px"
			persistent
			scrollable
		>
			<ClientForm
				:item="form_item_"
				:action="form_action_"
				:visible.sync="form_dialog_"
				@initialize="initialize_()"
			></ClientForm>
		</v-dialog>
		<!--- Filter Dialog --->
		<side-dialog
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
		</side-dialog>
		<!--- Sort Dialog --->
		<side-dialog
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
		</side-dialog>

		<v-dialog v-model="viewImageDialog" max-width="550px">
			<v-card>
				<v-img :src="viewImageSrc"></v-img>
			</v-card>
		</v-dialog>
	</v-sheet>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import ActionBtnGroup from "@src/components/ActionBtnGroup.vue"
import ClientClient from '../client'
import ClientForm from "./ClientForm.vue"
import SearchBar from "@src/components/SearchBar.vue"
import SideDialog from "@src/components/SideDialog.vue"
import WDropdownMenu from '@shared/widgets/WDropdownMenu.vue'

export default{
	components:{
		ActionBtnGroup,
		SearchBar,
		SideDialog,
		ClientForm,
		WDropdownMenu,
	},
	mixins: [
		resourceMixin,
		formActionMixin,
		errorHandlerMixin
	],
	data(){
		return {
			table_headers: [
				{ text: 'Id', value: 'id' },
				{ text: 'Name', value: 'name' },
				{ text: 'Status', value: 'status' },
				{ text: 'Image', value: 'web_image' },
				{ text: 'Sequence value', value: 'seq_value' },
				{ text: 'Updated at', value: 'updated_at' },
				{ text: 'Actions', value: 'action', class: 'text-center' }
			],

			filter_dialog: false,
			sort_dialog: false,

			filter_options:[],
			sort_options:[],
			searchBy_options: [
				{ value: 'id', text: 'ID' },
				{ value: 'name', text: 'Name' }
			],
			
			viewImageDialog: false,
			viewImageSrc: null,
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
				...this.filters_,
				...this.sort_
			}
			this.model_loading_ = true
			ClientClient.getClientList(payload).then((res)=>{
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
			ClientClient.archiveClient(payload).then((res) => {
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
				{ label: "Sequence", value: {sortBy: "seq_value", sortDesc : 0 } }
			]
			this.sort_ = this.sort_options[4].value
		},
		menu_items(item){
			return [
				{
					hide_status: false,
					icon: "mdi-square-edit-outline", title: "Edit",
					action: () => { this.editItem_(item) }
				},
				{
					hide_status: false,
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
		viewImage(img){
			this.viewImageSrc = img.file_url
			this.viewImageDialog = true
		},
	}
}
</script>
