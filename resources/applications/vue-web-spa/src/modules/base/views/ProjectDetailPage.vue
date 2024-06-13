<template>
	<v-sheet
		color="transparent"
		class="fill-height"
	>
		<v-sheet
			:height="$vuetify.breakpoint.mdAndUp ? '500' : '650'"
			color="transparent"
			class="ml-md-10 mt-0"
		>
			<section class="mt-10 pb-2 pt-0 pr-15">
				<v-container>
					<v-row :class="$vuetify.breakpoint.smAndDown ? 'pl-8' :'justify-space-between'">
						<div v-if="$vuetify.breakpoint.mdAndUp" class="align-self-center text-decoration-underline back_effect mr-10 black--text">
							<router-link :to="{ name: 'home-page' }" class="text-color-unset">
								<button class="btn_back">
									<div class="sign"><span class="mdi mdi-chevron-left"></span></div>
									<div class="hover_text">Back</div>
								</button>
							</router-link>
						</div>
						<div :class="$vuetify.breakpoint.smAndDown ? 'mb-8 font-size-title font-weight-bold font-poppins' : 'mb-2 font-size-header font-poppins font-weight-bold'">{{ project.title }}</div>
					</v-row>
				</v-container>
			</section>

			<section :class="$vuetify.breakpoint.smAndDown ? 'pa-0' : 'mb-5 pl-8 pr-15'">
				<v-container class="pa-0">
					<div :class="$vuetify.breakpoint.smAndDown ? '' : 'my-4 text-md-h5'" no-gutter>
						<!-- <custom-carousel-with-thumbnail
							:length="mediaContent.length"
							:show-arrows="$vuetify.breakpoint.mdAndUp"
							:images="mediaContent"
							eager
						>
							<template v-for="(gallery,i) in capability.media_contents">
								<v-carousel-item
									:key="i"
									eager
								>
									<div>
										<v-img
											:src="gallery.content.file_url"
											eager
											cover
											style="padding-bottom:45%;"
											width="100%"
											height="435"
											:aspect-ratio="$vuetify.breakpoint.mdAndUp ? 8/3 : 1"
										>
										</v-img>
									</div>
								</v-carousel-item>
							</template>
						</custom-carousel-with-thumbnail> -->
						<vueper-slides
							ref="vueperslides1"
							:touchable="false"
							fade
							:autoplay="false"
							:bullets="true"
							fixed-height="550px"
							@slide="$refs.vueperslides2.goToSlide($event.currentSlide.index, { emit: false })"
						>
							<vueper-slide
								v-for="(gallery, i) in galleries"
								:key="i"
								:image="gallery.file_url"
							>
							</vueper-slide>
						</vueper-slides>
						<vueper-slides
							ref="vueperslides2"
							class="no-shadow thumbnails"
							:visible-slides="galleries.length"
							fixed-height="75px"
							:bullets="false"
							:touchable="false"
							:gap="2.5"
							:arrows="false"
							@slide="$refs.vueperslides1.goToSlide($event.currentSlide.index, { emit: false })"
						>
							<vueper-slide
								v-for="(gallery, i) in galleries"
								:key="i"
								:image="gallery.file_url"
								class="mt-5"
								@click.native="$refs.vueperslides2.goToSlide(i)"
							>
							</vueper-slide>
						</vueper-slides>
					</div>
				</v-container>
			</section>

			<section class="mt-n10 mb-10 pa-md-0 px-8">
				<v-container>
					<v-row>
						<v-col
							cols="12"
							md="6"
						>
							<v-row class="justify-start">
								<div class="my-md-5 mt-8 mb-5 font-size-subtitle font-weight-bold text-left font-poppins mx-0">Language/Technology Used</div>
							</v-row>
							<v-row v-if="tags.length > 0" class="justify-start">
								<button 
									v-for="(tag, j) in tags"
									:key="j"
									class="chip-tag ma-2 font-family-primary"
								>
									{{ tag.title }}
								</button>
							</v-row>
							<v-row v-else class="justify-start">
								<span> - </span>
							</v-row>
						</v-col>
						<v-col
							cols="12"
							md="6"
						>
							<v-row class="justify-start">
								<div class="my-md-5 mt-8 mb-5 font-size-subtitle font-weight-bold text-left font-poppins mx-0">Website URL</div>
							</v-row>
							<v-row v-if="project.website_url" class="justify-start">
								<div class="text-justify font-size-text mx-0">
									<!-- <v-chip
										class="ma-2 font-family-primary"
										color="yellow"
										text-color="black"
										link
									>
										<v-icon
											left
											color="red"
										>
											mdi-web
										</v-icon>
										{{ project.website_url }} <span class="ml-3 mdi mdi-open-in-new"></span>
									</v-chip> -->
									<a 
										class="chip-tag d-flex ma-2 px-5 py-0 font-family-primary"
										style="cursor: pointer; text-decoration: none; color: white;"
										:href="`http://${project.website_url}`"
										target="_blank"
									>
										<v-icon
											left
											color="#3d93ee"
											class="py-2"
										>
											mdi-web
										</v-icon>
										{{ project.website_url }} <span class="ml-3 mdi mdi-open-in-new"></span>
									</a>
								</div>
							</v-row>
							<v-row v-else class="justify-start">
								<div class="text-justify font-size-text mx-0">
									<span> - </span>
								</div>
							</v-row>
						</v-col>
					</v-row>
				</v-container>
			</section>

			<section class="px-md-0 px-8 pb-15">
				<v-container>
					<v-row class="justify-start">
						<div class="my-8 font-weight-bold text-left font-poppins font-size-subtitle mx-0 px-0">Description</div>
					</v-row>
					<!-- <div>Picture section</div> -->
					<v-row class="justify-start">
						<div class="text-justify font-size-text font-family-primary mx-0">
							<div v-html="project.description"></div>
						</div>
					</v-row>
				</v-container>
			</section>
		</v-sheet>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
