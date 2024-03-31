<template>
	<v-sheet color="#EDF2F7" class="fill-height">
		<section :class="$vuetify.breakpoint.smAndDown ? 'mt-10' : 'mt-16 pt-10 mb-16 pb-10'">
			<v-sheet color="transparent">
				<v-row class="ma-0 pa-0">
					<v-col cols="12" lg="6" class="mb-0 align-self-center">
						<v-col
							cols="12"
							md="10"
							lg="8"
							:class="$vuetify.breakpoint.smAndDown ? 'my-8 px-3' : 'mx-auto'"
						>
							<span class="font-family-inter text-h4" style="color:#014D69;"><b>Hello, I'm</b></span>
							<br />
							<br />
							<span class="font-barlow text-h1" style="color:#014D69;font-weight:900;"><b>Jia Chong</b></span>
							<div :class="$vuetify.breakpoint.smAndDown ? 'text-justify my-6' : 'text-justify my-md-5 my-2'">
								<span class="text--black font-barlow text-h4" style="color:#014D69;">A Full Stack Developer</span>
							</div>
							<br />
							<router-link
								:to="{ name: 'about-us' }"
								class="text-color-unset text-decoration-none"
							>
								<v-row align="center" class="pl-3">
									<!-- <v-btn
										size="x-large" color="#0B87BA"
										class="white--text text-h6 font-family-inter pa-5 button" height="45px"
									>
										Let's Talk
										<v-icon
											size="25"
											class="pl-3"
										>
											mdi-sticker-emoji
										</v-icon>
									</v-btn> -->
									<button class="button"></button>
								</v-row>
							</router-link>
						</v-col>
					</v-col>
					<v-col cols="12" lg="6" :class="$vuetify.breakpoint.smAndDown ? 'text-center' : 'pa-0 mt-0 mb-0'">
						<v-img
							aspect-ratio="1.1"
							src="/images/banner/runner.jpg"
							eager
							width="70%"
							height="100%"
							style="border-radius: 50%;"
						>
						</v-img>
					</v-col>
				</v-row>
			</v-sheet>
		</section>
		<section class="mt-16 pa-0">
			<v-sheet color="#EDF2F7">
				<v-row class="mx-auto pa-0">
					<v-col
						cols="12" justify="center"
						align="center"
					>
						<v-card
							eager
							class=""
							rounded="5"
							style="height:550px; width:70%; border-radius: 50px;background: #EDF2F7;box-shadow: inset 11px 11px 10px #dce1e6,inset -11px -11px 10px #feffff;"
						>
							<v-card-text
								class="black--text text-center text-justify pa-8 font-family-inter font-size-text d-flex align-center"
							>
								About Myself
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>
			</v-sheet>
		</section>
		<section class="mt-16">
			<v-sheet color="#EDF2F7">
				<v-row class="mx-auto pa-0 justify-center">
					<v-card
						eager
						class=""
						rounded="5"
						style="height:550px; width:50%; border-radius: 50px;background: #EDF2F7;box-shadow:8px 8px 16px #ccd0d4,-8px -8px 16px #ffffff;"
					>
						<v-card-text
							class="black--text text-center text-justify pa-8 font-family-inter font-size-text d-flex align-center"
						>
							<v-row class="pt-2 ma-0 black--text">
								<v-col class="pb-0" cols="6">
									Your Name
								</v-col>
								<v-col class="pb-0" cols="6">
									Phone Number
								</v-col>
								<v-col class="py-1" cols="6">
									<input
										v-model="form.fullname"
										class="pa-2 input_special_inner_bow_shadow"
										solo
										placeholder="Name"
										dense
									>
								</v-col>
								<v-col class="py-1" cols="6">
									<input
										v-model="form.phone_number"
										class="pa-2 input_special_inner_bow_shadow"
										solo
										placeholder="Phone Number"
										dense
									>
								</v-col>
								<v-col class="pb-0" cols="12">Email</v-col>
								<v-col class="py-1" cols="12">
									<input
										v-model="form.email"
										solo
										class="pa-2 input_special_inner_bow_shadow"
										placeholder="you@company.com"
										dense
									>
								</v-col>
								<v-col class="pb-0" cols="12">Message</v-col>
								<v-col class="pt-1" cols="12">
									<textarea
										v-model="form"
										solo
										placeholder="Leave Jia Chong a message..."
										dense
										class="pl-2 input_special_inner_bow_shadow"
										style="height: 120px;"
									></textarea>
								</v-col>
								<div class="font-weight-bold mt-5 submitNow_effect">
									<span
										class="text-decoration-underline text-h6"
										style="cursor: pointer; color:#DAA520"
									>Send
									</span>
								</div>
							</v-row>
						</v-card-text>
					</v-card>
					<v-card
						eager
						class="ml-10"
						rounded="5"
						style="height:550px; width:30%; border-radius: 50px;background: #EDF2F7;box-shadow:8px 8px 16px #ccd0d4,-8px -8px 16px #ffffff;"
					>
						<v-img src="/images/contactus/contactme.jpg" width="500px" class="text-center"></v-img>
						<v-card-title
							class="black--text text-center text-justify font-family-inter text-h6 d-flex align-center"
						>
							Full Stack Developer
						</v-card-title>
						<v-card-text
							class="black--text text-center text-justify font-family-inter text-subtitle-1 d-flex align-center"
						>
							I am available for freelance work. Contact with me now !!<br>Email: leongjc1223@gmail.com<br>Phone: leongjc1223@gmail.com
						</v-card-text>
					</v-card>
				</v-row>
			</v-sheet>
		</section>
		<section :class="$vuetify.breakpoint.smAndDown ? 'pt-16' : 'pt-15 pl-15'">
			<v-row align="center" :class="$vuetify.breakpoint.smAndDown ? 'justify-space-between mb-2 mx-2 pl-3' : 'justify-space-between mb-15 mx-5 px-md-11 px-3'">
				<span class="font-weight-bold text-left font-barlow font-size-title">Our Clients</span>
				<div ref="clientsTargetDiv" class="d-flex justify-center"></div>
			</v-row>
			<vueper-slides
				ref="clientsSlides"
				:class="$vuetify.breakpoint.mdAndUp ? 'no-shadow mx-md-16 mx-8' : 'no-shadow'"
				:visible-slides="$vuetify.breakpoint.mdAndUp ? 4 : 2"
				slide-multiple
				:gap="3"
				:slide-ratio="1 / 4"
				:touchable="false"
			>
				<template #arrow-left>
					<v-btn
						id="prev-button"
						color="#DAA520"
						height="40"
						min-width="40"
						class="pa-0"
						elevation="0"
						tile
					>
						<v-icon
							color="white" class="prev-button"
							:style="$vuetify.breakpoint.smAndDown ? 'font-size: 35px;' : 'font-size: 40px;'"
						>
							mdi-chevron-left
						</v-icon>
					</v-btn>
				</template>
				<template #arrow-right>
					<v-btn
						id="next-button"
						color="black"
						height="40"
						min-width="40"
						class="pa-0"
						elevation="0"
						tile
					>
						<v-icon
							color="white" class="next-button"
							:style="$vuetify.breakpoint.smAndDown ? 'font-size: 35px;' : 'font-size: 40px;'"
						>
							mdi-chevron-right
						</v-icon>
					</v-btn>
				</template>
				<vueper-slide
					v-for="(client,i) in clients" :key="i" :image="client.image.file_url"
					style="background-size:contain;"
				>
					<template #content>
						<div class="vueperslide__content-wrapper">
							<div class="vueperslide__title font-size-subtitle py-3 font-weight-bold font-barlow" :style="'background-color: white; width: 100%; position: absolute; bottom:0;'">{{ client.name }}</div>
						</div>
					</template>
				</vueper-slide>

				<template #bullet="{ active }">
					<v-icon :color="active ? '#DAA520' : '#D9D9D9'" :size="$vuetify.breakpoint.smAndDown ? '35px' : '45px'" class="px-md-0 px-1">mdi-minus</v-icon>
				</template>
			</vueper-slides>
		</section>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
