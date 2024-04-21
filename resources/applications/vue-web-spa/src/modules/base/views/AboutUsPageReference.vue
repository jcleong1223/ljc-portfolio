<template>
	<v-sheet color="transparent" class="fill-height">
		<section>
			<page-title :title="$t('about-us-page.title')" image="/images/banner/aboutUs.png" />
		</section>
		<section>
			<section>
				<v-sheet color="transparent">
					<div>
						<!-- replace image below with provided image-->
						<v-img
							src="/images/asset/aboutus1.png"
							eager
							:aspect-ratio="$vuetify.breakpoint.mdAndUp ? 8/3 : 1"
						>
							<v-overlay absolute>
								<span :class="$vuetify.breakpoint.smAndDown ? 'ma-auto pa-auto font-family-libre-baskerville text-h4' : 'ma-auto pa-auto font-family-libre-baskerville font-size-header'"><b>About Us</b></span>
							</v-overlay>
						</v-img>
					</div>
				</v-sheet>
			</section>
			<section>
				<v-row
					class="flex-column text-center py-16 my-0 mb-md-10 mt-md-15 mx-0" justify="center" align="center"
					:style="$vuetify.breakpoint.mdAndUp ? 'background-image: url(/images/asset/aboutus1996.png); background-repeat: no-repeat; background-size: 52%; background-position: center' : ''"
				>
					<v-col
						:style="$vuetify.breakpoint.smAndDown ? 'background-image: url(/images/asset/aboutus1996.png); background-repeat: no-repeat; background-size: contain; background-position: center' : ''"
						:class="$vuetify.breakpoint.smAndDown ? 'py-10' : ''"
					>
						<div class="font-weight-bold font-family-libre-baskerville font-size-title">
							K.P. Loo Engineering
						</div>
					</v-col>
					<v-col cols="10">
						<div
							:style="$vuetify.breakpoint.smAndDown ? 'width: 100%' : 'width: 95%'"
							:class="$vuetify.breakpoint.smAndDown ? 'text-justify' : 'text-center text-md-justify mx-auto'"
						>
							<div class="font-size-text font-family-lato">KPLOO is a leading metal fabricator in Malaysia, specializing in designing and building custom electrical panels and sheet metal manufacture. Our team of experts has over 25 years of experience in the industry, and we pride ourselves on delivering top-quality craftsmanship and innovative solutions that exceed our clients' expectations. We use advance techniques to provide cost-effective and efficient solutions for a variety of industries, including construction, manufacturing, and engineering. At KPLOO, we are committed to providing exceptional customer service and building long-lasting relationships with our clients. </div>
						</div>
					</v-col>
					<!-- <p class="bg-text font-weight-bold">1996</p> -->
				</v-row>
				<v-container class="mb-md-15 pb-15">
					<v-row data-aos="fade-up" data-aos-duration="1500" :class="$vuetify.breakpoint.smAndDown ? 'd-block justify-center mb-5' : 'py-5 my-0 mb-md-5 mt-md-10 justify-space-around'">
						<v-col
							v-for="(content, i) in contents"
							:key="i"
							cols="12" md="4"
							justify="center"
							align="center"
						>
							<span :class="$vuetify.breakpoint.smAndDown ? 'font-weight-bold text-h6 font-family-libre-baskerville' + content.responsiveClass : 'font-weight-bold font-size-title font-family-libre-baskerville' + content.class">{{ content.title }}</span>
							<v-card
								eager
								:class="$vuetify.breakpoint.smAndDown ? content.responsiveClass : content.class"
								rounded="0"
								:color="content.color"
								style="height:580px"
							>
								<v-card-text
									class="white--text text-center text-justify pa-8 font-family-lato font-size-text d-flex align-center"
									v-html="content.description"
								>
									<!-- {{ content.description }} -->
								</v-card-text>
							</v-card>
						</v-col>
					</v-row>
				</v-container>
			</section>

			<section v-if="$vuetify.breakpoint.mdAndUp" style="background: black" class="py-15">
				<div class="font-size-title white--text font-weight-bold font-family-libre-baskerville my-10 text-center">
					Our story & achievements
				</div>
				<v-timeline
					v-if="$vuetify.breakpoint.mdAndUp"
					width="100%" align="start"
					class="mx-16 px-16 white--text"
				>
					<div></div>
					<v-timeline-item
						v-for="(year, i) in years"
						:key="i"
						:color="year.color"
						class="mb-16"
						justify="center"
						small
						fill-dot
					>
						<template #opposite>
							<v-img
								:src="year.img"
								class="img_effect"
								eager
							>
							</v-img>
						</template>
						<div class="pt-10" data-aos="zoom-in-down" data-aos-duration="2000">
							<div class="font-weight-bold font-family-libre-baskerville font-size-title pb-5" v-text="year.year"></div>
							<p class="font-family-lato text-justify font-size-text">
								{{ year.description }}
							</p>
						</div>
					</v-timeline-item>
				</v-timeline>
				<!-- <div v-else>
					<v-col v-for="(year, i) in years" :key="i" class="pa-3">
						<v-img
							:src="year.img"
							eager
						>
						</v-img>
						<div class="pt-10 white--text">
							<v-row class="mb-3 pl-3">
								<v-icon :color="year.year == years[0].year ? '#DAA520' : 'white'">mdi-circle</v-icon>
								<div class="align-self-center text-h4 font-weight-bold font-family-libre-baskerville pl-3" v-text="year.year"></div>
							</v-row>
							<p class="text-justify">
								{{ year.description }}
							</p>
						</div>
					</v-col>
				</div> -->
			</section>
			<section v-else>
				<v-col
					style="background-color:black;" class="px-7"
				>
					<div
						class="text-h5 white--text font-weight-bold font-family-libre-baskerville my-10 text-center"
					>
						Our story & achievements
					</div>
					<div
						v-for="(year, i) in years"
						:key="i"
						class="mb-10"
					>
						<v-img
							:src="year.img"
							class="img_effect"
						>
						</v-img>
						<div class="pt-5 mx-3 white--text">
							<v-row>
								<v-icon
									:color="i == 0 ? '#DAA520' : '#FFFFFF'"
									large
								>
									mdi-checkbox-blank-circle
								</v-icon>
								<div class="text-h5 font-weight-bold font-family-libre-baskerville mx-4 my-6" v-text="year.year"></div>
							</v-row>
							<p class="text-justify mt-2 font-family-lato font-size-text">
								{{ year.description }}
							</p>
						</div>
					</div>
				</v-col>
			</section>

			<section :class="$vuetify.breakpoint.smAndDown ? 'mt-10 pt-10' : 'mt-10 pt-10 pl-5'">
				<!-- use <h1> tag, because text-hX is not working -->
				<!-- <div class="mb-8 text-md-h5 font-weight-bold text-left font-family-libre-baskerville mx-16 px-16"><h1>Certificates</h1></div> -->
				<v-row align="center" class="justify-space-between mb-8 mx-5 px-md-10 px-3">
					<span class="font-weight-bold text-left font-family-libre-baskerville font-size-title">Certificates</span>
					<div ref="certificatesTargetDiv" class="d-flex justify-center">
					</div>
				</v-row>
				<vueper-slides
					ref="certificateSlides"
					:class="$vuetify.breakpoint.mdAndUp ? 'no-shadow mx-md-16 mx-8' : 'no-shadow'"
					:visible-slides="$vuetify.breakpoint.mdAndUp ? 3 : 1"
					:size="$vuetify.breakpoint.mdAndUp ? 200 : 500"
					slide-multiple
					:bullet-outside="true"
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
						v-for="(certificate,i) in certificates" :key="i" :image="certificate.web_image.file_url"
					>
						<template #content>
							<div class="vueperslide__content-wrapper" @click="previewCert(certificate, i)">
								<div class="vueperslide__title py-2 font-family-libre-baskerville font-weight-bold font-size-subtitle" :style="'background-color: #000000; color:white; width: 100%; position: absolute; bottom:0;'">{{ certificate.title }}</div>
							</div>
							<!-- <img :src="certificate.web_image.file_url" @click="previewCert(certificate)"> -->
						</template>
					</vueper-slide>

					<template #bullet="{ active }">
						<i class="icon px-1"><v-icon :color="active ? '#DAA520' : '#D9D9D9'" :size="$vuetify.breakpoint.smAndDown ? '35px' : '45px'" class="px-md-0 px-1">mdi-minus</v-icon></i>
					</template>
				</vueper-slides>
			</section>
		</section>
		<!-- View Gallery Start -->
		<!-- <v-dialog
			v-if="certModal"
			v-model="certModal"
			activator="parent" :style="$vuetify.breakpoint.smAndDown ? 'width: 500px; box-shadow: none;' : 'width:500px; box-shadow: none;'"
		>
			<v-card color="black" class="ma-auto" :style="$vuetify.breakpoint.smAndDown ? 'width: 50%;' : 'width:50%;'">
				<v-card-text class="white--text pt-5 font-family-libre-baskerville">
					<v-row>
						<v-col col="10" class="py-1 pl-6 align-self-center">
							<h3>{{ current_cert.title }}</h3>
						</v-col>
						<v-col col="2" class="text-end py-1">
							<div :class="$vuetify.breakpoint.mdAndUp?'':'py-1'"><v-icon :size="$vuetify.breakpoint.mdAndUp?'33px':'35px'" color="white" @click="certModal = !certModal">mdi-close-circle</v-icon></div>
						</v-col>
					</v-row>
				</v-card-text>
				<v-img
					:src="current_cert.web_image.file_url"
					eager
				></v-img>
			</v-card>
		</v-dialog> -->
		<!-- View Gallery End-->
		<v-container>
			<div class="text-center">
				<v-dialog
					v-if="certModal"
					v-model="certModal"
					activator="parent"
					:width="$vuetify.breakpoint.smAndDown ? '100%' : '50%'"
				>
					<v-card color="black">
						<v-card-text class="white--text pt-5 font-family-libre-baskerville">
							<v-row>
								<v-col col="10" class="py-1 pl-6 align-self-center">
									<h3>{{ current_cert.title }}</h3>
								</v-col>
								<v-col col="2" class="text-end py-1">
									<div :class="$vuetify.breakpoint.mdAndUp?'':'py-1'"><v-icon :size="$vuetify.breakpoint.mdAndUp?'33px':'35px'" color="white" @click="certModal = false">mdi-close-circle</v-icon></div>
								</v-col>
							</v-row>
						</v-card-text>
						<v-img :src="current_cert.web_image.file_url" width="100%"></v-img>
					</v-card>
				</v-dialog>
			</div>
		</v-container>
	</v-sheet>
