<template>
	<v-sheet color="transparent" class="fill-height">
		<section>
			<v-sheet color="transparent">
				<div>
					<v-img
						src="/images/asset/fabrication1.png"
						eager
						:aspect-ratio="$vuetify.breakpoint.mdAndUp ? 8/3 : 1"
					>
						<v-overlay
							class="text-center"
							absolute
						>
							<span :class="$vuetify.breakpoint.smAndDown ? 'ma-auto pa-auto text-h4 font-family-libre-baskerville' : 'ma-auto pa-auto font-family-libre-baskerville font-size-header'"><b>Fabrications</b></span>
						</v-overlay>
					</v-img>
				</div>
			</v-sheet>
		</section>

		<section>
			<v-container>
				<div :class="$vuetify.breakpoint.smAndDown ? 'px-2 my-8 text-h6 font-weight-bold text-left font-family-libre-baskerville ' : 'my-16 text-md-h5 font-weight-bold text-left font-family-libre-baskerville title_responsive'"><h3>Major Projects</h3></div>
				<v-sheet color="transparent">
					<v-row class="mb-10 justify-sm-space-between justify-center">
						<template v-for="(fabrication,i) in fabrications">
							<v-col :key="i" sm="6" col="12">
								<v-card class="py-0 px-2 my-0 elevation-0 fabric_effect">
									<v-img
										:key="i"
										max-width="100%"
										height="300"
										:src="fabrication.image.file_url"
										style="cursor: pointer;"
										class="mb-3"
										eager
										@click="viewFabricationImg(1, fabrication)"
									>
									</v-img>
									<div class="mb-8"><span class="text-h6 font-weight-bold font-family-libre-baskerville">{{ fabrication.title }}</span></div>
								</v-card>
							</v-col>
						</template>
					</v-row>
					<v-row
						v-if="fabrications.length"
						:class="$vuetify.breakpoint.smAndDown ? 'justify-center' : 'justify-space-between ml-2'"
					>
						<p v-if="currentPage != pageCount" class="my-auto">Showing {{ initialData }} - {{ endData }} of {{ totalResult }} results</p>
						<p v-else class="my-auto">Showing {{ initialData }} - {{ totalResult }} of {{ totalResult }} results</p>
						<v-pagination
							v-model="currentPage"
							:length="pageCount"
							color="#DAA520"
							@input="getPaginatedData"
						>
						</v-pagination>
					</v-row>
				</v-sheet>
			</v-container>
		</section>

		<!-- View Gallery Start -->
		<v-dialog
			v-model="dialogOpen"
			activator="parent" :style="$vuetify.breakpoint.smAndDown ? 'width: 100%;' : 'width:70%;'"
		>
			<v-card color="black">
				<v-card-text class="white--text pt-5 font-family-libre-baskerville">
					<v-row>
						<v-col col="10" class="py-1 pl-6 align-self-center">
							<h3>{{ fabricationTitle }}</h3>
						</v-col>
						<v-col col="2" class="text-end py-1">
							<div :class="$vuetify.breakpoint.mdAndUp?'':'py-1'"><v-icon :size="$vuetify.breakpoint.mdAndUp?'33px':'35px'" color="white" @click="viewFabricationImg(0)">mdi-close-circle</v-icon></div>
						</v-col>
					</v-row>
				</v-card-text>
				<custom-carousel
					:length="fabricationImgs.length"
					:show-arrows="false"
					eager
					cycle
				>
					<template v-for="(gallery,j) in fabricationImgs">
						<v-carousel-item
							:key="j"
							eager
						>
							<div>
								<v-img
									:src="gallery.content.file_url"
									eager
									height="500"
								>
								</v-img>
							</div>
						</v-carousel-item>
					</template>
				</custom-carousel>
			</v-card>
		</v-dialog>
		<!-- View Gallery End-->
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
import BaseClient from '../client';
import CustomCarousel from '@src/components/CustomCarousel.vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

export default {
	components: {
		CustomCarousel,
	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
			dialog: false,
			fabrications: [],
			dialogOpen: false,
			fabricationImgs: [],
			fabricationTitle: '',
			totalResult: 0,
			pageCount: 0,
			currentPage: 1,
		}
	},
	computed: {
		mediaContent(){
			return this.fabrications?.media_contents || []
		},
		initialData(){
			return ((this.currentPage - 1) * 4) + 1
		},
		endData() {
			return ((this.currentPage - 1) * 4) + 4
		}
	},
	created(){
		this.fetchPageData();
		AOS.init();
	},
	methods: {
		fetchPageData() {
			BaseClient.getFabricationsPage(this.currentPage).then((res) => {
				const result = res.data.data
				this.fabrications = result.fabrications;
				this.pageCount = result.page;
				this.totalResult = result.totalResult
				console.log(result);
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},
		viewFabricationImg(action, item = null) {
			if(action) {
				this.dialogOpen = true;
				this.fabricationImgs = item.media_contents;
				this.fabricationTitle = item.title;
			} else {
				this.dialogOpen = false;
			}
		},
		getPaginatedData() {
			BaseClient.getPaginatedData(this.currentPage).then((res) => {
				const result = res.data.data
				this.fabrications = result.fabrications;
				console.log(result);
			}).catch((err) => {
				this.errorHandler_(err);
			});
		}
	},
};
</script>

<style>

@media (max-width: 600px)
{
	.title_responsive
	{
		font-size: 28px;
	}
}

.v-pagination__item, .v-pagination__navigation {
	box-shadow: none;
}

.fabric_effect :hover
{
	transform: scale(105%);
	transition: 1s;
}
</style>