// import CustomCarousel from '@src/components/CustomCarousel.vue';
import BaseClient from '../client';

import { VueperSlides, VueperSlide} from 'vueperslides';
import 'vueperslides/dist/vueperslides.css'

export default {
	components: {
		// CustomCarousel,
		VueperSlide,
		VueperSlides,
	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
			banners: [],
			capabilities: [],
			clients: [],
			default_img: '/images/asset/aboutus.png',
			loading: false,
		}
	},
	created(){
		this.fetchPageData()
	},
	beforeUpdate() {
		this.$nextTick(() => {
			const capabilitiesSlide = this.$refs.capabilitiesSlide.$el;
			const capabilitiesPrevButton = capabilitiesSlide.querySelector('.vueperslides__arrow--prev');
			const capabilitiesNextButton = capabilitiesSlide.querySelector('.vueperslides__arrow--next');
			const capabilitiesTargetDiv = this.$refs.capabilitiesTargetDiv;
			const capabilitiesBulletLength = this.$refs.capabilitiesSlide.bulletIndexes.length;
			if(capabilitiesPrevButton && capabilitiesNextButton && capabilitiesBulletLength > 1) {
				capabilitiesTargetDiv.appendChild(capabilitiesPrevButton);
				capabilitiesTargetDiv.appendChild(capabilitiesNextButton);
			} else {
				if(capabilitiesBulletLength < 2) {
					while (capabilitiesTargetDiv.firstChild) {
						capabilitiesTargetDiv.removeChild(capabilitiesTargetDiv.firstChild);
					}
				}
				this.$refs.capabilitiesSlide.goToSlide(this.$refs.capabilitiesSlide.$data.slides.current)
			}

			const clientsSlide = this.$refs.clientsSlides.$el;
			const clientsPrevButton = clientsSlide.querySelector('.vueperslides__arrow--prev');
			const clientsNextButton = clientsSlide.querySelector('.vueperslides__arrow--next');
			const clientsTargetDiv = this.$refs.clientsTargetDiv;
			const clientsBulletLength = this.$refs.clientsSlides.bulletIndexes.length;

			if(clientsPrevButton && clientsNextButton && clientsBulletLength > 1) {
				clientsTargetDiv.appendChild(clientsPrevButton);
				clientsTargetDiv.appendChild(clientsNextButton);

			} else {
				if(clientsBulletLength < 2) {
					while (clientsTargetDiv.firstChild) {
						clientsTargetDiv.removeChild(clientsTargetDiv.firstChild);
					}
				}
				this.$refs.clientsSlides.goToSlide(this.$refs.clientsSlides.$data.slides.current)
			}
		});
	},
	methods: {
		fetchPageData(){
			BaseClient.getHomePage().then((res) => {
				const result = res.data.data
				this.banners = result.banners;
				this.clients = result.clients;
				this.capabilities = result.capabilities;
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},

		handleImageClick(e){
			console.log(e);
		},

		async submitForm(item){

			// const token = await this.$recaptcha('submit')
			// this.form.recaptcha = token

			this.submitContactInfo(item);
		},

		submitContactInfo(item){
			this.loading = true;
		}
	},
};
</script>

<style>
.input_special_inner_bow_shadow{
	width:100%;border-radius: 7px; 
	background: #EDF2F7;
	box-shadow: inset 5px 5px 3px #ccd0d4,inset -5px -5px 3px #ffffff;
}


.prev-button, .next-button {
	font-size: 40px !important;
}

.vueperslides__arrow--prev{
	background: #DAA520 !important;
	color:white !important;

	margin-left:8px !important;
	margin-right:8px !important;
	position:relative !important;
	opacity: 1 !important;
}

.vueperslides__arrow--next{
	background: black !important;
	color:white !important;

	margin-left:8px !important;
	margin-right:8px !important;
	position:relative !important;
	opacity: 1 !important;
}

.vueperslides__arrow {
	transform: translateY(0%) !important;
}

#short_description.hover {
  background-color: rgba(0, 0, 0, 0.5) !important;
}