</template>

<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
// import Swiper from 'swiper/bundle';
// import 'swiper/css';
// import CustomCarousel from '@src/components/CustomCarousel.vue';
import { VueperSlides, VueperSlide} from 'vueperslides';
import BaseClient from '../client';
import 'vueperslides/dist/vueperslides.css'
import AOS from 'aos';
import 'aos/dist/aos.css';

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
			certificates: [],
			certModal: false,
			current_cert: '',
			contents: [
				{
					title: 'Our Vision',
					color: 'black',
					description: 'At KPLOO, we are dedicated to revolutionizing the world of metal enclosure fabrication for switchgear and electrical panels. Our vision drives us to be the leading provider in our local market while striving for global expansion. As we expand into the international market, our vision remains steadfast: to become the preferred choice for metal enclosure solutions worldwide. ',
					class:"mt-10 mr-8",
					responsiveClass: "my-6"
				},
				{
					title: 'Our Mission',
					color: '#DAA520',
					description: 'Our mission is to be the trusted leader in providing precision-engineered metal enclosures for switchgear and electrical panels with a commitment that extends beyond delivering exceptional products. We aim to build enduring partnerships with our customers, based on integrity, transparency, and mutual trust through actively listening to feedback and collaborating closely with customers to provide personalized support, timely delivery, and ongoing assistance throughout the project lifecycle. ',
					class:"mt-10 mx-4",
					responsiveClass: "my-6"
				},
				{
					title: 'Our Core Value',
					color: 'black',
					description: 'Integrity<br/>Continuous Improvement<br/>Commitment<br/>Boldness',
					class:"mt-10 ml-8",
					responsiveClass: "my-6"
				},
			],
			years: [
				{
					color: '#DAA520',
					year: '2023',
					img: '/images/asset/aboutus2.png',
					description: 'Added one laser machine'

				},
				{
					color: 'white',
					year: '2018',
					img: '/images/asset/aboutus3.png',
					description: 'Obtaining our first silkscreen machine'
				},
				{
					color: 'white',
					year: '2017',
					img: '/images/asset/aboutus4.png',
					description: 'Certified ISO 9001:2015'

				},
				{
					color: 'white',
					year: '2014',
					img: '/images/asset/aboutus5.png',
					description: 'Relocated into a 69,000 square feet factory at Ijok . And added one laser machine, two bending machine and one punching machine'

				},
				{
					color: 'white',
					year: '2006',
					img: '/images/asset/aboutus6.png',
					description: 'Added two Amada punching machines while attaining our very first Amada laser machine'

				},
				{
					color: 'white',
					year: '2000',
					img: '/images/asset/aboutus7.png',
					description: 'Moving into a new 20,000 square feet factory in Segambut and starting to provide metal fabrication service. And obtained our very first punching machine, bending machine, cutting machine and a powder coating line.'
				},
				{
					color: 'white',
					year: '1996',
					img: '/images/asset/aboutus8.png',
					description: 'The establishment of KPLOO Engineering Sdn Bhd, offering subcontracting services specifically for punching machines.'

				},
			],
		}
	},
	created(){
		this.fetchPageData();
		AOS.init();
	},
	beforeUpdate() {
		this.$nextTick(() => {

			const certificatesSlides = this.$refs.certificateSlides.$el;
			const certificatesPrevButton = certificatesSlides.querySelector('.vueperslides__arrow--prev');
			const certificatesNextButton = certificatesSlides.querySelector('.vueperslides__arrow--next');
			const certificatesTargetDiv = this.$refs.certificatesTargetDiv;
			const certificatesBulletLength = this.$refs.certificateSlides.bulletIndexes.length;

			if(certificatesPrevButton && certificatesNextButton && certificatesBulletLength > 1){
				certificatesTargetDiv.appendChild(certificatesPrevButton);
				certificatesTargetDiv.appendChild(certificatesNextButton);
			} else {
				if(certificatesBulletLength < 2) {
					while (certificatesTargetDiv.firstChild) {
						certificatesTargetDiv.removeChild(certificatesTargetDiv.firstChild);
					}
				}
				this.$refs.certificateSlides.goToSlide(this.$refs.certificateSlides.$data.slides.current)
			}
		})
	},
	methods: {
		fetchPageData(){
			BaseClient.getCertificatesPage().then((res) => {
				const result = res.data.data
				this.certificates = result.certificates;
				console.log(this.certificates);
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},

		previewCert(certificate) {
			this.certModal = true
			this.current_cert = certificate
			console.log('current', this.current_cert)
		}

	},


};

</script>

<style>
.theme--light.v-timeline:before {
    background: white;
	weight: 1px;
}

.vueperslides__bullets {
    color: #DAA520;
}

.bg-text
{
    font-size:250px;
	color: #F1F1F1;
}

.img_effect:hover
{
	transform: scale(105%);
	transition: 0.5s;
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

	margin-left:8px;
	margin-right:8px;
	position:relative;
	opacity: 1;
}

.vueperslides__arrow {
	transform: translateY(0%) !important;
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
</style>

