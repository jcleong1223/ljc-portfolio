<template>
	<div>
		<v-card class="radius-10">
			<v-card-text class="py-4 overflow-auto">
				<v-row dense class="form-gap-2">
					<v-col cols="12" md="12">
						<v-text-field
							v-model="form.key"
							label="Key" placeholder="Key"
							dense
							readonly disabled
							:error-messages="errors.key"
						></v-text-field>
					</v-col>
					<v-col cols="12" md="12">
						<template v-if="form.data_type == 'json'">
							<v-textarea
								v-model="form.value"
								label="Value" placeholder="Value"
								dense
								outlined rows="3"
								:error-messages="errors.value"
							></v-textarea>
						</template>
						<template v-else-if="form.data_type == 'boolean'">
							<div class="text-caption">Value</div>
							<v-switch
								v-model="form.value"
								dense
								outlined rows="3"
								class="mt-0"
								:error-messages="errors.value"
							></v-switch>
						</template>
						<template v-else>
							<v-text-field
								v-model="form.value"
								label="Value" placeholder="Value"
								dense
								:error-messages="errors.value"
							></v-text-field>
						</template>
					</v-col>
					<v-col cols="12" md="12">
						<v-textarea
							v-model="form.description"
							label="Description" placeholder="Description"
							dense hide-details
							outlined rows="3"
							:error-messages="errors.description"
						></v-textarea>
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
					@click="submitForm(form)"
				>
					Save
				</v-btn>
			</v-card-actions>
		</v-card>
	</div>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import GeneralSettingClient from '../client'
export default{
	components:{
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
					if(this.form.data_type == "json"){
						this.form.value = this.form.content
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
			let payload = item
			GeneralSettingClient.update(payload).then((res)=>{
				this.$toast.success(res.data.message)
				this.initialize()
			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					"value",
				])
			}).finally(()=>{
				this.submit_loading = false
			})
		},
	}
}
</script>
