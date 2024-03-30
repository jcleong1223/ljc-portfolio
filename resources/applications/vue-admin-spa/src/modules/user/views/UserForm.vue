<template>
	<v-card class="radius-10">
		<v-card-title>
			<span class="text-h5">{{ (action == 'edit') ? 'Edit User' : 'Create User' }}</span>
		</v-card-title>
		<v-divider class="mb-2"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense class="form-gap-2">
				<v-col cols="12" md="12">
					<v-text-field
						v-model="form.name"
						label="Name" placeholder="Name"
						dense
						:error-messages="errors.name"
					></v-text-field>
				</v-col>
				<v-col cols="12" md="12">
					<v-text-field
						v-model="form.email"
						type="email"
						label="Email" placeholder="Email"
						dense
						:error-messages="errors.email"
					></v-text-field>
				</v-col>
				<template v-if="action == 'edit' ">
					<v-col cols="12" md="auto">
						<v-btn
							small outlined
							color="info"
							@click="editPassword()"
						>
							<v-icon left small>mdi-lock</v-icon>
							Edit Password
						</v-btn>
					</v-col>
					<v-col cols="12" md="auto">
						<v-btn
							small outlined
							color="error"
							:loading="resetPassword_loading"
							@click="helpResetPassword()"
						>
							<v-icon left small>mdi-email-alert</v-icon>
							Reset Password
						</v-btn>
					</v-col>
				</template>
				<template v-else>
					<v-col cols="12" md="12">
						<v-checkbox
							v-model="form.send_email"
							label="Send Activation Email"
							dense
							class="ma-0"
						></v-checkbox>
					</v-col>
				</template>
			</v-row>
		</v-card-text>
		<v-card-actions>
			<v-spacer></v-spacer>
			<v-btn
				color="blue darken-1" text title="Cancel"
				@click="closeDialog()"
			>
				Cancel
			</v-btn>
			<v-btn
				color="blue darken-1"
				text title="Save"
				:loading="submit_loading"
				@click="submitForm(form)"
			>
				Save
			</v-btn>
		</v-card-actions>

		<v-dialog v-model="changePassword_dialog" max-width="550px" persistent>
			<UpdatePasswordForm :visible.sync="changePassword_dialog" :user="form"></UpdatePasswordForm>
		</v-dialog>
	</v-card>
</template>

<script>
import UpdatePasswordForm from './UpdatePasswordForm.vue'
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import UserClient from '../client'
import RefClient from '@src/modules/ref/client'
export default{
	components:{
		UpdatePasswordForm,
	},
	mixins: [
		errorHandlerMixin
	],
	props:{
		visible: {
			type: Boolean,
			required: true,
		},
		item: {
			type: Object,
			required: true,
			default: ()=>{
				return {}
			}
		},
		action: {
			type: String,
			required: true,
		},
	},
	data () {
		return {
			form : {},
			errors : {},
			submit_loading : false,
			changePassword_dialog: false,
			resetPassword_loading: false,
			states: [],
		}
	},
	watch:{
		'item':{
			handler(){
				this.form = this.item
			},
			immediate: true,
		},
		'visible':{
			handler: function (newVal){
				if(newVal){
					if(this.action == "new"){
						this.form.send_email = true
					}
				}else{
					// reset
					this.form = {}
					this.errors = {}
				}
			},
			immediate : true,
		},
	},
	created(){
		RefClient.getStateList().then((res)=>{
			this.states = res.data.data
		}).catch((err)=>{
			this.errorHandler_(err)
		})
	},
	methods: {
		initialize(){
			this.closeDialog()
			this.$emit('initialize')
		},
		closeDialog(){
			this.$emit('update:visible', false)
		},
		submitForm(item){
			this.saveModel(item)
		},
		saveModel(item){
			this.submit_loading = true
			this.errors = {}
			let payload = {
				id : item.id,
				name : item.name,
				email : item.email,
				send_email : item.send_email,
			}
			let theApi = (this.action == "new") ? UserClient.create(payload) : UserClient.update(payload)
			theApi.then((res)=>{
				this.$toast.success(res.data.message)
				this.initialize()
			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					"id",
					"name",
					"email",
					"send_email",
				])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
		editPassword(){
			this.changePassword_dialog = true
		},
		helpResetPassword(){
			this.resetPassword_loading = true
			let payload = {
				id : this.form.id,
			}
			UserClient.emailResetPassword(payload).then((res)=>{
				this.$toast.success(res.data.message)
			}).catch((err) => {
				this.errorHandler_(err)
			}).finally(()=>{
				this.resetPassword_loading = false
			})
		}
	}
}
</script>

