<template>
	<v-sheet color="transparent" class="fill-height">
		<section class="mt-16 pb-2 pt-10">
			<v-container>
				<v-row :class="$vuetify.breakpoint.smAndDown ? 'pl-8' :'justify-space-between'">
					<div :class="$vuetify.breakpoint.smAndDown ? 'mb-8 font-size-title font-weight-bold font-family-libre-baskerville' : 'mb-2 font-size-title font-family-libre-baskerville font-weight-bold'">{{ capability.title }}</div>
					<div v-if="$vuetify.breakpoint.mdAndUp" class="align-self-center text-decoration-underline back_effect mr-10" style="color: #DAA520;">
						<router-link :to="{ name: 'capabilities' }" class="text-color-unset">
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
					<custom-carousel-with-thumbnail
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
					</custom-carousel-with-thumbnail>
				</div>
			</v-container>
		</section>

		<section class="mb-10 pa-md-0 px-8">
			<v-container>
				<v-row class="justify-start">
					<div class="my-md-5 mt-10 mb-5 font-size-subtitle font-weight-bold text-left font-family-libre-baskerville mx-0">{{ capability.title }}</div>
				</v-row>
				<v-row class="justify-start">
					<div class="text-justify font-size-text mx-0">
						<div>{{ capability.short_description }}</div>
					</div>
				</v-row>
			</v-container>
		</section>

		<v-divider :thickness="4" color="black" :width="$vuetify.breakpoint.mdAndUp ? '78%' : '90%' "></v-divider>

		<section class="mb-15 pa-md-0 px-8">
			<v-container>
				<v-row class="justify-start">
					<div class="my-8 font-weight-bold text-left font-family-libre-baskerville font-size-subtitle mx-0 px-0">Description</div>
				</v-row>
				<!-- <div>Picture section</div> -->
				<v-row class="justify-start">
					<div class="text-justify font-size-text font-family-inter mx-0">
						<div v-html="capability.description"></div>
					</div>
				</v-row>
			</v-container>
		</section>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
import CustomCarouselWithThumbnail from '@src/components/CustomCarouselWithThumbnail.vue';
import BaseClient from '../client';

export default {
	components: {
		CustomCarouselWithThumbnail,
	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
			capability: [],
		}
	},
	computed:{
		mediaContent(){
			return this.capability?.media_contents || []
		},
		capability_title() {
			return this.capability?.title || ''
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
			BaseClient.getCapabilityInfo(this.infoID).then((res) => {
				const result = res.data.data
				this.capability = result.capability
				console.log(this.capability,this.capability.media_contents.length );
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