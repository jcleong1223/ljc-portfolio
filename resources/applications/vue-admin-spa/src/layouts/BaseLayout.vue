<template>
	<div>
		<Navbar></Navbar>
		<v-container fluid>
			<transition name="slide-fade">
				<keep-alive>
					<router-view v-if="$route.meta.keepAlive"></router-view>
				</keep-alive>
			</transition>
			<transition name="slide-fade">
				<router-view v-if="!$route.meta.keepAlive"></router-view>
			</transition>
		</v-container>
	</div>
</template>

<script>
import Navbar from '@src/components/Navbar.vue'
export default {
	components: { Navbar },
	data(){
		return {
		}
	},
	methods:{}
}
</script>