// import CustomCarouselWithThumbnail from '@src/components/CustomCarouselWithThumbnail.vue';
import BaseClient from '../client';
import { VueperSlides, VueperSlide} from 'vueperslides';
import 'vueperslides/dist/vueperslides.css';

export default {
	components: {
		// CustomCarouselWithThumbnail,
		VueperSlide,
		VueperSlides,
	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
			project: [],
			tags: [],
			galleries: [],
		}
	},
	computed:{
		mediaContent(){
			return this.project?.media_contents || []
		},
		project_title() {
			return this.project?.title || ''
		}
	},
	created(){
		if(this.$route.params.id){
			this.infoID = this.$route.params.id;
		}
	},
	mounted(){
		this.fetchPageData();
	},
	methods: {
		fetchPageData() {
			BaseClient.getPortfolioProjectDetailPage(this.infoID).then((res) => {
				const result = res.data.data
				this.project = result.project
				this.tags = result.project.tags
				// const tagStyle = [
				//     "background-color: pink; ",

				// ];

				// this.tags = result.project.tags.map((tag, index) => ({
				// 	...tag,
				// 	style: tagStyle[index % tagStyle.length]
				// }))

				console.log(this.tags);

				this.galleries = [
					result.project.image,
					...result.project.media_contents.map((item) => item.content)
				];
				console.log(this.galleries);
				this.loading = true;
			}).catch((err) => {
				this.errorHandler_(err);
			});
		}
	},

};

</script>

<style scoped>

.back_effect:hover
{
	-webkit-transform: translateX(-10%);
	transition: 0.5s;
	text-indent: 30px;
}

.small-img:hover
{
	transform: scale(108%);
	transition: 0.5s;
}

.chip-tag {
	--border-color: linear-gradient(-45deg, #f85231, #61159f, #1dc2e8);
	--border-width: 0.125em;
	--curve-size: 12px;
	--blur: 30px;
	--bg: #171717;
	--color: #ffffff;
	color: var(--color);
	cursor: default;
	/* use position: relative; so that BG is only for .chip-tag */
	position: relative;
	isolation: isolate;
	display: inline-grid;
	place-content: center;
	padding: 8px 26px;
	font-size: 15px;
	border: 0;
	box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
	clip-path: polygon(
	100% calc(100% - var(--curve-size)),
	/* bottom-right 1 */ calc(100% - var(--curve-size)) 100%,
	/* bottom-right 2 */ 0 100%
	/* Top-left */ 0% var(--curve-size),
	var(--curve-size) 0,
	/* top-right */ 100% 0,

	);
	transition: color 250ms;
	width: auto;
}

.chip-tag::after,
.chip-tag::before {
	content: "";
	position: absolute;
	inset: 0;
}

.chip-tag::before {
	background: var(--border-color);
	background-size: 300% 300%;
	animation: move-chip-bg 5s ease infinite;
	z-index: -2;
}

@keyframes move-chip-bg {
	0% {
		background-position: 31% 0%;
	}

	25% {
		background-position: 0% 35%;
	}

	50% {
		background-position: 70% 100%;
	}

	75% {
		background-position: 35% 0%;
	}

	100% {
		background-position: 31% 0%;
	}
}

.chip-tag::after {
	background: var(--bg);
	z-index: -1;
	clip-path: polygon(
	/* Top-left */ var(--border-width)
		calc(var(--curve-size) + var(--border-width) * 0.5),
	calc(var(--curve-size) + var(--border-width) * 0.5) var(--border-width),
	/* top-right */ calc(100% - var(--border-width)) var(--border-width),
	calc(100% - var(--border-width))
		calc(100% - calc(var(--curve-size) + var(--border-width) * 0.5)),
	/* bottom-right 1 */
		calc(100% - calc(var(--curve-size) + var(--border-width) * 0.5))
		calc(100% - var(--border-width)),
	/* bottom-right 2 */ var(--border-width) calc(100% - var(--border-width))
	);
	transition: clip-path 500ms;
}

.btn_back {
	--black: #000000;
	--light_green_blue: #66FCD1;
	--white: #ffffff;
	--af-white: #f3f3f3;
	--ch-white: #e1e1e1;
	display: flex;
	align-items: center;
	justify-content: flex-start;
	width: 45px;
	height: 45px;
	border: none;
	border-radius: 12px;
	cursor: pointer;
	position: relative;
	overflow: hidden;
	transition-duration: .3s;
	box-shadow: 0px 0px 12px rgba(68, 255, 233, 0.75);
	background-color: var(--light_green_blue);
}

.sign {
	font-size: 35px;
	width: 100%;
	transition-duration: .3s;
	display: flex;
	align-items: center;
	justify-content: center;
}

.hover_text {
	position: absolute;
	right: 0%;
	width: 0%;
	opacity: 0;
	color: var(--af-white);
	font-size: 17px;
	font-weight: 900;
	transition-duration: .3s;
	line-height: 15px;
	color: black
}

.btn_back:hover {
	width: 100px;
	border-radius: 12px;
	transition-duration: .3s;
}

.btn_back:hover .sign {
	width: 30%;
	transition-duration: .3s;
	padding-left: 7px;

}

.btn_back:hover .hover_text {
	opacity: 1;
	width: 70%;
	transition-duration: .3s;
	padding-right: 10px;
}

.btn_back:active {
	transform: translate(2px ,2px);
}


</style>