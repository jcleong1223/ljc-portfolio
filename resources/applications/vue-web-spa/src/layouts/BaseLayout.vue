<template>
	<div class="d-flex flex-column fill-height" style="overflow-x: hidden; overflow-y: hidden;">
		<!-- <Topbar
			app
			flat
			:color="currentRouteName == 'home-page' && $vuetify.breakpoint.mdAndUp ? scrollPosition > 400 ? '#FFFFFF' : 'transparent' : 'white'"
		></Topbar> -->
		<v-main style="padding:0px;">
			<v-sheet class="fill-height">
				<transition name="slide-fade">
					<router-view></router-view>
				</transition>
			</v-sheet>
		</v-main>
		<!-- <Footer></Footer> -->
	</div>
</template>

<script>
// import Topbar from '@src/components/Topbar.vue'
// import Footer from "@src/components/Footer.vue";
export default {
	components: {
		// Topbar,
		// Footer,
	},
	data(){
		return {
			scrollPosition: null,
		}
	},
	computed: {
		currentRouteName() {
			return this.$route.name;
		}
	},
	created(){
	},
	mounted(){
		window.addEventListener('scroll', this.updateScroll);
	},
	methods:{
		updateScroll() {
			this.scrollPosition = window.scrollY
		},
	}
}
</script>