<template>
	<v-card
		outlined
		class="pl-6 py-2 fill-height radius-10"
		:style="'border-left: 5px solid '+color"
	>
		<v-row align="center" class="fill-height ma-0">
			<v-col cols="8" align-self="start">
				<div class="grey--text text-h5">{{ title }}</div>
				<div class="text-h6 font-weight-bold">{{ toThousandFilter(value) }}</div>
			</v-col>
			<v-col cols="4" align-self="end">
				<v-icon :color="color" :size="size">{{ icon }}</v-icon>
			</v-col>
		</v-row>
	</v-card>
</template>

<script>
import Helper from '@src/libs/HelperManager'
export default {
	components: {},
	props:{
		title: {
			type: String,
			required: true,
		},
		value: {
			type: [Number,String],
			required: false,
			default : 'N/A'
		},
		color: {
			type: String,
			required: false,
			default: undefined,
		},
		size: {
			type: [Number,String],
			required: false,
			default: 60
		},
		icon: {
			type: String,
			required: false,
			default: "mdi-information-outline"
		}
	},
	data () {
		return {
		}
	},
	created(){
	},
	methods: {
		toThousandFilter(value){
			return Helper.formatThousandSeparator(value);
		}
	}
}
</script>