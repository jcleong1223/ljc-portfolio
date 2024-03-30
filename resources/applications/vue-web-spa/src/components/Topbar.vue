<template>
	<div class="font-primary">
		<!-- top bar -->
		<v-app-bar
			v-bind="$attrs"
			:class="barClasses"
			:style="currentRouteName != 'home-page' || scrollPosition > 150 ? 'filter: drop-shadow(0px 0px 10px rgb(0,0,0,0.22)); z-index:10' : 'z-index:10'"
			:color="currentRouteName != 'home-page' || scrollPosition > 150 ? '#D6EDF7' : '#EDF2F7'"
			v-on="$listeners"
		>
			<template v-if="$vuetify.breakpoint.mdAndUp">
				<v-row no-gutters align="center">
					<v-col cols="4">
						<router-link
							:to="{name:'home-page', hash: '#' }"
							class="text-decoration-none"
							exact
							@click.native="goToAnchor()"
						>
							<!-- <div>{{ $config.name }}</div> -->
							<v-row no-gutters>
								<v-col cols="3" align-self="center" class="ml-15">
									<v-img
										class="mx-auto" width="100%" src="/images/ljc.png"
									></v-img>
								</v-col>
								<!-- <v-col cols="9" align-self="center">
									<div class="black--text font-weight-bold text-h6">{{ $config.name }}</div>
								</v-col> -->
							</v-row>
						</router-link>
					</v-col>
					<v-col>
						<v-row no-gutters justify="start">
							<template v-for="(nav_link,i) in nav_links">
								<v-btn
									:key="i"
									text large
									:color="currentRouteName != 'home-page' || scrollPosition > 400 ? '#014D69' : '#014D69'"
									class="font-weight-bold text-h6 font-family-inter justify-space-around mr-16 "
									exact
									:to="nav_link.to"
									exact-active-class="btnActive"
									@click.native="goToAnchor()"
								>
									{{ $t(nav_link.title) }}
								</v-btn>
							</template>
						</v-row>
					</v-col>

					<v-col cols="auto">
						<v-row dense>
							<v-col cols="auto" class="mr-10">
								<v-btn
									size="x-large" append-icon="$vuetify" color="#0B87BA"
									class="white--text text-h6 font-family-inter pa-3" height="45px"
								>
									Contact Me
									<v-icon
										size="20"
										class="pl-3"
									>
										mdi-arrow-right-circle-outline
									</v-icon>
								</v-btn>
							</v-col>
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
					<v-row dense class="ma-0" align="center">
						<v-col cols="auto">
							<v-img
								width="30%" src="/images/ljc.png"
							></v-img>
						</v-col>
					</v-row>
				</v-app-bar-title>
				<v-spacer></v-spacer>
				<v-app-bar-title>
					<v-app-bar-nav-icon color="#DAA520" @click="isOpen=!isOpen"></v-app-bar-nav-icon>
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
			class="elevation-1"
			color="#181818"
		>
			<v-list class="py-0 pl-4" dense>
				<template v-for="(nav_link,i) in nav_links">
					<v-list-item
						:key="i"
						:to="nav_link.to"
						exact
						active-class="sidebarbtnActive"
						@click.native="goToAnchor()"
					>
						<v-list-item-content class="text-body-2 white--text font-family-inter">
							<div class="font-family-inter">{{ $t(nav_link.title) }}</div>
						</v-list-item-content>
					</v-list-item>
				</template>

				<v-divider color="white" width="88%" class="mt-4 mb-6"></v-divider>

				<v-row class="pl-4">
					<template v-for="(secondary_nav_link,j) in secondary_nav_links">
						<v-col :key="j" cols="6">
							<v-list-item
								:key="j"
								:to="secondary_nav_link.to"
								exact
								active-class="sidebarbtnActive"
								class="px-0"
								@click.native="goToAnchor()"
							>
								<v-list-item-content class="text-body-2 white--text px-0">
									<div class=""><h5 class="font-family-inter" style="font-weight: 400">{{ $t(secondary_nav_link.title) }}</h5></div>
								</v-list-item-content>
							</v-list-item>
						</v-col>
					</template>
				</v-row>

				<v-divider color="white" width="88%" class="my-6"></v-divider>

				<section>
					<div class=" ml-4 text-body-2 white--text font-family-inter">Contact Info</div>
					<v-list-item
						v-for="(contact_info,k) in contact_information"
						:key="k"
						class="mt-3"
					>
						<v-list-item-content class="text-body-2 my-1 white--text font-family-inter">
							<div class="d-flex">
								<v-icon color="white" size="18">{{ contact_info.icon }}</v-icon>
								<div class="align-self-center"><h5 class="font-family-inter ml-3" style="font-weight: 400; word-spacing: 2px; line-height: 1.5">{{ $t(contact_info.text) }}</h5></div>
							</div>
						</v-list-item-content>
					</v-list-item>
				</section>
			</v-list>

			<template #prepend>
				<v-row dense class="pt-4 pr-4 pb-1 black_background" justify="end">
					<v-col cols="auto">
						<v-icon
							size="30" color="white" @click="isOpen = !isOpen"
						>
							mdi-close
						</v-icon>
					</v-col>
					<!-- <v-col cols="auto">
						<v-icon
							size="16"
							@click="toggleDarkMode()"
						>
							{{ $vuetify.theme.dark ? "mdi-moon-waxing-crescent" : "mdi-white-balance-sunny" }}
						</v-icon>
					</v-col>
					<v-col cols="auto">
						<locale-switcher></locale-switcher>
					</v-col> -->
				</v-row>
			</template>
		</v-navigation-drawer>
	</div>
</template>

<script>
// import LocaleSwitcher from './LocaleSwitcher.vue'
export default {
	components: {
		//LocaleSwitcher,
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
			secondary_nav_links: [],
			contact_information: [],
			isOpen: false,
			scrollPosition: null,
		}
	},
	computed: {
		currentRouteName() {
			return this.$route.name;
		}
	},
	created(){
		this.nav_links = [
			{ title : "nav.home", to : { name: "home-page" } },
			{ title : "nav.about-me", to : { name: "about-me" } },
			{ title : "nav.projects", to : { name: "projects" } },
			// { title : "nav.contact-me", to : { name: "contact-me" } },
		];

		// this.secondary_nav_links = [
		// 	{ title : "nav.privacyPolicy", to: { name: "privacy-policy-page" }},
		// 	{ title : "nav.term&Condition", to: { name: "term-condition-page" }},
		// ];

	},
	mounted(){
		window.addEventListener('scroll', this.updateScroll);
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
		updateScroll() {
			this.scrollPosition = window.scrollY
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
.btnActive , .topBarBtn >>> .v-btn__content:hover {
	color: #014D69!important;
}

.sidebarbtnActive
{
	color: #014D69;
	font-weight: bold;
}

.black_background
{
	background-color: #181818;
}

</style>
