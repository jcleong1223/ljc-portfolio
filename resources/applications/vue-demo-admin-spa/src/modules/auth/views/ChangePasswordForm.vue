<template>
	<v-card class="radius-10">
		<v-card-title>
			<span class="text-h5">Change Password</span>
		</v-card-title>
		<v-divider class="mb-4"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row v-if="has_old_password != null" dense class="form-gap-2">
				<v-col
					v-if="has_old_password == true"
					cols="12" md="12" class="pb-2"
				>
					<v-text-field
						v-model="form.current_password"
						type="password"
						label="Current Password"
						dense
						:error-messages="errors.current_password"
					></v-text-field>
				</v-col>
				<v-col cols="12" md="12" class="pb-2">
					<v-text-field
						v-model="form.password"
						type="password"
						label="New Password"
						dense
						:error-messages="errors.password"
					></v-text-field>
				</v-col>
				<v-col cols="12" md="12" class="pb-2">
					<v-text-field
						v-model="form.password_confirmation"
						type="password"
						label="Confirm New Password"
						dense
						:error-messages="errors.password_confirmation"
					></v-text-field>
				</v-col>
			</v-row>
			<v-skeleton-loader v-else type="paragraph"></v-skeleton-loader>
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
				@click="confirmSubmit(form)"
			>
				Save
			</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import AuthClient from '../client'
export default {
	components: { },
	mixins: [
		errorHandlerMixin
	],
	props:{
		visible: {
			type: Boolean,
			required: true,
		},
	},
	data () {
		return {
			form : {},
			errors : {},
			submit_loading : false,
			has_old_password : true,
		}
	},
	methods: {
		closeDialog(){
			this.$emit('update:visible',false)
		},
		confirmSubmit(item){
			this.submitForm(item)
		},
		submitForm(item){
			this.submit_loading = true
			this.errors = {}
			let payload = {
				current_password : item.current_password,
				password : item.password,
				password_confirmation : item.password_confirmation,
			}
			AuthClient.changePassword(payload).then(()=>{
				this.$toast.info('Password Successfully Updated, Please Login Again.')
				this.$auth.logout({
					redirect: {
						name: 'login'
					}
				});
			}).catch((err) => {
				this.errors = this.errorHandler_(err, ["current_password","password",'password_confirmation'])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
	}
}
</script>