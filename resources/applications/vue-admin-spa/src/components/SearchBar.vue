<template>
	<v-row dense>
		<v-col cols="12" md="auto">
			<v-row class="v-btn-toggle fill-width" no-gutters>
				<v-col>
					<v-text-field
						v-model="search__"
						:placeholder="placeholder"
						color="primary"
						dense hide-details
						height="32"
						outlined
						clearable
						class="__input-dense"
						@keyup.enter="emitSearch()"
						@click:clear="()=>{
							$emit('update:search', '')
							emitSearch()
						}"
						@input="(val)=>{ $emit('update:search', val) }"
					></v-text-field>
				</v-col>
				<v-col cols="auto">
					<v-btn
						small
						color="primary"
						height="32"
						class="px-4 ml-n1 mr-5"
						:disabled="disabled"
						@click="emitSearch()"
					>
						<v-icon>mdi-magnify</v-icon>
					</v-btn>
				</v-col>
			</v-row>
		</v-col>
		<v-col v-show="items.length > 0" cols="12" md="auto">
			<v-select
				v-model="searchBy__"
				height="32"
				label="Search By"
				class="__input-dense text-caption"
				dense hide-details
				outlined
				:items="items"
				@input="(val)=>{ $emit('update:searchBy', val) }"
			></v-select>
		</v-col>
	</v-row>
</template>

<script>
export default{
	props:{
		search:{
			type: String,
			default: ""
		},
		searchBy:{
			type: String,
			default: ""
		},
		items:{
			type: Array,
			default: ()=>{
				return []
			}
		},
		disabled:{
			type: Boolean,
			default: false
		},
		placeholder: {
			type: String,
			default: "Search"
		}
	},
	data(){
		return {
			search__ : null,
			searchBy__ : "",
		}
	},
	watch:{
		"search":{
			handler(newVal){
				this.search__ = newVal
			},
			immediate: true,
		},
		"searchBy":{
			handler(newVal){
				this.searchBy__ = newVal
			},
			immediate: true,
		}
	},
	methods:{
		emitSearch(){
			this.$emit('search')
		}
	}
}
</script>