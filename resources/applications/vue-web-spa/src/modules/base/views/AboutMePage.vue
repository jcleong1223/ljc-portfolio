<template>
	<v-sheet
		color="transparent"
		class="fill-height"
	>
		<v-sheet
			:height="$vuetify.breakpoint.mdAndUp ? '500' : '150'"
			color="transparent"
			:class="$vuetify.breakpoint.mdAndUp ? 'ml-md-10 mt-15' : 'ml-md-10 mt-0'"
		>
			<v-container
				class=""
				:class="$vuetify.breakpoint.mdAndUp ? 'justify-center px-0 mt-5 mb-15' : 'justify-center px-0 mt-0 mb-15' "
			>
				<v-row
					class="fill-width mx-auto"
					justify-md="start"
					justify="center"
				>
					<v-col
						lg="5"
						md="6"
						sm="6"
						cols="12"
						style="background-color:transparent;text-align: -webkit-center;"
						:class="$vuetify.breakpoint.mdAndUp ? '' : 'order-2'"
					>
						<div id="card" class="polaroid-card">
							<div class="content">
								<div class="d-block">
									<img 
										src="/images/self-image.jpeg" 
										class="text-center mb-10 rounded-md" 
										:style="$vuetify.breakpoint.mdAndUp ? 'width: 100%': 'width: 100%'" 
									/>
									<h2 class="font-poppins font-weight-medium black--text">Full Stack Developer </h2>
								</div>
							</div>
						</div>
					</v-col>
					<v-col
						lg="7"
						md="6"
						sm="6"
						cols="12"
						style="background-color:transparent"
						:class="$vuetify.breakpoint.mdAndUp ? '' : 'order-1'"
					>
						<div
							class="d-block"
						>
							<span
								class="font-poppins text-h3 pl-md-0 customize-text-color"
								style="text-shadow: 3px 1px 12px rgba(60,228,233,0.6); font-weight: 900;"
							>
								<b>Hello, I'm Jia Chong </b>
							</span>
							<span style="font-size: 30px;">&#128512;</span>
							<br />
							<div
								class="mt-10 mr-10 text-justify"
							>
								<span>A motivated and enthusiastic Junior Full Stack Developer with expertise translating functional specifications and business requirements into software solutions. Competent in <span class="customize-text-color font-weight-bold">frontend & backend development and data architecture</span>. Possess practical working knowledge in software development with accomplished multiple records of software projects. Participates in the software development lifecycle including <span class="customize-text-color font-weight-bold">dnevelopment, modification, maintaining and testing </span>of integrated business/enterprise software solutions. Recognized as a proficient problem solver with a good logical and abstract reasoning abilities enabling <span class="customize-text-color font-weight-bold">effective troubleshooting, debugging and providing solutions </span>to the technical issues.</span>
							</div>
							<div
								class="mt-10 mr-10"
								style="font-size: 60px;"
							>
								<a href="https://www.linkedin.com/in/leong-jia-chong-b0762a190/" class="white--text" target="_blank"><span class="mdi mdi-linkedin"></span></a>
								<a href="mailto:leongjc1223@gmail.com" class="white--text"><span class="mdi mdi-email"></span></a>
								<a href="https://t.me/jcleong23" class="white--text"><span class="mdi mdi-telegram"></span></a>
								<a href="https://github.com/jcleong1223?tab=repositories" class="white--text"><span class="mdi mdi-github"></span></a>
							</div>
						</div>
					</v-col>
				</v-row>
			</v-container>




			<v-container
				:class="$vuetify.breakpoint.mdAndUp ? 'justify-center pl-7' : 'justify-center px-0'"
			>
				<div
					class="mb-10"
				>
					<span
						class="font-poppins text-h3 pl-md-0 ml-6"
					>
						<b>My Skills </b>
					</span>
				</div>
				<v-row
					:class="$vuetify.breakpoint.mdAndUp ? 'fill-width mx-auto mb-8' : 'fill-width mx-auto'"
					justify-md="start"
					justify="center"
				>
					<v-col
						v-for="(mySkill, k) in mySkills"
						:key="k" 
						lg="2"
						md="4"
						sm="4"
						cols="6"
						style="background-color:transparent;text-align: -webkit-center;"
					>
						<div class="card-container">
							<div class="card">
								<div class="front-content d-block align-self-center pt-6">
									<img :src="mySkill.icon" width="41%" class="text-center pb-3" />
									<p>{{ mySkill.title }}</p>
								</div>
								<div class="content">
									<p class="heading">
										<!-- For another hovering effect -->
									</p>
								</div>
							</div>
						</div>
					</v-col>
				</v-row>
			</v-container>


			<v-container>
				<v-row
					class="fill-width mx-auto mb-10"
					justify-md="start"
					justify="center"
				>
					<v-col
						md="5"
						cols="12"
						style="background-color:transparent;"
						:class="$vuetify.breakpoint.mdAndUp ? '' : 'pa-0 ml-n10'"
					>
						<div class="list">
							<ul>
								<li><span><span class="mdi mdi-language-css3 py-0"></span>Webpage Frontend Development</span></li>
								<li><span><span class="mdi mdi-application-import py-0"></span>Webpage Backend Development</span></li>
								<li><span><span class="mdi mdi-apps-box py-0"></span>Software Product Development</span></li>
								<li><span><span class="mdi mdi-cog-box py-0"></span>CRM System Development</span></li>
							</ul>
						</div>
					</v-col>
					<v-col
						md="5"
						cols="12"
						style="background-color:transparent;"
						:class="$vuetify.breakpoint.mdAndUp ? '' : 'pa-0 ml-n10'"
					>
						<div class="list">
							<ul>
								<li><span><span class="mdi mdi-api py-0"></span>API Development</span></li>
								<li><span><span class="mdi mdi-application-cog py-0"></span>CMS Development</span></li>
								<li><span><span class="mdi mdi-page-next py-0"></span>Landing Page</span></li>
								<li><span><span class="mdi mdi-wordpress py-0"></span>Wordpress Development</span></li>
							</ul>
						</div>
					</v-col>
				</v-row>
			</v-container>

			<v-container>
				<div
					class="mb-10"
				>
					<span
						class="font-poppins text-h3 pl-md-0 ml-6"
					>
						<b>Certificates </b>
					</span>
					<!-- <div ref="certificatesTargetDiv" class="d-flex justify-center"></div> -->
				</div>
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
							color="black"
							height="40"
							min-width="40"
							class="pa-0"
							elevation="0"
							tile
							style="border-radius: 50%"
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
							style="border-radius: 50%"
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
						v-for="(certificate,i) in certificates" 
						:key="i" 
						:image="certificate.web_image.file_url"
						style="border-radius: 25px; box-shadow: 0 15px 20px rgba(0, 0, 0, 0.7); cursor: pointer;"
					>
						<template #content>
							<div class="vueperslide__content-wrapper" @click="previewCert(certificate, i)">
								<div 
									class="vueperslide__title py-2 font-weight-bold font-size-subtitle" 
									:style="'background-color: rgba(22,44,52,1); color:white; width: 100%; position: absolute; bottom:0;'"
								>
									{{ certificate.title }}
								</div>
							</div>
						</template>
					</vueper-slide>

					<template #bullet="{ active }">
						<i class="icon px-1"><v-icon :color="active ? '#2F5E6F' : '#D9D9D9'" :size="$vuetify.breakpoint.smAndDown ? '35px' : '45px'" class="px-md-0 px-1">mdi-minus</v-icon></i>
					</template>
				</vueper-slides>
			</v-container>
		</v-sheet>

		<v-container>
			<div class="text-center">
				<v-dialog
					v-if="certModal"
					v-model="certModal"
					activator="parent"
					:width="$vuetify.breakpoint.smAndDown ? '100%' : '50%'"
				>
					<v-card color="rgba(22,44,52,1)">
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
import { VueperSlides, VueperSlide} from 'vueperslides';
import 'vueperslides/dist/vueperslides.css';
import BaseClient from '../client';

