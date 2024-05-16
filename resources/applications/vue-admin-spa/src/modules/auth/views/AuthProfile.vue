<template>
	<v-container>
		<v-card class="pa-6">
			<v-row>
				<v-col cols="12">
					<div class="text-h5 font-weight-bold pa-2">My Account</div>
					<v-divider class="px-1"></v-divider>
					<v-col cols="12" md="6">
						<v-row dense class="form-gap-2">
							<v-col cols="12" md="12" class="pb-2 pt-4">
								<v-text-field
									v-model="dataFrom.email"
									label="Email" placeholder="Email"
									outlined dense
									disabled
									:error-messages="errorCollector.email"
								></v-text-field>
							</v-col>
							<v-col cols="12" md="12" class="pb-2">
								<v-text-field
									v-model="dataFrom.name"
									label="Username" placeholder="Username"
									outlined dense
								></v-text-field>
							</v-col>
							<v-col cols="12">
								<v-btn
									color="#527853"
									class="text-capitalize white--text font-weight-medium"
									:loading="submit_loading"
									@click="updateAuthProfile()"
								>
									Update
								</v-btn>
							</v-col>
						</v-row>
					</v-col>
				</v-col>
				<v-col cols="12">
					<div class="text-h5 font-weight-bold pa-2">Change Password</div>
					<v-divider class="px-1"></v-divider>
					<div class="text-caption grey--text pa-1">Changing your account password and logout all login device.</div>
					<v-col cols="12" md="6">
						<v-btn
							color="error" outlined
							class="text-capitalize"
							@click="changePasswordDialog()"
						>
							Change Password
						</v-btn>
					</v-col>
				</v-col>
			</v-row>
		</v-card>

		<v-dialog v-model="changePassword_dialog" max-width="550px" persistent>
			<ChangePasswordForm :visible.sync="changePassword_dialog"></ChangePasswordForm>
		</v-dialog>
	</v-container>
</template>

<script>
import ChangePasswordForm from './ChangePasswordForm.vue'
import { formActionMixin } from "@src/mixins/FormActionMixin"
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import AuthClient from '../client'
export default{
	components:{
		ChangePasswordForm,
	},
	mixins: [
		formActionMixin,
		errorHandlerMixin,
	],
	data(){
		return {
			dataFrom: {},
			errorCollector: {},
			changePassword_dialog : false,
			submit_loading: false,
			upload_progress:null,
		}
	},
	created(){
		this.setFormData()
	},
	methods:{
		updateAuthProfile(){
			this.submit_loading = true
			this.errorCollector = {}
			let payload = this.dataFrom
			AuthClient.updateAuthProfile(payload).then((res)=>{
				this.$toast.success(res.data.message)
				this.$auth.fetch().then(()=>{
					this.setFormData()
				})
			}).catch((err) => {
				this.errorCollector = this.errorHandler_(err, ['email'])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
		changePasswordDialog(){
			this.changePassword_dialog = true
		},
		setFormData(){
			let authUser = this.$auth.user();
			this.dataFrom = {
				id: authUser.id,
				name: authUser.name,
				email: authUser.email,
				avatar: authUser.avatar,
			}
		},
	}
}
</script>