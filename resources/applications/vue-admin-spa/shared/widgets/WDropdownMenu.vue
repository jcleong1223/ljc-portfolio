<!--
	ori-doc : https://www.notion.so/w-dropdown-menu-d2007fdce69740fda628a08b07a7961a
-->
<template>
	<v-menu
		v-bind="$attrs"
		v-on="$listeners"
	>
		<template #activator="{ on }">
			<!-- default slot -->
			<slot name="activator" :on="on">
				<v-btn
					v-if="items.length > 0"
					icon small
					v-on="on"
				>
					<v-icon small>mdi-dots-vertical</v-icon>
				</v-btn>
			</slot>
		</template>
		<v-list dense>
			<v-list-item
				v-for="(menu_item, i) in items"
				:key="i"
				:to="menu_item.to || null"
				@click="menu_item.action"
			>
				<v-list-item-icon class="mr-2">
					<v-icon small :class="menu_item.icon_class">{{ menu_item.icon }}</v-icon>
				</v-list-item-icon>
				<v-list-item-content>
					<v-list-item-title>
						<span :class="menu_item.title_class">{{ menu_item.title }}</span>
					</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
		</v-list>
	</v-menu>
</template>

<script>
export default{
	props:{
		items:{
			type: Array,
			default: ()=>{
				return []
			}
		}
	},
}
</script>