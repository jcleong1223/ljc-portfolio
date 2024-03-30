<template>
	<v-container>
		<v-card flat color="transparent">
			<div v-if="$auth.user()" class="text-h6">Welcome back, {{ $auth.user().name }}</div>
		</v-card>
		<v-row class="mt-3">
			<template v-if="dataList && Object.keys(dataList).length > 0">
				<v-col cols="12" sm="6" md="4">
					<router-link :to="{ name: 'admin.list'}" class="text-decoration-none">
						<overview-card
							title="Admins"
							:value="dataList.user_count"
							icon="mdi-account-multiple" color="#36a3f7"
						></overview-card>
					</router-link>
				</v-col>
				<!-- <v-col cols="12" sm="6" md="4">
					<router-link :to="{ name: 'game.list'}" class="text-decoration-none">
						<overview-card
							title="Game" :value="dataList.game_count"
							icon="mdi-gamepad-variant-outline" color="#40c9c6"
						></overview-card>
					</router-link>
				</v-col> -->
				<!-- <v-col cols="12" sm="6" md="4">
					<overview-card
						title="Active Course" :value="dataList.active_course_count"
						icon="mdi-book-open-page-variant" color="#f4516c"
					></overview-card>
				</v-col> -->
			</template>
			<template v-else>
				<v-col
					v-for="i in 2" :key="i"
					cols="12" sm="6" md="4"
				>
					<v-skeleton-loader
						type="list-item-avatar-three-line"
						class="mx-auto"
					></v-skeleton-loader>
				</v-col>
			</template>
		</v-row>
	</v-container>
</template>

<script>
import OverviewCard from '@src/components/OverviewCard.vue'
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin"
import DashboardApi from "../client"
export default{
	components: {
		OverviewCard,
	},
	mixins: [
		errorHandlerMixin,
	],
	data(){
		return {
			dataList: null
		}
	},
	created(){
		this.getDashboardData()
	},
	methods:{
		getDashboardData(){
			DashboardApi.getDashboard().then((res)=>{
				this.dataList = res.data.data
			}).catch((err) => {
				this.errorHandler_(err)
			})
		}
	}
}
</script>