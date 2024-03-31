<template>
	<v-sheet color="transparent" class="fill-height">
		<section class="pt-15 px-8">
			<v-sheet v-if="$vuetify.breakpoint.mdAndUp" color="black" class="mx-16 my-16">
				<v-row class="ma-0 white--text">
					<v-col
						cols="12" md="6" sm="12"
						xs="12"
						class="mx-auto px-16"
					>
						<div class="text-h5 my-8 text-md-h4 font-barlow">Contact Us</div>
						<v-text-field
							v-model="form.name"
							solo
							placeholder="Your Name"
							dense
							:error-messages="errors.name"
						></v-text-field>
						<v-text-field
							v-model="form.email"
							class="mt-3"
							solo
							placeholder="Email"
							dense
							:error-messages="errors.email"
						></v-text-field>
						<v-text-field
							v-model="form.phone"
							class="mt-3"
							solo
							placeholder="Phone Number"
							dense
							:error-messages="errors.phone"
						></v-text-field>
						<v-text-field
							v-model="form.subject"
							class="mt-3"
							solo
							placeholder="Subject"
							dense
							:error-messages="errors.subject"
						></v-text-field>
						<v-textarea
							v-model="form.message"
							class="mt-3"
							solo
							placeholder="Message..."
							dense
							style="resize: none !important;"
							:error-messages="errors.message"
						></v-textarea>
						<div class="font-weight-bold mt-5 submitNow_effect">
							<span
								class="text-decoration-underline text-h6"
								style="cursor: pointer; color:#DAA520"
								:loading="loading"
								@click="submitForm(form)"
							>Submit Now
							</span>
						</div>
					</v-col>
					<v-col
						cols="12" md="6" class="pa-0 ma-0"
					>
						<v-img
							src="/images/asset/contactus1.png"
							eager
						>
						</v-img>
					</v-col>
				</v-row>
			</v-sheet>
			<v-sheet v-else color="black" class="my-8">
				<v-row class="ma-0 white--text">
					<v-col
						cols="12" md="6" class="pa-0 ma-0"
					>
						<v-img
							src="/images/asset/contactus1.png"
							eager
						>
						</v-img>
					</v-col>
					<v-col
						cols="12" md="6" sm="12"
						xs="12"
						class="mx-auto px-8"
					>
						<div class="text-h5 my-8 text-md-h4 font-barlow">Contact Us</div>
						<v-text-field
							v-model="form.name"
							solo
							placeholder="Your Name"
							dense
							:error-messages="errors.name"
						></v-text-field>
						<v-text-field
							v-model="form.email"
							class="mt-3"
							solo
							placeholder="Email"
							dense
							:error-messages="errors.email"
						></v-text-field>
						<v-text-field
							v-model="form.phone"
							class="mt-3"
							solo
							placeholder="Phone Number"
							dense
							:error-messages="errors.phone"
						></v-text-field>
						<v-text-field
							v-model="form.subject"
							class="mt-3"
							solo
							placeholder="Subject"
							dense
							:error-messages="errors.subject"
						></v-text-field>
						<v-textarea
							v-model="form.message"
							class="mt-3"
							solo
							placeholder="Message..."
							dense
							style="resize: none !important;"
							:error-messages="errors.message"
						></v-textarea>
						<div class="font-weight-bold my-5 submitNow_effect">
							<span
								class="text-decoration-underline text-h6"
								style="cursor: pointer; color:#DAA520"
								:loading="loading"
								@click="submitForm(form)"
							>Submit Now
							</span>
						</div>
					</v-col>
				</v-row>
			</v-sheet>
		</section>

		<section>
			<v-row :class="$vuetify.breakpoint.smAndDown ? 'd-block' : 'justify-space-around my-16'" data-aos="fade-up" data-aos-duration="1500">
				<v-card
					color="#000000"
					:class="$vuetify.breakpoint.smAndDown ? 'mx-10 mb-10 elevation-0' : 'ml-16 white--text elevation-0'"
					:style="$vuetify.breakpoint.smAndDown ? 'width:80%; border-radius: 0px;' : 'width:40%; border-radius: 0px; box-shadow: none'"
				>
					<v-img
						class="mx-0" eager width="100%"
						height="300px" style="align-self: center"
						src="/images/contactus/contactUsBg_desktop.png"
					></v-img>
					<div data-aos="fade-right" data-aos-duration="1500">
						<v-card-title :class="$vuetify.breakpoint.smAndDown ? 'ml-3 white--text font-barlow' : 'pl-16 py-8 text-h4 white--text font-barlow'">
							Contact Details
						</v-card-title>
						<v-card-text :class="$vuetify.breakpoint.smAndDown ? 'pa-0 ' : 'pl-16'">
							<div :class="$vuetify.breakpoint.smAndDown ? 'ml-8 my-3 d-flex justify-left' : 'd-flex mb-5 justify-center justify-md-start'">
								<v-icon :size="$vuetify.breakpoint.mdAndUp?'20':'25'" color="white">mdi-phone</v-icon>
								<div class="ml-2 text-caption white--text">03-3279 2899</div>
							</div>
							<div :class="$vuetify.breakpoint.smAndDown ? 'ml-8 my-3 d-flex justify-left' : 'd-flex mb-5 justify-center justify-md-start'">
								<v-icon :size="$vuetify.breakpoint.mdAndUp?'20':'25'" color="white">mdi-email</v-icon>
								<div class="ml-2 text-caption white--text">K.P.LooEngineering@gmail.com</div>
							</div>
						</v-card-text>
						<div :class="$vuetify.breakpoint.smAndDown ? 'ml-8 py-5' : 'pl-16 d-flex justify-start'">
							<v-btn
								fab depressed x-small
								color="transparent"
								href=" https://www.instagram.com/#/"
								target="_blank"
								class="mr-5"
							>
								<v-icon large color="white">mdi-instagram</v-icon>
							</v-btn>
							<v-btn
								fab depressed x-small
								color="transparent"
								href=" https://www.facebook.com/#/"
								target="_blank"
							>
								<v-icon large color="white rounded-circle">mdi-facebook</v-icon>
							</v-btn>
						</div>
					</div>
				</v-card>

				<v-card
					color="#000000" class="mr-16 white--text elevation-5"
					:class="$vuetify.breakpoint.smAndDown ? 'mx-10 elevation-0' : 'mr-16 white--text elevation-0'"
					:style="$vuetify.breakpoint.smAndDown ? 'width:80%; border-radius: 0px' : 'width:40%; border-radius: 0px'"
				>
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.176413134888!2d101.4128267748861!3d3.306493996668358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc487e05883449%3A0xacafc3d68dc06d96!2sK.P.%20Loo%20Engineering%20Sdn%20Bhd!5e0!3m2!1sen!2smy!4v1682412481757!5m2!1sen!2smy" width="100%" height="300px"
						style="border:0;" allowfullscreen="" loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
					></iframe>
					<div data-aos="fade-left" data-aos-duration="1500">
						<v-card-title :class="$vuetify.breakpoint.smAndDown ? 'ml-3 white--text font-barlow' : 'pl-16 py-7 text-h4 font-barlow'">
							Address Details
						</v-card-title>
						<v-card-text :class="$vuetify.breakpoint.smAndDown ? 'pl-0' : 'pl-16 pb-10'">
							<div :class="$vuetify.breakpoint.smAndDown ? 'ml-8 my-3 d-flex justify-left' : 'd-flex mb-5 justify-center justify-md-start'">
								<v-icon class="align-self-start" :size="$vuetify.breakpoint.mdAndUp?'20':'25'" color="white">mdi-map-marker</v-icon>
								<div class="d-flex ml-2 text-caption white--text">LOT 752, 967, Jln Harmoni 1, Simpang Tiga Ijok, 45620 Bestari Jaya, Selangor</div>
							</div>
							<div :class="$vuetify.breakpoint.smAndDown ? 'd-flex ml-8 py-5' : 'pt-0 pb-12 d-flex justify-start'">
								<a target="blank" href="https://waze.com/ul/hw284gcbq1">
									<v-img
										class="map-link mr-3" style="max-width: 50px" src="images/contactus/wazeIcon.png"
									></v-img>
								</a>
								<a target="blank" href="https://www.google.com/maps/place/LOT+752,+K.P.+Loo+Engineering+Sdn+Bhd,+967,+Jln+Harmoni+1,+Simpang+Tiga+Ijok,+45620+Bestari+Jaya,+Selangor/@3.306494,101.4154017,13z/data=!4m6!3m5!1s0x31cc487e05883449:0xacafc3d68dc06d96!8m2!3d3.306494!4d101.4154017!16s%2Fg%2F1tfm8r45?hl=en-my ">
									<v-img class="map-link" style="max-width: 50px" src="images/contactus/gmapIcon.png"></v-img>
								</a>
							</div>
						</v-card-text>
					</div>
				</v-card>
			</v-row>
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
			form: {
				recaptcha: '',
			},
			loading: false,
			errors: {},
		};
	},
	created(){

	},
	mounted(){
		AOS.init();
		this.initRecaptcha();
	},
	methods: {
		async initRecaptcha(){
			await this.$recaptchaLoaded()
		},
		async submitForm(item){

			// const token = await this.$recaptcha('submit')
			// this.form.recaptcha = token

			this.submitContactInfo(item);
		},
		submitContactInfo(item){
			let payload = item
			this.loading = true;
			this.errors = {};

			BaseClient.submitContactUs(payload).then((res) => {
				this.$toast.success("Successfully submitted")
				this.loading = false;
				this.form.name = ''
				this.form.email = ''
				this.form.subject = ''
				this.form.phone = ''
				this.form.message = ''
			}).catch((err) => {
				this.errors = this.errorHandler_(err, [
					'name',
					'email',
					'message',
					'phone',
					'subject',
				])
			}).finally(()=>{
				this.loading = false;
			})
		}
	},
};
</script>

<style>

.map-link:hover
{
	transform: scale(110%);
	transition: 0.5s;
}

.submitNow_effect:hover
{
	transform: translateX(4%);
	transition: 0.5s;
}


</style>
