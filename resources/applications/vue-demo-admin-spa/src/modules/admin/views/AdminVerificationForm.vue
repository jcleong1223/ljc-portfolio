<template>
	<v-card class="radius-10">
		<v-card-title>
			<span class="text-h5">Account Verification</span>
		</v-card-title>
		<v-divider></v-divider>
		<v-card-text class="pt-4">
			<v-row dense class="form-gap-2 ma-0">
				{{ admin.email_verified_at }}
				<v-col cols="12">
					<v-row dense align="center">
						<v-col cols="auto">Name:</v-col>
						<v-col>{{ admin.name }}</v-col>
					</v-row>
					<v-row dense align="center">
						<v-col cols="auto">Email:</v-col>
						<v-col>{{ admin.email }}</v-col>
					</v-row>
					<v-row dense align="center">
						<v-col cols="auto">Status:</v-col>
						<v-col cols="auto">
							<div v-if="admin.email_verified_at" class="text-caption">
								( <v-icon color="success" small>mdi-check-decagram</v-icon> Verified At: <span class="font-italic">{{ $dayjs(admin.email_verified_at).format("YYYY-MM-DD hh:mma") }}</span> )
							</div>
							<div v-else>
								<span class="text-caption warning--text">Unverified</span>
							</div>
						</v-col>
						<v-col cols="12">
							<v-btn
								:color="admin.email_verified_at ? 'error' : 'warning'"
								x-small
								outlined
								rounded
								class="px-4 py-3"
								:loading="toggleVerificationLoading"
								@click="confirmOpenBox(null, ()=> toggleVerificationStatus())"
							>
								<v-icon left>mdi-account-edit</v-icon>
								{{ admin.email_verified_at ? 'Mark as unverified' : 'Mark as verified' }}
							</v-btn>
						</v-col>
					</v-row>
				</v-col>
				<v-col v-if="!admin.email_verified_at" cols="12" md="12">
					<v-divider class="mt-1 mb-3"></v-divider>
					<v-btn
						color="error"
						small
						outlined
						:loading="resendVerificationEmailLoading"
						@click="confirmOpenBox(null, ()=> resendVerificationEmail())"
					>
						<v-icon left>mdi-email-sync</v-icon>
						Resend Verification Email
					</v-btn>
				</v-col>
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
		</v-card-actions>
	</v-card>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import AdminClient from '../client'
export default {
	components: { },
	mixins: [
		errorHandlerMixin
	],
	props:{
		admin:{
			type: Object,
			default: () => {
				return {}
			}
		},
		visible: {
			type: Boolean,
			required: true,
		},
	},
	data () {
		return {
			toggleVerificationLoading : false,
			resendVerificationEmailLoading: false,
		}
	},
	watch:{
		'visible':{
			handler: function (newVal){
				if(newVal){
					//
				}else{
					// reset
					this.errors = {}
				}
			},
			immediate : true,
		},
	},
	created(){
	},
	methods: {
		closeDialog(){
			this.$emit('update:visible',false)
		},
		confirmOpenBox(item, callback){
			this.$swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
			}).then((res)=>{
				if(res.value){
					callback()
				}
			})
		},
		toggleVerificationStatus(){
			this.toggleVerificationLoading = true
			let payload = {
				id : this.admin.id,
			}
			AdminClient.toggleVerificationStatus(payload).then((res)=>{
				this.$toast.success(res.data.message)
				this.$emit('initialize')
			}).catch((err) => {
				this.errorHandler_(err)
			}).finally(()=>{
				this.toggleVerificationLoading = false
			})
		},
		resendVerificationEmail(){
			this.resendVerificationEmailLoading = true
			let payload = {
				id : this.admin.id,
			}
			AdminClient.resendVerificationEmail(payload).then((res)=>{
				this.$toast.success(res.data.message)
			}).catch((err) => {
				this.errorHandler_(err)
			}).finally(()=>{
				this.resendVerificationEmailLoading = false
			})
		}
	}
}
</script>