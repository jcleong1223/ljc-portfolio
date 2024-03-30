<template>
	<v-app class="font-family-primary">
		<template v-if="auth_ready">
			<div v-if="$config.debugMode && showBreakpointInfo" class="position-fixed" style="bottom: 0; left:0; z-index: 999;">
				<div class="px-2 info--text background">
					<span>breakpoint: {{ $vuetify.breakpoint.name }}</span>
					<v-icon small @click="showBreakpointInfo = false">mdi-close</v-icon>
				</div>
			</div>
			<transition name="fade">
				<router-view></router-view>
			</transition>
		</template>
		<v-main v-if="!auth_ready">
			<v-container class="fill-height justify-center">
				<div class="text-center">
					<div>
						<v-progress-circular
							:size="80"
							:width="8"
							color="primary"
							indeterminate
						></v-progress-circular>
					</div>
					<div class="pt-6">
						<div class="font-weight-bold primary--text text-h6">Loading ...</div>
					</div>
				</div>
			</v-container>
		</v-main>
	</v-app>
</template>

<script>
export default {
	data(){
		return {
			auth_ready : false,
			showBreakpointInfo: true,
		}
	},
	mounted() {
		this.setTheme();

		this.setDocLocale();

		this.$auth.load().then(() =>{
			this.auth_ready = true
		});
	},
	created(){
		setTimeout(() => this.goToAnchor(), 1000) // on SPA loaded
	},
	methods:{
		setTheme(){
			let theme = localStorage.getItem("dark-theme")
			if(theme){
				let isDarkTheme = JSON.parse(theme)
				this.$vuetify.theme.dark = isDarkTheme;
			}
		},
		setDocLocale(){
			let getHTMLTag = document.documentElement;
			getHTMLTag.setAttribute("lang", this.$i18n.locale);
		},
		goToAnchor(){
			let hash = this.$route.hash
			if(hash){
				hash = hash.replace("#", "")
				let anchorEl = document.getElementById(hash)
				anchorEl && this.$vuetify.goTo(anchorEl)
			}
		},
	}
}
</script>
