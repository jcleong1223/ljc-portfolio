<template>
	<v-card class="radius-10">
		<v-card-title>
			<span class="text-h5">Update Password</span>
		</v-card-title>
		<v-divider class="mb-4"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense class="form-gap-2">
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
				@click="confirmOpenBox(form)"
			>
				Save
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
			form : {},
			errors : {},
			submit_loading : false,
		}
	},
	watch:{
		'visible':{
			handler: function (newVal){
				if(newVal){
					//
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
	},
	methods: {
		closeDialog(){
			this.$emit('update:visible',false)
		},
		confirmOpenBox(item){
			this.$swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
			}).then((res)=>{
				if(res.value){
					this.saveModel(item)
				}
			})
		},
		saveModel(item){
			this.submit_loading = true
			this.errors = {}
			let payload = {
				id : this.admin.id,
				password : item.password,
				password_confirmation : item.password_confirmation,
			}
			AdminClient.updatePassword(payload).then((res)=>{
				this.$toast.success(res.data.message)
				this.closeDialog()
			}).catch((err) => {
				this.errors = this.errorHandler_(err, ["password",'password_confirmation'])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
	}
}
</script>