<template>
	<div class="font-primary">
		<!-- top bar -->
		<v-app-bar
			v-bind="$attrs"
			:class="barClasses"
			v-on="$listeners"
		>
			<template v-if="$vuetify.breakpoint.mdAndUp">
				<v-row no-gutters align="center">
					<v-col cols="auto">
						<router-link
							:to="{name:'home-page', hash: '#' }"
							class="text-decoration-none"
							exact
							@click.native="goToAnchor()"
						>
							<div>{{ $config.name }}</div>
						</router-link>
					</v-col>
					<v-col>
						<v-row no-gutters justify="center">
							<template v-for="(nav_link,i) in nav_links">
								<v-btn
									:key="i"
									text small
									color="primary"
									class="font-weight-bold"
									exact
									:to="nav_link.to"
									@click.native="goToAnchor()"
								>
									{{ $t(nav_link.title) }}
								</v-btn>
							</template>
						</v-row>
					</v-col>
					<v-col cols="auto">
						<v-row dense>
							<v-col cols="auto">
								<v-icon
									size="16"
									@click="toggleDarkMode()"
								>
									{{ $vuetify.theme.dark ? "mdi-moon-waxing-crescent" : "mdi-white-balance-sunny" }}
								</v-icon>
							</v-col>
							<v-col cols="auto">
								<locale-switcher></locale-switcher>
							</v-col>
						</v-row>
					</v-col>
				</v-row>
			</template>

			<template v-else>
				<v-app-bar-title>
					<v-row dense class="ma-0 pt-2" align="center">
						<v-col cols="auto">
							<router-link
								:to="{ name:'home-page', hash: '#' }"
								class="text-decoration-none"
								exact=""
								@click.native="goToAnchor()"
							>
								{{ $config.name }}
							</router-link>
						</v-col>
					</v-row>
				</v-app-bar-title>
				<v-spacer></v-spacer>
				<v-app-bar-title>
					<v-app-bar-nav-icon color="primary" @click="isOpen=!isOpen"></v-app-bar-nav-icon>
				</v-app-bar-title>
			</template>
		</v-app-bar>

		<!-- side bar -->
		<v-navigation-drawer
			ref="sidebar"
			v-model="isOpen"
			app
			temporary
			floating
			right
			class="elevation-1 secondary"
		>
			<v-list class="py-0" dense>
				<template v-for="(nav_link,i) in nav_links">
					<v-list-item
						:key="i"
						:to="nav_link.to"
						exact
						@click.native="goToAnchor()"
					>
						<v-list-item-content class="text-body-2">
							<div class="primary--text font-weight-bold">{{ $t(nav_link.title) }}</div>
						</v-list-item-content>
					</v-list-item>
				</template>
			</v-list>
			<template #prepend>
				<v-row dense class="pt-4 pr-4 pb-1" justify="end">
					<v-col cols="auto">
						<v-icon
							size="16"
							@click="toggleDarkMode()"
						>
							{{ $vuetify.theme.dark ? "mdi-moon-waxing-crescent" : "mdi-white-balance-sunny" }}
						</v-icon>
					</v-col>
					<v-col cols="auto">
						<locale-switcher></locale-switcher>
					</v-col>
				</v-row>
			</template>
		</v-navigation-drawer>
	</div>
</template>

<script>
import LocaleSwitcher from './LocaleSwitcher.vue'
export default {
	components: {
		LocaleSwitcher,
	},
	props: {
		barClasses: {
			type: String,
			default: ""
		}
	},
	data(){
		return {
			nav_links : [],
			isOpen: false,
		}
	},
	created(){
		this.nav_links = [
			{ title : "nav.home", to : { name: "home-page", "hash": "#" } },
			{ title : "nav.about-us", to : { name: "home-page", "hash": "#about-us" } },
			{ title : "nav.contact-us", to : { name: "contact-us" } },
		];
	},
	methods: {
		toggleDarkMode() {
			this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
			localStorage.setItem("dark-theme", this.$vuetify.theme.dark);
		},
		goToAnchor(){
			let hash = this.$route.hash
			if(hash){
				hash = hash.replace("#", "")
				let anchorEl = document.getElementById(hash)
				this.$vuetify.goTo(anchorEl ?? 0)
			}
		},
		logout(){
			this.$auth.logout({
				makeRequest: true,
				data: {},
				redirect: {
					name: "login"
				},
			});
		},
	}
}
</script>

<style scoped>
.v-btn--active::before{
	opacity: 0;
}
.border-bottom-primary{
	border-bottom: 4px solid #DE002B !important;
}
</style>