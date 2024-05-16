<template>
	<v-app class="font-family-primary">
		<v-main v-if="auth_ready" style="background-color: #EADBC8;">
			<transition name="fade">
				<router-view></router-view>
			</transition>
		</v-main>
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
import debounce from 'lodash/debounce'
import { useScreenSizeStore } from '@src/stores/screenSize'
import { mapStores } from 'pinia'
export default {
	data(){
		return {
			auth_ready : false,
		}
	},
	computed:{
		...mapStores(useScreenSizeStore)
	},
	mounted() {
		this.setupScreenHeightListener()

		this.setTheme();

		this.$auth.load().then(() =>{
			this.auth_ready = true
		});
	},
	methods:{
		setupScreenHeightListener(){
			this.updateViewHeight()

			const debouncedSetHeight = debounce(this.updateViewHeight, 50)

			window.addEventListener('resize', debouncedSetHeight)

			window.onorientationchange = event => {
				this.updateViewHeight()
			};

			this.$once('destroyed', () => {
				window.removeEventListener('resize', debouncedSetHeight)
			})
		},
		updateViewHeight(){
			this.screenSizeStore.syncViewHeight()
		},
		setTheme(){
			let isDarkTheme = JSON.parse(localStorage.getItem("dark-theme"))
			this.$vuetify.theme.dark = isDarkTheme || false;
		}
	}
}
</script>

<style scoped>
.theme--dark.v-application {
	background: #303030;
}
.theme--light.v-application {
	background: #F5F5F5;
}
</style>