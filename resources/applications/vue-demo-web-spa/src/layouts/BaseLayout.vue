<template>
	<div class="d-flex flex-column fill-height">
		<Topbar
			app
			flat
			color="secondary"
		></Topbar>
		<v-main>
			<v-sheet class="fill-height">
				<transition name="slide-fade">
					<router-view></router-view>
				</transition>
			</v-sheet>
		</v-main>
		<Footer></Footer>
	</div>
</template>

<script>
import Topbar from '@src/components/Topbar.vue'
import Footer from "@src/components/Footer.vue";
export default {
	components: {
		Topbar,
		Footer,
	},
	data(){
		return {
		}
	},
	created(){
	},
	methods:{}
}
</script>