<template>
	<v-sheet color="transparent">
		<v-container class="mt-6 pa-0">
			<v-breadcrumbs class="pt-0" :items="breadcrumbs_data" large></v-breadcrumbs>
			<v-card
				:class="{
					'card-softdeleted' : resourceData_.deleted_at,
				}"
			>
				<v-card-title class="background-x pa-0">
					<v-row class="ma-0 px-4 py-2" align="center">
						<!-- <v-col cols="auto">
							<v-img
								v-if="resourceData_.avatar"
								width="80px"
								height="80px"
								class="radius-rounded"
								:src="resourceData_.avatar.file_url"
							></v-img>
						</v-col> -->
						<v-col>
							<div class="text-h5 font-weight-bold">{{ resourceData_.name }}</div>
						</v-col>
						<v-col cols="auto" class="pa-0" align-self="start">
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
							:to="tab.to"
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
										:data-blocks="dataBlockValues"
										class="ma-0"
									>
										<template #[`item-block-value.status`]="{ item }">
											<div class="font-weight-bold">
												<span v-if="item.deleted_at" class="error--text">Archived</span>
												<span v-else class="success--text">Active</span>
											</div>
										</template>
										<template #[`item-block-value.email`]="{ item }">
											<div>
												{{ item.email }}
												<v-icon
													v-if="item.email_verified_at"
													color="success"
													small
												>
													mdi-check-decagram
												</v-icon>
											</div>
											<div v-if="item.email_verified_at" class="text-caption">(Verified at: {{ $dayjs(item.email_verified_at).format('YYYY-MM-DD hh:mma') }})</div>
										</template>
										<template #[`item-block-value.role`]="{ item }">
											{{ item.roles.map((item)=> item.display_name).join(', ') }}
										</template>
										<template #[`item-block-value.created_at`]="{ item }">
											{{ $dayjs(item.created_at).format('YYYY-MM-DD hh:mma') }}
										</template>
									</WDataBlock>
								</v-card-text>
							</v-card>
						</v-tab-item>
						<v-tab-item value="account">
							<v-card>
								<v-card-text>
									<v-row class="ma-0" align="center">
										<v-col cols="auto">
											<div class="title">Social Sign-in :</div>
										</v-col>
										<v-col v-if="resourceData_.socializes && resourceData_.socializes.length == 0">
											<span class="grey--text font-italic">No Data</span>
										</v-col>
										<v-col
											v-for="socialize in resourceData_.socializes" :key="socialize.id"
											cols="auto"
											class="pr-0"
										>
											<v-chip outlined color="primary" class="text-capitalize px-6">
												{{ socialize.type_value }}
											</v-chip>
										</v-col>
									</v-row>
									<v-divider></v-divider>
									<v-row v-if="$auth.user().all_permissions.includes('access-backend-content')" class="ma-0">
										<v-col cols="12">
											<div class="title">Active Sessions :</div>
										</v-col>
										<v-col v-if="resourceData_.tokens && resourceData_.tokens.length == 0">
											<span class="grey--text font-italic">No Data</span>
										</v-col>
										<v-col
											v-for="token in resourceData_.tokens" :key="token.id"
											cols="12" md="4"
										>
											<v-card color="background">
												<v-card-text>
													<v-row dense>
														<v-col cols="12">
															<v-icon left>mdi-devices</v-icon>{{ token.name }}
														</v-col>
														<v-col cols="12" class="text-caption">
															<div>> Last used at {{ $dayjs(token.last_used_at).format("DD MMM YYYY, hh:mma") }}</div>
															<div>> Signed in on {{ $dayjs(token.created_at).format("DD MMM YYYY, hh:mma") }}</div>
														</v-col>
														<v-divider class="mx-1 my-2"></v-divider>
														<v-col cols="12" class="text-right">
															<v-btn
																color="error"
																small outlined
																class="text-capitalize"
																:loading="revoke_token_loading"
																@click="confirmRevokeToken(token)"
															>
																Revoke
															</v-btn>
														</v-col>
													</v-row>
												</v-card-text>
											</v-card>
										</v-col>
									</v-row>
								</v-card-text>
							</v-card>
						</v-tab-item>
					</v-tabs-items>
				</v-card-text>
			</v-card>
			<v-dialog
				v-model="form_dialog_"
				max-width="550px"
				persistent
				scrollable
			>
				<AdminForm
					:item="form_item_" :action="form_action_" :visible.sync="form_dialog_"
					:role-types="options_.admin_type"
					@initialize="initialize_()"
				></AdminForm>
			</v-dialog>
			<v-dialog v-model="accountVerificationDialog" max-width="550px" persistent>
				<admin-verification-form
					:admin="resourceData_"
					:visible.sync="accountVerificationDialog"
					@initialize="initialize_()"
				></admin-verification-form>
			</v-dialog>
		</v-container>
	</v-sheet>
