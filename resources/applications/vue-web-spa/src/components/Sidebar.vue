<template>
	<div>
		<div class="mx-auto pl-4">
			<v-avatar
				size="75"
			>
				<img
					src="/images/profileimg_placeholder.png"
					alt="John"
				>
			</v-avatar>
			<br>
			<br>
			<span
				class="text-h5 text-center font-family-primary" 
				style="line-height: 28px; white-space:inherit; color: #45a29e; text-shadow: 3px 1px 15px rgba(89,188,184,0.6); font-weight: 900;"
			>
				Kevin Leong
			</span>
		</div>
		<template v-for="(group,i) in route_groups">
			<v-list
				v-if="group.routes.length > 0"
				:key="i"
				dense
				flat
				class="pt-16 mt-16"
				style="background: transparent;"
			>
				<v-subheader v-if="group.title!=null">
					{{ group.title }}
				</v-subheader>
				<template v-for="item in group.routes">
					<template v-if="item.sub">
						<v-list-group
							:key="item.title"
							append-icon="mdi-menu-down"
							color="primary"
							no-action
						>
							<template #activator>
								<v-list-item-content>
									<v-list-item-title>{{ item.title }}</v-list-item-title>
								</v-list-item-content>
							</template>
							<v-list-item
								v-for="child in item.sub"
								:key="child.title"
								:to="child.to"
							>
								<v-list-item-title>{{ child.title }}</v-list-item-title>
							</v-list-item>
						</v-list-group>
					</template>
					<v-list-item
						v-else
						:key="item.title"
						:to="item.to"
						active-class="font-weight-bold"
					>
						<template #default="{ active }">
							<v-list-item-title
								:class="active ? 'text-h6 font-ibm-plex my-4 font-weight-bold' : 'text-h6 font-ibm-plex my-4'"
								style="line-height: 28px; white-space:inherit; color: #66FCD1; text-shadow: 3px 1px 15px rgba(60,228,233,0.6); font-weight: 400; text-transform: uppercase"
							>
								{{ item.title }}
							</v-list-item-title>
						</template>
					</v-list-item>
				</template>
			</v-list>
		</template>
	</div>
</template>

<script>
import { getNavbarList } from "@src/config/navbar";
export default {
	data () {
		return {
			title : this.$config.name,
			app_version : this.$config.version,
			isOpen: true,
			menu: false,
			route_groups: [],
			poweredBy: null
		}
	},
	// watch:{
	// 	$route (to, from){
	// 		console.log(to,from)
	// 	}
	// },
	created(){
		this.getNavRoute()
		this.poweredBy = {
			text: "ETC Web Design",
			href: "https://www.etctech.com.my/",
		}
	},
	methods: {
		getNavRoute(){
			this.route_groups = getNavbarList(this.$auth.user())
		},
		// toggleDarkMode() {
		// 	this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
		// 	localStorage.setItem("dark-theme", this.$vuetify.theme.dark);
		// },
		// toUseProfile(){
		// 	this.menu = false
		// 	this.$router.push({ name: 'my-account' });
		// },
		logout(){
			this.$auth.logout({
				makeRequest: true,
				data: {},
				redirect: { name: "login" },
				// etc...
			});
		},
	}
}
</script>
