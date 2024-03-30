<template>
	<v-sheet color="transparent" class="fill-height">
		<section>
			<v-sheet color="transparent">
				<custom-carousel
					:length="banners.length"
					:show-arrows="$vuetify.breakpoint.mdAndUp"
					eager
					cycle
				>
					<template v-for="(banner,i) in banners">
						<v-carousel-item
							:key="i"
							eager
						>
							<div>
								<v-img
									:src="$vuetify.breakpoint.mdAndUp ? banner.web_image.file_url : banner.mobile_image.file_url"
									eager
									:aspect-ratio="$vuetify.breakpoint.mdAndUp ? 8/3 : 1"
								>
								</v-img>
							</div>
						</v-carousel-item>
					</template>
				</custom-carousel>
			</v-sheet>
		</section>
		<section>
			<v-sheet height="400" color="red" class="pa-4">
				<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, nostrum.</div>
				<div>Asperiores quia harum perspiciatis cum eos.</div>
				<div>Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</div>
			</v-sheet>
		</section>
		<section>
			<v-sheet height="400" color="orange" class="pa-4">
				<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, nostrum.</div>
				<div>Asperiores quia harum perspiciatis cum eos.</div>
				<div>Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</div>
			</v-sheet>
		</section>
		<section>
			<v-sheet height="400" color="yellow" class="pa-4">
				<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, nostrum.</div>
				<div>Asperiores quia harum perspiciatis cum eos.</div>
				<div>Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</div>
			</v-sheet>
		</section>
		<section>
			<v-sheet height="400" color="green" class="pa-4">
				<div id="about-us" class="text-h6">About US</div>
				<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, nostrum.</div>
				<div>Asperiores quia harum perspiciatis cum eos.</div>
				<div>Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</div>
			</v-sheet>
		</section>
		<section>
			<v-sheet height="400" color="blue" class="pa-4">
				<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, nostrum.</div>
				<div>Asperiores quia harum perspiciatis cum eos.</div>
				<div>Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</div>
			</v-sheet>
		</section>
		<section>
			<v-sheet height="400" color="indigo" class="pa-4">
				<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, nostrum.</div>
				<div>Asperiores quia harum perspiciatis cum eos.</div>
				<div>Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</div>
			</v-sheet>
		</section>
		<section>
			<v-sheet height="400" color="purple" class="pa-4">
				<div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, nostrum.</div>
				<div>Asperiores quia harum perspiciatis cum eos.</div>
				<div>Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</div>
			</v-sheet>
		</section>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
import CustomCarousel from '@src/components/CustomCarousel.vue';
import BaseClient from '../client';
export default {
	components: {
		CustomCarousel,
	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
			banners: [],
		}
	},
	created(){
		this.fetchPageData()
	},
	methods: {
		fetchPageData(){
			BaseClient.getHomePage().then((res) => {
				const result = res.data.data
				this.banners = result.banners;
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},

	},
};
</script>