</template>

<script>
import AdminForm from "./AdminForm.vue"
import WDataBlock from "@shared/widgets/DataBlock/WDataBlock.vue"
import WDropdownMenu from "@shared/widgets/WDropdownMenu.vue"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { resourceMixin } from "@src/mixins/ResourceMixin"
import AdminClient from '../client'
import AdminVerificationForm from './AdminVerificationForm.vue'
import { DataBlockOption } from '@shared/widgets/DataBlock/DataBlockOption'
export default{
	components: {
		AdminForm,
		WDataBlock,
		WDropdownMenu,
		AdminVerificationForm,
	},
	mixins: [
		resourceMixin,
		formActionMixin,
		errorHandlerMixin
	],
	data(){
		return {
			infoID: null,
			dataBlockValues: [
				DataBlockOption.constructTextValue('Name', 'name'),
				DataBlockOption.constructTextValue('Email', 'email'),
				DataBlockOption.constructTextValue('Status', 'status'),
				DataBlockOption.constructTextValue('Role', 'role'),
				DataBlockOption.constructTextValue('Registered', 'created_at'),
			],
			tab_model: null,
			tabs: [
				{ title: 'Overview', value: 'overview' },
				// { title: 'Account', value: 'account' },
				// { title: 'Orders', to: { name: 'order.list', query: { admin_id : this.$route.params.id }} },
			],
			revoke_token_loading: false,
			upload_progress: null,
			breadcrumbs_data: [],
			accountVerificationDialog: false,
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
			{ text: 'Admin List', disabled: false, to: { name: 'admin.list' }, exact: true },
			{ text: 'Admin Info', disabled: true },
		];

		this.initialize_()
	},
	methods:{
		getResourceData_(){
			AdminClient.getInfo(this.infoID).then((res) => {
				this.resourceData_ = res.data.data
			}).catch((err) => {
				this.errorHandler_(err)
			})
			this.model_loading_ = true
		},
		menu_items(item = {}) {
			let menu_items = [
				{
					icon: "mdi-square-edit-outline", title: "Edit",
					action: () => { this.editItem_(item) }
				},
				{
					icon: "mdi-account-check", title: "Verification Info",
					action: () => { this.accountVerificationDialog = true }
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
		archiveModel_(item){
			let payload = {
				id : item.id
			}
			AdminClient.archive(payload).then((res) => {
				this.initialize_();
				this.$toast.success(res.data.message)
			}).catch((err) => {
				this.errorHandler_(err)
			})
		},
		changeUrlQuery(){
			this.$nextTick(()=>{
				window.history.replaceState(null, null, '?tab='+ this.tab_model);
			});
		},
		// confirmRevokeToken(token){
		// 	this.$swal({
		// 		title: 'Are you sure?',
		// 		text: "You won't be able to revert this!",
		// 		type: 'warning',
		// 		showCancelButton: true,
		// 	}).then((res)=>{
		// 		if(res.value){
		// 			this.revokeToken(token)
		// 		}
		// 	})
		// },
		// revokeToken(token){
		// 	this.revoke_token_loading = true;
		// 	let payload = {
		// 		admin_id : token.tokenable_id,
		// 		token_id : token.id,
		// 	}
		// 	AdminClient.revokeSessionToken(payload).then((res) => {
		// 		this.getResourceData_()
		// 	}).catch((err) => {
		// 		this.errorHandler_(err)
		// 	}).finally(()=>{
		// 		this.revoke_token_loading = false;
		// 	})
		// },
	}
}
</script>
