<template>
	<v-card v-if="visible" class="radius-10">
		<v-card-title>
			<span class="text-h6"> {{ (action == 'edit') ? 'Edit Job Details' : 'Create Job Details' }}</span>
		</v-card-title>
		<v-divider class="ma-0"></v-divider>
		<v-card-text class="py-4 overflow-auto">
			<v-row dense>
				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.title"
						label="Title" placeholder="Title"
						dense
						:error-messages="errors.title"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.location"
						label="Location" placeholder="Location"
						dense
						:error-messages="errors.location"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.salary_range"
						label="Salary Range" placeholder="Salary Range"
						dense
						:error-messages="errors.salary_range"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.type"
						label="Job Type" placeholder="Full Time / Part Time"
						dense
						:error-messages="errors.type"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<ckeditor-input
						v-model="dataForm.description"
						label="Description"
						:error-messages="errors.description"
					></ckeditor-input>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.career_level"
						label="Career Level" placeholder="Manager"
						dense
						:error-messages="errors.career_level"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.exp_required"
						label="Years of Experience" placeholder="5 Years"
						dense
						:error-messages="errors.exp_required"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.specializations"
						label="Job Specializations" placeholder="Services / Legal Assistant"
						dense
						:error-messages="errors.specializations"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.qualifications"
						label="Qualification" placeholder="Bachelor's Degree"
						dense
						:error-messages="errors.qualifications"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-text-field
						v-model="dataForm.seq_value"
						type="number" step="1"
						label="Sequence (Largest to Lowest)" placeholder="1,2,3..."
						dense
						:error-messages="errors.seq_value"
					></v-text-field>
				</v-col>

				<v-col cols="12" md="12">
					<v-select
						v-model="dataForm.status"
						:items="[
							{ text: 'Active', value : 1 },
							{ text : 'Inactive', value : 0 }
						]"
						item-text="text"
						item-value="value"
						label="Status" placeholder="Status"
						dense
						:error-messages="errors.status"
					></v-select>
				</v-col>
			</v-row>
		</v-card-text>
		<v-divider class="mx-0"></v-divider>
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
				@click="submitForm(dataForm)"
			>
				Save
			</v-btn>
		</v-card-actions>
	</v-card>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
// import WDataSelection from '@shared/widgets/WDataSelection.vue'
import CareerClient from '../client'
import CkeditorInput from '@src/components/CkeditorInput.vue'

export default{
	components: {
		CkeditorInput,
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
	data() {
		return {
			dataForm: {},
			errors: {},
			submit_loading: false,
		}
	},
	watch:{
		'item':{
			handler() {
				this.dataForm = this.item
				if(this.dataForm.status == null){
					this.dataForm.status = 1;
				}
				if(this.dataForm.seq_value == null){
					this.dataForm.seq_value = 1;
				}
				if(this.dataForm.categories == null){
					this.$set(this.dataForm, 'categories', [])
				}

				if(this.dataForm.specifications == null){
					this.$set(this.dataForm, 'specifications', [])
					this.addSpecificationInput()
				}
				if(this.dataForm.media_contents){
					this.dataForm.media_contents = this.dataForm.media_contents.map((item)=>{
						item.file_url = item.content.file_url
						return item
					})
				}

			},
			immediate: true,
		},
		'visible': {
			handler: function(newVal) {
				if(newVal) {
					//
				} else {
					// reset
					this.dataForm = {}
					this.errors = {}
				}
			},
			immediate: true,
		},
	},
	created(){
	},
	methods: {
		initialize() {
			this.closeDialog()
			this.$emit('initialize')
		},
		closeDialog(){
			this.$emit('update:visible', false)
		},
		submitForm(item){
			this.errors = {}
			this.saveModel(item)
		},
		saveModel(item) {
			this.submit_loading = true
			
			let payload = new FormData()
			payload.append("id", item.id)
			payload.append("title", item.title ?? '');
			payload.append("location", item.location ?? '');
			payload.append("type", item.type ?? '');
			payload.append("salary_range", item.salary_range ?? '');
			payload.append("description", item.description ?? '');
			payload.append("career_level", item.career_level ?? '');
			payload.append("exp_required", item.exp_required ?? '');
			payload.append("status", item.status ?? '');
			payload.append("seq_value", item.seq_value ?? '');
			payload.append("specializations", item.specializations ?? '');
			payload.append("qualifications", item.qualifications ?? '');
			
			let theApi = (this.action == "new") ? CareerClient.createCareer(payload) : CareerClient.updateCareer(payload)
			theApi.then((res) => {
				this.$toast.success(res.data.message)
				this.initialize()

			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					'title',
					'location',
					'salary_range',
					'type',
					'description',
					'career_level',
					'status',
					'seq_value',
					'exp_required',
					'specializations',
					'qualifications'
				])
			}).finally(() => {
				this.submit_loading = false
			})
		},
	}
}
</script>