export default {
	components: {
		VueperSlide,
		VueperSlides,
	},

	data() {
		return {
			certificates: [],
			certModal: false,
			current_cert: '',
			mySkills: [],
			// currencyFormat: '',
		};
	},
	computed: {

	},
	created() {
		//
		this.fetchCertData();
		this.fetchSkills();
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
		fetchCertData(){
			BaseClient.getCertificatesPage().then((res) => {
				const result = res.data.data
				this.certificates = result.certificates;
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},
		fetchSkills(){
			BaseClient.getTagData().then((res) => {
				const response = res.data.data
				this.mySkills = response.my_skills
				console.log(this.mySkills);
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},
		previewCert(cert, idx){
			this.certModal = true;
			this.current_cert = cert;
		}
	},
};
</script>

<style>

/* Information card style and effect */
.title-style {
	color: #66FCD1;
	text-shadow: 3px 1px 12px rgba(60,228,233,0.6);
	font-weight: 900;
	animation: flicker 5s infinite linear;
}

@keyframes flicker {
	0%,18%,20%,40%,50.1%,60%,65.1%,80%,90.1%,92%{
		color: #B8CCED;
		text-shadow: none;
	}
	18.1%,20.1%,30%,40.1%,50%,60.1%,65%,80.1%,90%,92.1%,100%{
		color: #ffffff;
		text-shadow: 0 0 10px #78C7C8,
		0 0 10px #78C7C8,
		0 0 30px #78C7C8,
		0 0 70px #78C7C8,
		0 0 100px #78C7C8
	}
}

.polaroid-card {
	width: 70%;
	height: 96%;
	background: #ffffff;
	display: flex;
	justify-content: center;
	align-items: center;
	box-shadow: 0px 0px 15px 10px #4949498b;
	overflow: hidden;
	position: relative;
	border-radius: 8px;
	rotate: -3deg;
}

.polaroid-card .content {
	border-radius: 15px;
	background: #ffffff;
	width: 96%;
	z-index: 1;
	padding: 20px 15px;
	color: white;
	display: flex;
	justify-content: center;
	align-items: center;
}
/* Information card style and effect */






.card-container {
	width: 150px;
	height: 150px;
	position: relative;
	border-radius: 10px;
	box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
	overflow: hidden;
	/* border: #f89b29 solid 1px; */
}

.card {
	width: 100%;
	height: 100%;
	border-radius: inherit;
}

.card .front-content {
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1)
}

.card .front-content p {
	font-size: 20px;
	font-weight: 700;
	opacity: 1;
	background: linear-gradient(-270deg, #53ffce 0%, #ff519f 100% );
	background-clip: text;
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1)
}

.card .content {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	text-align: center;
	gap: 10px;
	background: linear-gradient(-45deg, #39ffc7 0%, #ff0f7b 100% );
	color: #e8e8e8;
	padding: 20px;
	line-height: 1.5;
	border-radius: 5px;
	pointer-events: none;
	transform: translateY(-96%);
	transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.card .content .heading {
	font-size: 32px;
	font-weight: 700;
}

.card-container:hover {
	box-shadow: 0 0 20px rgba(150, 250, 255, 0.8);
	border-color: #88dbff;
}


.list {
	position: relative;
}

.list ul {
	position: relative;
}

.list ul li {
	position: relative;
	left: 0;
	color: #fce4ec;
	list-style: none;
	margin: 20px 0;
	padding: 8px 0;
	border-left: 2px solid #1cd18b;
	transition: 0.5s;
	border-radius: 10px;
	box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
	overflow: hidden;
}

.list ul li:hover {
	left: 10px;
}

.list ul li span {
	font-size: 18px;
	position: relative;
	padding: 8px;
	padding-left: 10px;
	display: inline-block;
	z-index: 1;
	transition: 0.5s;
}

.list ul li:hover span {
	color: #111;
}

.list ul li:before {
	content: "";
	position: absolute;
	top: 0;
	width: 100%;
	height: 100%;
	background: #1cd18b;
	transform: scaleX(0);
	transform-origin: left;
	transition: 0.5s;
}

.list ul li:hover:before {
	transform: scaleX(1);
}

.customize-text-color {
	background: -webkit-linear-gradient(rgb(102, 252, 209), rgb(102, 147, 252));
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

@media only screen and (max-width: 940px) {
	.vueperslides__parallax-wrapper {
		padding-bottom: 70% !important; 
	}

	.vueperslides__bullets {
		display: flex;
		justify-content: center;
		position: absolute;
		bottom: -25%;
		left: 0;
		right: 0;
	}
}

</style>