.vueperslides__parallax-wrapper {
	height: 300px !important;
}

@media only screen and (max-width: 940px) {
	.vueperslides__parallax-wrapper {
		width:335px !important;
		height: 265px !important;
		margin-left: auto !important;
		margin-right:auto !important;
	}
}

.vueperslides__bullets {
	position: unset !important;
}

.vueperslides__bullet {
	margin-left: 0px !important;
	margin-right: 0px !important;
}

.button {
  position: relative;
  background-color: transparent;
  color: #e8e8e8;
  font-size: 17px;
  font-weight: 600;
  border-radius: 10px;
  width: 150px;
  height: 60px;
  border: none;
  text-transform: uppercase;
  cursor: pointer;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(51, 51, 51, 0.2);
  transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
}

.button::before {
  content: "Hello!";
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  pointer-events: none;
  background: linear-gradient(135deg,#7b4397,#dc2430 );
  transform: translate(0%,90%);
  z-index: 1;
  position: relative;
  transform-origin: bottom;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.button::after {
  content: "Let's Talk 👋";
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #014D69;
  width: 100%;
  height: 100%;
  pointer-events: none;
  transform-origin: top;
  transform: translate(0%,-100%);
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.button:hover::before {
  transform: translate(0%,0%);
}

.button:hover::after {
  transform: translate(0%,-200%);
}

.button:focus {
  outline: none;
}

.button:active {
  scale: 0.95;
}




</style>
