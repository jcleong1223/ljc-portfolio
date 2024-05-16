<template>
	<div>
		<!-- App bar -->
		<v-app-bar
			app
			height="60"
			flat
			color="#B99470"
			class="elevation-1"
		>
			<template v-if="!isOpen">
				<v-app-bar-nav-icon @click="isOpen=!isOpen"></v-app-bar-nav-icon>
				<v-toolbar-title>
					<v-row>
						<v-col>
							<span class="font-weight-bold" style="letter-spacing: 2px; font-size: large;">{{ $config.name }}</span>
						</v-col>
					</v-row>
				</v-toolbar-title>
			</template>
			<v-spacer></v-spacer>
			<div v-if="$auth.user()">
				<v-menu
					v-model="menu"
					left bottom nudge-bottom="25"
					max-width="300px" min-width="250px"
					:close-on-content-click="false"
				>
					<template #activator="{ on, attrs }">
						<div v-bind="attrs" class="no-highlight" v-on="on">
							<v-row dense>
								<v-col cols="auto">
									<v-avatar color="primary" size="30" class="text-capitalize accent-3 white--text">
										<span v-if="$auth.user().name" class="text-body-1">{{ $auth.user().name[0] }}</span>
									</v-avatar>
									<!-- <v-img
										v-if="$auth.user().avatar"
										width="30px"
										height="30px"
										class="radius-rounded"
										:src="$auth.user().avatar.file_url"
									></v-img> -->
								</v-col>
								<v-col>
									<v-icon size="20">mdi-chevron-down</v-icon>
								</v-col>
							</v-row>
						</div>
					</template>
					<v-list class="pt-0" dense>
						<v-list-item>
							<v-row
								dense class="py-4"
								justify="start" align="center"
							>
								<v-col cols="auto">
									<!-- <v-avatar color="primary" size="45" class="text-capitalize accent-3 mx-1 title white--text">
										<span v-if="$auth.user().name" style="font-size: 23px">{{ $auth.user().name[0] }}</span>
									</v-avatar> -->
									<!-- <v-img
										v-if="$auth.user().avatar"
										width="45px"
										height="45px"
										class="radius-rounded"
										:src="$auth.user().avatar.file_url"
									></v-img> -->
								</v-col>
								<v-col cols="8" class="text-left">
									<div class="text-body-2 no-word-wrap">{{ $auth.user().name }}</div>
									<div>
										<div class="grey--text caption">{{ $auth.user().email || 'N/A' }}</div>
									</div>
								</v-col>
							</v-row>
						</v-list-item>
						<v-divider></v-divider>
						<v-subheader>Options</v-subheader>
						<v-list-item @click="toggleDarkMode()">
							<v-list-item-icon class="mr-2">
								<v-icon size="16" class="">{{ $vuetify.theme.dark ? "mdi-moon-waxing-crescent" : "mdi-white-balance-sunny" }}</v-icon>
							</v-list-item-icon>
							<v-list-item-content class="text-body-2">
								Appearance: {{ $vuetify.theme.dark ? 'Dark' : 'Light' }}
							</v-list-item-content>
						</v-list-item>
						<v-list-item @click="toUseProfile()">
							<v-list-item-icon class="mr-2">
								<v-icon size="16">mdi-card-account-details</v-icon>
							</v-list-item-icon>
							<v-list-item-content class="text-body-2">Manage Your Account</v-list-item-content>
						</v-list-item>
						<v-list-item @click="logout()">
							<v-list-item-icon class="mr-2">
								<v-icon size="16" class="error--text">mdi-logout</v-icon>
							</v-list-item-icon>
							<v-list-item-content class="error--text text-body-2">Log Out</v-list-item-content>
						</v-list-item>
					</v-list>
				</v-menu>
			</div>
		</v-app-bar>

		<!-- Side bar -->
		<v-navigation-drawer
			ref="sidebar"
			v-model="isOpen"
			app
			temporary
			floating
			class="elevation-1 secondary"
		>
			<template #prepend>
				<v-row class="ma-0" align="center">
					<v-col cols="auto">
						<v-app-bar-nav-icon @click="isOpen=!isOpen"></v-app-bar-nav-icon>
					</v-col>
					<v-col cols="auto" class="text-center">
						<!-- <span class="font-weight-bold" style="letter-spacing: 2px; font-size: large;">{{ $config.name }}</span> -->
					</v-col>
					<v-spacer></v-spacer>
				</v-row>
				<v-divider></v-divider>
			</template>
			<template v-for="(group,i) in route_groups">
				<v-list
					v-if="group.routes.length > 0"
					:key="i"
					dense flat
					class="py-0"
				>
					<v-subheader v-if="group.title!=null">
						{{ group.title }}
					</v-subheader>
					<template v-for="item in group.routes">
						<template v-if="item.sub">
							<v-list-group
								:key="item.title"
								:group="item.namespace"
								:prepend-icon="item.icon"
								append-icon="mdi-menu-down"
								color="primary"
								no-action
							>
								<template #activator>
									<v-list-item-content>
										<v-list-item-title>{{ item.title }}</v-list-item-title>
									</v-list-item-content>
								</template>
								<v-list-item v-for="child in item.sub" :key="child.title" :to="child.to">
									<v-list-item-title>{{ child.title }}</v-list-item-title>
								</v-list-item>
							</v-list-group>
						</template>

						<v-list-item
							v-else
							:key="item.title"
							:to="item.to"
							active-class="primary--text"
						>
							<v-list-item-icon><v-icon>{{ item.icon }}</v-icon></v-list-item-icon>
							<v-list-item-title>{{ item.title }}</v-list-item-title>
						</v-list-item>
					</template>
				</v-list>
			</template>
			<template #append>
				<div
					class="pa-4 text-caption text-center relative"
					style="width: 100%; font-size: 0.6rem !important;"
				>
					<a :href="poweredBy.href" target="_BLANK" class="text-decoration-none opposite--text"><strong>{{ poweredBy.text }}</strong></a>
					<div class="position-absolute grey--text px-1" style="right: 0; font-size: 9px;">{{ app_version }}</div>
				</div>
			</template>
		</v-navigation-drawer>
	</div>
</template>

<script>
import { getNavbarList } from "@src/config/navbar";
export default {
	data () {
		return {
			title : this.$config.name,
			app_version : this.$config.version,
			isOpen: false,
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
			text: "© 2024 LJC. All rights reserved.",
			href: "https://www.etctech.com.my/",
		}
	},
	methods: {
		getNavRoute(){
			this.route_groups = getNavbarList(this.$auth.user())
		},
		toggleDarkMode() {
			this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
			localStorage.setItem("dark-theme", this.$vuetify.theme.dark);
		},
		toUseProfile(){
			this.menu = false
			this.$router.push({ name: 'my-account' });
		},
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
