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
			<section class="mt-16 pb-2 pt-0">
				<v-container>
					<v-row :class="$vuetify.breakpoint.smAndDown ? 'pl-8' :'justify-space-between'">
						<div :class="$vuetify.breakpoint.smAndDown ? 'mb-8 font-size-title font-weight-bold font-poppins' : 'mb-2 font-size-header font-poppins font-weight-bold'">{{ project.title }}</div>
						<div v-if="$vuetify.breakpoint.mdAndUp" class="align-self-center text-decoration-underline back_effect mr-10" style="color: #DAA520;">
							<router-link :to="{ name: 'home-page' }" class="text-color-unset">
								<span class="font-family-inter font-size-subtitle">
									<v-icon color="#DAA520" size="x-large" class="text-end">
										mdi-arrow-left
									</v-icon>Back
								</span>
							</router-link>
						</div>
					</v-row>
				</v-container>
			</section>

			<section :class="$vuetify.breakpoint.smAndDown ? 'pa-0' : 'mb-10 pl-8'">
				<v-container class="pa-0">
						<div :class="$vuetify.breakpoint.smAndDown ? '' : 'my-8 text-md-h5'" no-gutter>
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
							:bullets="false"
							fixed-height="400px"
							@slide="$refs.vueperslides2.goToSlide($event.currentSlide.index, { emit: false })"
						>
							<vueper-slide
								v-for="(slide, i) in slides"
								:key="i"
								:image="slide.image"
							>
							</vueper-slide>
						</vueper-slides>
						<vueper-slides
							ref="vueperslides2"
							class="no-shadow thumbnails"
							:visible-slides="slides.length"
							fixed-height="75px"
							:bullets="false"
							:touchable="false"
							:gap="2.5"
							:arrows="false"
							@slide="$refs.vueperslides1.goToSlide($event.currentSlide.index, { emit: false })"
						>
							<vueper-slide
								v-for="(slide, i) in slides"
								:key="i"
								:image="slide.image"
								@click.native="$refs.vueperslides2.goToSlide(i)"
							>
							</vueper-slide>
						</vueper-slides>
					</div>
				</v-container>
			</section>

			<section class="mb-10 pa-md-0 px-8">
				<v-container>
					<v-row class="justify-start">
						<div class="my-md-5 mt-8 mb-5 font-size-subtitle font-weight-bold text-left font-poppins mx-0">Language/Technology Used</div>
					</v-row>
					<v-row class="justify-start">
						<v-chip
							v-for="(tag, j) in tags"
							:key="j"
							class="ma-2 font-family-primary"
							color=""
							text-color="white"
						>
							{{ tag.title }}
						</v-chip>
					</v-row>
				</v-container>
			</section>

			<section class="mb-10 pa-md-0 px-8">
				<v-container>
					<v-row class="justify-start">
						<div class="my-md-5 mt-8 mb-5 font-size-subtitle font-weight-bold text-left font-poppins mx-0">Website URL</div>
					</v-row>
					<v-row class="justify-start">
						<div class="text-justify font-size-text mx-0">
							<v-chip
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
								www.google.com <span class="ml-3 mdi mdi-open-in-new"></span>
							</v-chip>
						</div>
					</v-row>
				</v-container>
			</section>

			<v-divider :thickness="4" color="black" :width="$vuetify.breakpoint.mdAndUp ? '78%' : '90%' "></v-divider>

			<section class="mb-15 pa-md-0 px-8">
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
			slides: [
				{ image: '/images/html.png' },
				{ image: '/images/css.png'},
				{ image: '/images/javascript.png' }
			]
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
				console.log(this.tags)
				// console.log(this.capability,this.capability.media_contents.length );
				this.loading = true;
			}).catch((err) => {
				this.errorHandler_(err);
			});
		}
	},

};

</script>

<style>

.back_effect:hover
{
	-webkit-transform: translateX(-10%);
	transition: 0.5s;
}

.small-img:hover
{
	transform: scale(108%);
	transition: 0.5s;
}

</style>