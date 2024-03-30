<template>
	<v-container>
		<!-- introduction -->
		<v-row align="end">
			<v-col>
				<div class="text-h5 font-weight-bold">General Setting</div>
				<div class="subtitle-2 grey--text">General Settings that registered in this system.</div>
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
				placeholder="Search Key"
				@search="searchData_()"
			></search-bar>
		</v-row>
		<v-row
			v-if="resourceData_"
			class="mt-4"
			color="transparent" flat
		>
			<template v-for="setting_key in Object.keys(resourceData_)">
				<v-col :key="setting_key" cols="12">
					<v-card>
						<v-card-title class="font-weight-bold text-h5 pl-6">{{ startCase(setting_key) }}</v-card-title>
						<v-divider class="mx-2"></v-divider>
						<v-card-text class="pa-0">
							<v-data-table
								:headers="table_headers"
								:items="resourceData_[setting_key]"
								:server-items-length="resourceData_[setting_key].length"
								:loading="model_loading_"
								disable-sort
								hide-default-footer
								:item-class="row_classes_"
								:items-per-page="-1"
							>
								<template #[`item.value`]="{ item }">
									{{ item.data_type == "json" ? item.content : item.value }}
								</template>
								<template #[`item.action`]="{ item }">
									<v-btn
										icon small
										:disabled="!item.is_editable"
										@click="editItem_(item)"
									>
										<v-icon small>{{ item.is_editable ? "mdi-pencil" : "mdi-pencil-lock" }}</v-icon>
									</v-btn>
								</template>
							</v-data-table>
						</v-card-text>
					</v-card>
				</v-col>
			</template>
			<template v-if="resourceData_.length == 0">
				<v-col cols="12">
					<v-card class="pa-12 text-center">
						<div>
							<v-icon class="text-h3 text-md-h2">mdi-package-variant</v-icon>
						</div>
						<div class="text-body-2 pt-2">No Data Available</div>
					</v-card>
				</v-col>
			</template>
		</v-row>
		<v-row v-else>
			<v-col cols="12">
				<v-skeleton-loader
					type="table-tbody"
				></v-skeleton-loader>
			</v-col>
		</v-row>

		<!-- form dialog -->
		<v-dialog v-model="form_dialog_" max-width="550px" persistent>
			<GeneralSettingForm
				:item="form_item_" :action="form_action_" :visible.sync="form_dialog_"
				@initialize="initialize_()"
			></GeneralSettingForm>
		</v-dialog>
	</v-container>
</template>

<script>
import GeneralSettingForm from "./GeneralSettingForm.vue"
import SearchBar from "@src/components/SearchBar"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import startCase from 'lodash/startCase'
import GeneralSettingClient from '../client'
export default{
	components:{
		GeneralSettingForm,
		SearchBar,
	},
	mixins: [
		resourceMixin,
		formActionMixin,
		errorHandlerMixin
	],
	data(){
		return {
			table_headers : [
				{ text: 'Key', value: 'key' },
				{ text: 'Value', value: 'value' },
				{ text: 'Description', value: 'description' },
				{ text: 'Actions', value: 'action', class: 'text-center' },
			],
		}
	},
	created(){
		this.getAllRefs_([
			// async methods
		]).then(()=>{
			//
		}).then(()=>{
			this.initialize_()
		})
	},
	methods:{
		getResourceData_(){
			this.resourceData_ = {};
			let payload = {
				...this.search_,
			}
			this.model_loading_ = true
			GeneralSettingClient.getList(payload).then((res)=>{
				const result = res.data
				this.resourceData_ = result.data
			}).catch((err)=>{
				this.errorHandler_(err)
			}).finally(()=>{
				this.model_loading_ = false
			})
		},
		menu_items(item){
			return [
				{
					icon: "mdi-square-edit-outline", title: "Edit",
					action: () => { this.editItem_(item) }
				},
			]
		},
		startCase(val){
			return startCase(val)
		},
	}
}
</script>
