<template>
	<v-sheet color="transparent">
		<v-container>
			<!-- introduction -->
			<v-row align="end">
				<v-col>
					<div class="text-h5 font-weight-bold">User</div>
					<div class="subtitle-2 grey--text">Users that registered in this system.</div>
				</v-col>
			</v-row>
			<!-- search bar -->
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
			<!--  -->
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
					<action-btn-group
						:items="action_btn_group_items()"
					></action-btn-group>
				</v-col>
			</v-row>
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
					<!-- <template #[`item.avatar`]="{ item }">
						<v-img
							v-if="item.avatar"
							class="radius-40"
							width="40px"
							height="40px"
							:src="item.avatar.file_url"
						></v-img>
					</template> -->
					<template #[`item.name`]="{ item }">
						<v-row dense class="flex-nowrap ma-0">
							<v-col class="overflow-hidden">
								<div class="no-word-wrap" :title="item.name">{{ item.name }}</div>
							</v-col>
						</v-row>
					</template>
					<template #[`item.email`]="{ item }">
						<div>
							{{ item.email }}
							<v-icon
								v-if="item.email_verified_at"
								color="success"
								small
								:title="'Verified at: '+ $dayjs(item.email_verified_at).format('YYYY-MM-DD hh:mma')"
							>
								mdi-check-decagram
							</v-icon>
						</div>
					</template>
					<template #[`item.role`]="{ item }">
						{{ item.roles.map((item)=> item.display_name).join(', ') }}
					</template>
					<template #[`item.created_at`]="{ item }">
						{{ $dayjs(item.created_at).format('YYYY-MM-DD hh:mma') }}
					</template>
					<template #[`item.action`]="{ item }">
						<v-btn icon small :to="{ name: 'user.info', params: { id: item.id } }">
							<v-icon small>mdi-eye</v-icon>
						</v-btn>
						<w-dropdown-menu
							left bottom
							:items="menu_items(item)"
						></w-dropdown-menu>
					</template>
					<template #[`item.mobile_num`]="{ item }">
						<span>{{ item.mobile_num || '-' }}</span>
					</template>
				</v-data-table>
			</v-card>
			<!-- form dialog -->
			<v-dialog
				v-model="form_dialog_"
				max-width="550px"
				persistent
				scrollable
			>
				<UserForm
					:item="form_item_"
					:action="form_action_"
					:visible.sync="form_dialog_"
					@initialize="initialize_()"
				></UserForm>
			</v-dialog>
			<v-dialog v-model="accountVerificationDialog" max-width="550px" persistent>
				<user-verification-form
					:user="form_item_"
					:visible.sync="accountVerificationDialog"
					@initialize="() => {
						accountVerificationDialog = false
						initialize_()
					}"
				></user-verification-form>
			</v-dialog>
			<!-- filter dialog -->
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
									class="text-caption"
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
			<!-- Sort dialog -->
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
		</v-container>
	</v-sheet>
</template>

<script>
import UserForm from "./UserForm.vue"
import ActionBtnGroup from "@src/components/ActionBtnGroup.vue"
import WDropdownMenu from "@shared/widgets/WDropdownMenu.vue"
import SearchBar from "@src/components/SearchBar.vue"
import SideDialog from "@src/components/SideDialog.vue"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import UserVerificationForm from './UserVerificationForm.vue'
import UserClient from '../client'
export default{
	components:{
		UserForm,
		ActionBtnGroup,
		WDropdownMenu,
		SearchBar,
		SideDialog,
		UserVerificationForm,
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
				// { text: 'Avatar', value: 'avatar' },
				{ text: 'Name', value: 'name' },
				{text:'Email',value:'email'},
				// { text: 'Mobile Num', value: 'mobile_num' },
				// { text: 'Role', value: 'role' },
				{ text: 'Created at', value: 'created_at' },
				{ text: 'Actions', value: 'action', class: 'text-center' },
			],

			filter_dialog: false,
			sort_dialog: false,

			filter_options:[],
			sort_options:[],
			searchBy_options: [
				{ value: 'id', text: 'ID' },
				{ value: 'name', text: 'Name' },
				{ value: 'email', text: 'Email' },
			],
			accountVerificationDialog : false,
		}
	},
	created(){

		this.options_.activity = this.getActivityRefs_()
		this.options_.user_type = this.getUserTypeRefs()
		this.getAllRefs_([
			// async methods
		]).then(()=>{
			this.setupFilterBar()
			this.initFilters()
			this.search_.searchBy = 'name'
			this.setupSortOptions()
		}).then(()=>{
			this.initialize_()
		})
	},
	methods:{
		initFilters(){
			this.filters_ = {
				activity : 1,
				role_name : null,
			}
		},
		getResourceData_(){
			let payload = {
				...this.setPagination_(),
				...this.search_,
				...this.filters_,
				...this.sort_,
			}
			this.model_loading_ = true
			UserClient.getList(payload).then((res)=>{
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
			UserClient.archive(payload).then((res) => {
				this.initialize_();
				this.$toast.success(res.data.message)
			}).catch((err) => {
				this.errorHandler_(err)
			})
		},
		setupFilterBar(){
			this.filter_options = [
				// {
				// 	cols: 12,
				// 	model: "role_name",
				// 	label: "Role Type",
				// 	items: [ { value: null, text: "All" }, ...this.options_.user_type || [] ],
				// },
				{
					cols: 12,
					model: "activity",
					label: "Activity",
					items: this.options_.activity,
				},
			]
		},
		setupSortOptions(){
			this.sort_options = [
				{ label: "id (ASC)", value: {sortBy: "id", sortDesc : 0 } },
				{ label: "id (DESC)", value: {sortBy: "id", sortDesc : 1 } },
				{ label: "Oldest", value: {sortBy: "created_time", sortDesc : 0 } },
				{ label: "Latest", value: {sortBy: "created_time", sortDesc : 1 } }
			]
			this.sort_ = this.sort_options[3].value
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
					icon: "mdi-account-check", title: "Verification Info",
					action: () => {
						this.bindAction_("verification-info", item)
						this.accountVerificationDialog = true
					}
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
				},
				// {
				// 	icon: "mdi-download",
				// 	disabled: this.model_loading_,
				// 	action: () => { this.download() }
				// },
			]
		},
		download(){
			let payload = {
				...this.search_,
				...this.filters_,
				...this.sort_,
			}
			this.model_loading_ = true
			UserClient.exportList(payload).then((res)=>{
				let result = res.data.data
				this.downloadFile_(result.fileUrl, result.fileName)
			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.model_loading_ = false
			})
		},
		getUserTypeRefs(){
			return [
				{value: "non-member-customer", text: "Non-member"},
				{value: "member-customer", text: "Member"},
			];
		}
	}
}
</script>
