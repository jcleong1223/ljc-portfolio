<template>
	<v-menu
		min-width="120px"
	>
		<template #activator="{ on }">
			<div
				class="primary--text pb-1 text-body-2"
				v-on="on"
			>
				{{ selectedLang }} <v-icon color="primary">mdi-menu-down</v-icon>
			</div>
		</template>
		<v-list
			dense
			color="secondary"
		>
			<v-list-item-group :value="selectedLang" color="primary">
				<v-list-item
					v-for="(language, i) in languages"
					:key="i"
					:value="language.title"
					@click="setLocale(language.value)"
				>
					<v-list-item-title>{{ language.title }}</v-list-item-title>
				</v-list-item>
			</v-list-item-group>
		</v-list>
	</v-menu>
</template>

<script>
import Cookies from 'js-cookie'
export default {
	data(){
		return {
			languages : [],
		}
	},
	computed:{
		selectedLang(){
			return this.languages.find((item)=> item.value == this.$i18n.locale)?.title
		}
	},
	created(){
		this.languages = [
			{ title: "ENG", value: 'en' },
			{ title: "BM", value: 'ms' },
			{ title: "中文", value: 'zh_CN' },
		]
	},
	methods: {
		setLocale(lang){
			Cookies.set('locale', lang)
			window.location.reload()
		},
	}
}
</script>
