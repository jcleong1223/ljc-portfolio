<template>
	<v-sheet color="transparent" class="fill-height">
		<section>
			<v-sheet color="transparent">
				<div>
					<v-img
						src="/images/asset/career1.png"
						eager
						:aspect-ratio="$vuetify.breakpoint.mdAndUp ? 8/3 : 1"
					>
						<v-overlay absolute>
							<span :class="$vuetify.breakpoint.mdAndUp ? 'ma-auto pa-auto text-center font-barlow font-size-header' : 'ma-auto pa-auto text-center text-xs-h6 text-h3 font-barlow'"><b>Careers</b></span>
						</v-overlay>
					</v-img>
				</div>
			</v-sheet>
		</section>


		<section>
			<v-container>
				<div :class="$vuetify.breakpoint.smAndDown ? 'text-h5 font-barlow text-center my-10' : 'my-13 text-md-h5 font-weight-bold text-center font-barlow'"><h3>Join The Team</h3></div>
				<v-img
					src="/images/asset/career2.png" eager
					:aspect-ratio="$vuetify.breakpoint.mdAndUp ? 8/3 : 1"
				></v-img>
				<div :class="$vuetify.breakpoint.smAndDown ? 'text-justify mx-auto mt-15' : 'text-center text-md-justify mx-auto mt-15'" :style="$vuetify.breakpoint.smAndDown ? 'width: 85%; line-height: 28px;' : 'width: 100%; line-height: 33px;'">
					<div><p>Join the KPLOO team and be part of a dynamic, innovative and industry-leading metal fabrication company. We are seeking talented individuals who are passionate about sheet metal fabrication and eager to make a difference in the industry. Our team is comprised of experts with diverse skill sets, who work collaboratively to provide the best possible solutions to our clients. We offer exciting career opportunities in various areas, including design, engineering, manufacturing, project management, and more. At KPLOO, we value our employees and provide a supportive, inclusive, and stimulating work environment that encourages creativity and professional growth. If you are looking to take your career to the next level, we invite you to explore the opportunities available at KPLOO. Join our team and become part of the success story!</p></div>
				</div>
			</v-container>
		</section>


		<section>
			<v-container :class="$vuetify.breakpoint.smAndDown ? 'px-5' : ' '">
				<v-card
					v-for="(career, i) in careers" :key="i"
					class="elevation-3 my-15 hover_effect"
				>
					<v-row :class="$vuetify.breakpoint.smAndDown ? 'd-block' : 'mx-8'">
						<v-col :class="$vuetify.breakpoint.smAndDown ? 'pt-1 pb-0' : ''">
							<div :class="$vuetify.breakpoint.smAndDown ? 'text-left ml-8' : 'text-center text-md-justify mx-auto my-1'">
								<div :class="$vuetify.breakpoint.smAndDown ? 'font-weight-bold my-6 font-barlow font-size-subtitle' : 'font-weight-bold my-6 font-barlow text-h5'">{{ career.careerTitle }}</div>
								<div class="my-6 font-weight-bold"><h4><v-icon color="#000000" class="mb-1 mr-3">mdi-map-marker</v-icon>{{ career.careerLocation }}</h4></div>
								<div class="font-weight-bold my-6"><h4><v-icon color="#000000" class="mb-1 mr-3">mdi-cash-usd</v-icon>{{ career.salary }}</h4></div>
							</div>
						</v-col>
						<v-col :class="$vuetify.breakpoint.smAndDown ? 'pt-0 pb-10' : ''">
							<div class="text-md-justify mx-auto">
								<div :class="$vuetify.breakpoint.smAndDown ? 'mb-8 mt-1' : 'my-6'">
									<h4 :class="$vuetify.breakpoint.smAndDown ? 'text-left ml-8 ' : 'text-right'" style="color: #DAA520; font-weight: 500">
										<v-icon color="#DAA520" class="mb-1">mdi-clock</v-icon> {{ career.careerType }}
									</h4>
								</div>
								<!-- <div class="font-weight-bold mt-16 pt-3 text-right"><h4>View More</h4></div> -->
								<div :class="$vuetify.breakpoint.smAndDown ? 'text-left ml-8 viewmore_effect' : 'font-weight-bold mt-16 pt-3 text-right viewmore_effect'">
									<v-row align="center" :class="$vuetify.breakpoint.smAndDown ? 'pl-4 justify-start': 'justify-end mr-3'">
										<span
											class="text-decoration-underline mr-3"
											style="cursor: pointer;" 
											@click="directToCareerDetail(career)"
										><h3>View More</h3>
										</span>
										<img 
											src="/images/arrow-black.png" 
											aspect-ratio="16/9" 
											width="30px" 
											height="18px"
										>
									</v-row>
								</div>
							</div>
						</v-col>
					</v-row>
				</v-card>
			</v-container>
		</section>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";

import BaseClient from '../client';

export default {
	components: {

	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
			careers: [
				// {
				// 	careerTitle: 'Mechanical Engineer',
				// 	careerLocation: 'Petaling Jaya',
				// 	salary: "MYR 5000 - MYR 8000",
				// 	careerType: 'Full time'
				// },
				// {
				// 	careerTitle: 'Clerk',
				// 	careerLocation: 'Ampang',
				// 	salary: "MYR 4000 - MYR 5000",
				// 	careerType: 'Part time'
				// },
				// {
				// 	careerTitle: 'Electrical Engineer',
				// 	careerLocation: 'Cheras',
				// 	salary: "MYR 3000",
				// 	careerType: 'Internship'
				// },
				// {
				// 	careerTitle: 'Accountant',
				// 	careerLocation: 'Johor Bahru',
				// 	salary: "MYR 2000",
				// 	careerType: 'Full time'
				// },
			],
		}
	},
	created(){

	},
	mounted(){
		this.getCareerListing();
	},
	methods: {
		getCareerListing()
		{
			BaseClient.getCareersPage().then(res =>{
				console.log(res.data);
				const { data } = res.data;
				this.careers = data.careers.map(data => {
					return{
						id: data.id,
						careerTitle: data.title,
						careerLocation : data.location,
						salary: data.salary_range,
						careerType: data.type
					}
				});

			}).catch(err =>{
				console.log(err);
			})
		},
		directToCareerDetail(career){
			this.$router.push({ 
				name: "career-detail", 
				params: { id: career.id }
			})
		}
	},
};
</script>

<style scoped>
.hover_effect:hover{
	transform: scale(102%);
	transition: 0.5s;
}

.viewmore_effect:hover
{
	transform: translateX(2%);
	transition: 0.5s;
}

</style>