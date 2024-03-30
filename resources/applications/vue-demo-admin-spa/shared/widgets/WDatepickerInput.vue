<template>
	<v-dialog
		ref="dialog"
		v-model="modal"
		:return-value.sync="date__"
		persistent
		width="300px"
	>
		<template #activator="scopeData">
			<slot
				name="activator"
				:on="scopeData.on"
				:attrs="scopeData.attrs"
			></slot>
		</template>
		<v-date-picker
			v-model="date__"
			scrollable
			width="100%"
		>
			<v-spacer></v-spacer>
			<v-btn
				text
				color="primary"
				@click="modal = false"
			>
				Cancel
			</v-btn>
			<v-btn
				text
				color="primary"
				@click="saveDate()"
			>
				OK
			</v-btn>
		</v-date-picker>
	</v-dialog>
</template>

<script>
export default {
	props:{
		value:{
			type: [String],
			default: null,
		},
	},
	data(){
		return {
			modal: false,
			date__: null,
		}
	},
	watch:{
		'value':{
			handler(){
				this.date__ = this.value
			},
			immediate: true,
		}
	},
	methods:{
		saveDate(){
			this.$refs.dialog.save(this.date__)
			this.$emit('input', this.date__)
		}
	}
}
</script>