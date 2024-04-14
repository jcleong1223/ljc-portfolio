<template>
	<div class="d-flex flex-column fill-height">
		<div>
			<v-row
				class="fill-width ma-auto"
				style="height: 100vh;"
			>
				<v-col
					v-if="$vuetify.breakpoint.mdAndUp && $route.name != 'user-sales-order'"
					cols="12"
					md="2"
					lg="2"
					style="background: rgb(22,24,32);background: linear-gradient(180deg, rgba(22,44,52,1) 0%, rgba(36,54,64,1) 100%);box-shadow: 4px 2px 20px 0px rgba(32,86,144,0.75); opacity: 0.9; padding-top: 50px ;"
					class="fill-height"
				>
					<Sidebar></Sidebar>
				</v-col>
				<v-col
					cols="12"
					md="10"
					lg="10"
					:class="$vuetify.breakpoint.smAndDown ? 'px-0' : 'mx-auto'"
					style="overflow-y: scroll"
				>
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
				</v-col>
			</v-row>
		</div>
		<!-- <v-container fluid>
			<transition name="slide-fade">
				<keep-alive>
					<router-view v-if="$route.meta.keepAlive"></router-view>
				</keep-alive>
			</transition>
			<transition name="slide-fade">
				<router-view v-if="!$route.meta.keepAlive"></router-view>
			</transition>
		</v-container> -->
	</div>
</template>

<script>
import Sidebar from '@src/components/Sidebar.vue'
//import Footer from "@src/components/Footer.vue";
export default {
	components: {
		Sidebar,
		//Footer
	},
	data(){
		return {
		}
	},
	created(){

	},
	methods:{

	}
}
</script>