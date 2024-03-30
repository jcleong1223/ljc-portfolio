<template>
	<v-navigation-drawer
		v-model="value__"
		floating
		app
		right
		temporary
		:style="$vuetify.breakpoint.mdAndUp ? 'min-width: 350px;' : '' "
		@input="$emit('input',value__)"
	>
		<v-row
			class="ma-0"
			align="center"
		>
			<v-col cols="12">
				<!-- title -->
				<slot name="title">
					<v-row dense>
						<v-col class="text-h6" cols="auto">{{ title }}</v-col>
						<v-spacer></v-spacer>
						<v-col v-if="clearable" cols="auto">
							<!-- <v-btn
								color="error"
								fab x-small depressed
								@click="emitClear()"
							>
								<v-icon>mdi-undo-variant</v-icon>
							</v-btn> -->
						</v-col>
					</v-row>
				</slot>
			</v-col>
			<v-divider class="mx-2"></v-divider>
			<v-col cols="12" class="py-4">
				<!-- default -->
				<slot></slot>
			</v-col>
			<v-col class="pt-0">
				<!-- actions -->
				<slot name="actions"></slot>
			</v-col>
		</v-row>
	</v-navigation-drawer>
</template>

<script>
export default{
	props:{
		value:{
			type: Boolean,
			default: false
		},
		title:{
			type: String,
			default: 'Form'
		},
		clearable:{
			type: Boolean,
			default: false
		},
	},
	data(){
		return {
			value__ : false,
		}
	},
	watch:{
		"value":{
			handler(){
				this.value__ = this.value
			},
		}
	},
	methods:{
		emitClear(){
			this.$emit('clear')
		}
	}
}
</script>
