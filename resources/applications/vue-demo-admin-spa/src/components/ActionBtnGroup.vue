<template>
	<v-card flat>
		<template v-for="(item,i) in items">
			<v-btn
				:key="i"
				text small
				outlined
				tile
				:disabled="item.disabled || null "
				@click="item.action()"
			>
				<v-icon small>{{ item.icon }}</v-icon>
			</v-btn>
		</template>
	</v-card>
</template>

<script>
export default{
	props:{
		items:{
			type: Array,
			default: ()=>{
				return []
			}
		},
	},
	data(){
		return {
		}
	},
	methods:{
	}
}
</script>