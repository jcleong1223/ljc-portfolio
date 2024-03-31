<template>
	<v-sheet color="transparent" class="fill-height">
		<section>
			<v-sheet color="transparent">
				<div>
					<v-img
						src="/images/capabilities/Rectangle 1.png"
						eager
						:aspect-ratio="$vuetify.breakpoint.mdAndUp ? 8/3 : 1"
					>
						<v-overlay
							class="text-center"
							absolute
						>
							<span :class="$vuetify.breakpoint.smAndDown ? 'ma-auto pa-auto text-h4 font-barlow' : 'ma-auto pa-auto font-size-header font-barlow'"><b>Capabilities</b></span>
						</v-overlay>
					</v-img>
				</div>
			</v-sheet>
		</section>
		<section>
			<v-sheet color="black">
				<v-row class="ma-0">
					<v-col cols="12" md="6" :class="$vuetify.breakpoint.smAndDown ? '' : 'ma-auto'">
						<v-col
							cols="12" md="8" xs="12"
							:class="$vuetify.breakpoint.smAndDown ? 'my-10 mx-auto white--text ' : 'ma-auto white--text'"
							data-aos="fade-right" data-aos-duration="2000"
						>
							<!-- replace text below with provided text-->
							<span :class="$vuetify.breakpoint.smAndDown ? 'font-size-subtitle text-left font-barlow' : 'font-size-title font-barlow'"><b>Value Added Services</b></span>
							<ul class="text-justify font-size-text mt-5 ">
								<li class="font-family-inter">To better satisfy the diverse needs of all kinds of industries, we supply various services to provide a one-stop solution to all your metal fabrication needs.</li>
							</ul>
						</v-col>
					</v-col>
					<v-col cols="12" md="6" class="pa-0 ma-0">
						<v-img
							src="/images/capabilities/Rectangle 290.png"
							eager
							:aspect-ratio="1.22"
						>
						</v-img>
					</v-col>
				</v-row>
			</v-sheet>
		</section>
		<section>
			<v-sheet color="transparent">
				<v-col
					md="10"
					cols="12"
					class="mx-auto mt-md-10"
				>
					<v-row
						class="justify-md-start justify-center"
					>
						<v-col
							v-for="(capability,i) in capabilities"
							:key="i"
							class="my-md-8 my-4"
							cols="12"
							md="4"
						>
							<v-card
								:class="$vuetify.breakpoint.smAndDown ? 'mx-2 d-flex flex-column' :'mx-4 d-flex flex-column'"
								height="100%"
								eager
								rounded="0"
								elevation="0"
								color="black"
								data-aos="zoom-in"
								data-aos-duration="1500"
							>
								<v-img
									max-height="200"
									:src="capability.image.file_url"
									:aspect-ratio="1.22"
									eager
									cover
								></v-img>
								<v-card-title
									class="white--text font-barlow pl-7 font-size-subtitle"
								>
									{{ capability.title }}
								</v-card-title>
								<v-divider color="white" class="my-0" style="width:90%"></v-divider>
								<v-card-text
									color="white"
									class="white--text pl-7 mb-auto text-justify font-family-inter font-size-text"
								>
									{{ capability.short_description }}
								</v-card-text>
								<v-card-actions class="pl-13 my-4">
									<v-row align="center">
										<router-link
											class="text-decoration-none text-color-unset pb-5 learnMore_effect"
											:to="{ name: 'capability.info', params: { id: capability.id } }"
											plain
										>
											<v-row align="center">
												<span class="text-gold font-family-inter text-decoration-underline font-size-subtitle mr-3">Learn More</span>
												<img 
													src="/images/arrow.png" 
													aspect-ratio="16/9" 
													width="35px" 
													height="20px"
												>
											</v-row>
										</router-link>
									</v-row>
								</v-card-actions>
							</v-card>
						</v-col>
					</v-row>
				</v-col>
			</v-sheet>
		</section>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
import BaseClient from '../client';
import AOS from 'aos';
import 'aos/dist/aos.css';

export default {
	components: {
	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
			capabilities: [],
		}
	},
	created(){
		this.fetchPageData();
		AOS.init();
	},
	methods: {
		fetchPageData(){
			BaseClient.getCapabilitiesPage().then((res) => {
				const result = res.data.data
				this.capabilities = result.capabilities;
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},
	},
};
</script>

<style>

.learnMore_effect:hover
{
	-webkit-transform: translateX(10%);
	transition: 0.5s;
}

</style>
