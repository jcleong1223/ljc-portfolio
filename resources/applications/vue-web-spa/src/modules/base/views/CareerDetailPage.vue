<template>
	<v-sheet color="transparent" class="fill-height">
		<section :class="$vuetify.breakpoint.smAndDown ? 'mt-16 py-2' : 'mt-16 pt-13 pb-2'">
			<v-container>
				<v-row :class="$vuetify.breakpoint.smAndDown ? 'justify-center pt-8' : 'justify-space-between'">
					<div :class="$vuetify.breakpoint.smAndDown ? 'font-weight-bold text-h4 font-family-libre-baskerville' : 'text-h5 mb-2 text-md-h4 font-family-libre-baskerville font-weight-bold'">Job Details</div>
					<div
						class="align-self-center text-decoration-underline back_effect"
						:style="$vuetify.breakpoint.smAndDown ? 'display: none' : 'color: #DAA520;'"
					>
						<router-link :to="{ name: 'careers' }" class="text-color-unset">
							<h3>
								<v-icon color="#DAA520" size="x-large" class="text-end">
									mdi-arrow-left
								</v-icon>Back
							</h3>
						</router-link>
					</div>
				</v-row>
			</v-container>
		</section>


		<section class="my-0 py-0">
			<v-container :class="$vuetify.breakpoint.smAndDown ? 'pa-6' : 'pa-0'">
				<v-card
					:class="$vuetify.breakpoint.smAndDown ? 'px-8' : 'elevation-3 my-8 px-12'"
				>
					<v-row :class="$vuetify.breakpoint.smAndDown ? 'd-block' : ''">
						<v-col :class="$vuetify.breakpoint.smAndDown ? 'pa-0 pt-3' : ''">
							<div :class="$vuetify.breakpoint.smAndDown ? 'justify-left mb-0' : 'text-center text-md-justify mx-auto mb-13'">
								<div class="my-6 font-family-libre-baskerville"><h2>{{ career.career_detail.title }}</h2></div>
								<div class="my-6"><h4 class="font-weight-regular"><v-icon color="#000000" class="mb-1 mr-3">mdi-map-marker</v-icon>{{ career.career_detail.location }}</h4></div>
								<div class="my-6"><h4 class="font-weight-regular"><v-icon color="#000000" class="mb-1 mr-3">mdi-cash-usd</v-icon>{{ career.career_detail.salary_range }}</h4></div>
							</div>
						</v-col>
						<v-col :class="$vuetify.breakpoint.smAndDown ? 'pa-0 pb-5' : ''">
							<div class="text-md-justify mx-auto">
								<div class="my-6">
									<h4 :class="$vuetify.breakpoint.smAndDown ? 'text-left align-self-start' : 'text-right'" style="color: #DAA520; font-weight: 500">
										<v-icon color="#DAA520" class="mb-1">mdi-clock</v-icon> {{ career.career_detail.type }}
									</h4>
								</div>
							</div>
						</v-col>
					</v-row>
					<v-divider :thickness="4" color="black" width="100%"></v-divider>
					<div :class="$vuetify.breakpoint.smAndDown ? 'mt-3 mb-8' : 'text-md-justify mx-auto my-15'">
						<div class="font-weight-black my-6"><h3>Main Responsibilities</h3></div>
						<div style="line-height:45px" v-html="career.career_detail.description">
							<!-- <ol :class="$vuetify.breakpoint.smAndDown ? 'text-justify' : ''">
								<li class="mb-3">Asperiores quia harum perspiciatis cum eos.Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</li>
								<li class="mb-3">Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</li>
								<li class="mb-3">Asperiores quia harum. Asperiores quia harum perspiciatis cum eos. Perspiciatis cum eos.</li>
								<li class="mb-3">Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</li>
								<li class="mb-3">Asperiores quia harum perspiciatis cum eos.Vitae reiciendis voluptatum amet cumque, architecto esse nobis doloremque blanditiis quia, ducimus ea a.</li>
								<li class="mb-3">Asperiores quia harum. Asperiores quia harum perspiciatis cum eos. Perspiciatis cum eos.</li>
							</ol> -->
						</div>
					</div>
					<v-divider :thickness="4" color="black" width="100%"></v-divider>
					<div class="text-md-justify mx-auto my-15">
						<div class="font-weight-black my-6"><h3>Additional info</h3></div>
						<v-row class="d-flex justify-space-between mx-0">
							<div class="my-6">
								<h3 class="font-weight-black mb-3">Career Level</h3>
								<p>{{ career.career_detail.career_level }}</p>
							</div>
							<div class="my-6">
								<h3 class="font-weight-black mb-3">Year of Experience</h3>
								<p>{{ career.career_detail.exp_required }} year(s)</p>
							</div>
							<div class="my-6">
								<h3 class="font-weight-black mb-3">Job Type</h3>
								<p>{{ career.career_detail.type }}</p>
							</div>
							<div class="my-6">
								<h3 class="font-weight-black mb-3">Job Specializations</h3>
								<p>{{ career.career_detail.specializations }}</p>
							</div>
							<div class="my-6">
								<h3 class="font-weight-black mb-3">Qualification</h3>
								<ul style="list-style-type: none; padding: 0; margin: 0;">
									<li class="mb-3">{{ career.career_detail.qualifications }}</li>
								</ul>
							</div>
						</v-row>
					</div>
				</v-card>
			</v-container>
		</section>

		<section>
			<v-container class="pa-0" data-aos="zoom-in-up" data-aos-duration="2000">
				<v-sheet color="#000000" class="py-4 card_effect">
					<v-container :class="$vuetify.breakpoint.smAndDown ? 'justify-start px-7' : 'justify-start'">
						<div :class="$vuetify.breakpoint.smAndDown ? 'white--text mx-auto' : 'px-4 px-md-16 white--text'">
							<div :class="$vuetify.breakpoint.smAndDown ? 'text-h5 mb-8 mt-3 font-family-libre-baskerville font-weight-bold' : 'text-h5 my-8 text-md-h4 font-family-libre-baskerville font-weight-bold'">Fill Up Your Details</div>
							<div class="contactForm">
								<form>
									<!-- <input v-model="careerId" type="hidden" name="career_id"> -->
									<v-row :class="$vuetify.breakpoint.smAndDown ? 'd-block' : 'pt-2 ma-0 white--text'">
										<v-col :class="$vuetify.breakpoint.smAndDown ? 'pl-3 pb-0' : 'pa-0 pr-7'" :cols="$vuetify.breakpoint.smAndDown ? '12' :'6'">
											<span>Your Name</span>
											<v-text-field
												v-model="form.name"
												solo
												placeholder="Your Name"
												dense
												class="py-2"
												:error-messages="error.name"
											></v-text-field>

											<span>Position Applied</span>
											<v-select
												v-model="form.position_applied"
												solo
												:placeholder="career.career_detail.title"
												dense
												:items="position_applied"
												class="py-2"
												:error-messages="error.position_applied"
											></v-select>
											<!-- <v-text-field
												v-model="form.position_applied"
												:value="career.career_detail.title"
												solo
												:placeholder="career.career_detail.title"
												dense
												class="py-2"
												:error-messages="error.position_applied"
												readonly
											></v-text-field> -->

											<span v-if="!$vuetify.breakpoint.smAndDown">Resume</span>
											<v-file-input
												v-if="!$vuetify.breakpoint.smAndDown"
												v-model="form.resumeFile" label="Upload your resume in pdf format" class="mx-0 py-2"
												solo dense placeholder="Upload your resume in pdf format"
												accept=".pdf"
												variant="solo-inverted"
												prepend-icon=""
												:error-messages="error.resumeFile"
											>
											</v-file-input>
										</v-col>
										<v-col :class="$vuetify.breakpoint.smAndDown ? 'pl-3 pt-0' : 'pa-0 pl-7'" :cols="$vuetify.breakpoint.smAndDown ? '12' :'6'">
											<span>Email</span>
											<v-text-field
												v-model="form.email"
												solo
												placeholder="Email"
												dense
												class="py-2"
												:error-messages="error.email"
											></v-text-field>
											<span>Phone Number</span>
											<v-text-field
												v-model="form.phone"
												solo
												placeholder="Phone Number"
												dense
												class="py-2"
												:error-messages="error.phone"
											></v-text-field>
											<span v-if="!$vuetify.breakpoint.mdAndUp">Resume</span>
											<v-file-input
												v-if="!$vuetify.breakpoint.mdAndUp"
												v-model="form.resumeFile" label="Upload your resume in pdf format" class="mx-0 py-2"
												solo dense placeholder="Upload your resume in pdf format"
												variant="solo-inverted"
												prepend-icon=""
												:error-messages="error.resumeFile"
											>
											</v-file-input>
										</v-col>
									</v-row>
									<div class="d-flex justify-end">
										<span
											class="text-decoration-underline text-h6 apply_effect"
											style="cursor: pointer; color:#DAA520;"
											:loading="loading"
											@click="submitForm(form)"
										>Apply Now
											<!-- <v-icon color="#DAA520">mdi-arrow-right</v-icon> -->
										</span>
									</div>
								</form>
							</div>
						</div>
					</v-container>
				</v-sheet>
			</v-container>
		</section>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
import BaseClient from '../client';
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
				// position_applied: '',
			},
			career: null,
			loading: false,
			careerId: '',
			// careers: [
			// 	{
			// 		careerTitle: 'Mechanical Engineer',
			// 		careerLocation: 'Petaling Jaya',
			// 		salary: "MYR 5000 - MYR 8000",
			// 		careerType: 'Full time',
			// 	},
			// ],
			// careersWithId: [],
			position_applied: [],
			error: {},
		};
	},
	created(){
		this.careerId = this.$route.params.id;
		this.getCareerDetail();
		this.position_applied = this.career.career_detail.title;
		// this.form.position_applied = this.career.career_detail.title;
	},
	mounted(){
		// this.initRecaptcha();
		this.getCareerListing();
		console.log(this.$route.params);

	},
	methods: {
		getCareerListing()
		{
			BaseClient.getCareersPage().then(res =>{
				console.log(res.data);
				const { data } = res.data;
				this.careers = data.careers.map(data => {
					return{
						id: data.id,
						careerTitle: data.title,
						careerLocation : data.location,
						salary: data.salary_range,
						careerType: data.type
					}
				});

				this.position_applied = this.careers.map((career) => career.careerTitle);

			}).catch(err =>{
				console.log(err);
			})
		},
		getCareerDetail()
		{
			BaseClient.getCareerDetails(this.careerId).then(res => {
				this.career = res.data.data;
				this.form.position_applied = this.career.career_detail.title;
			}).catch(err => {
				console.log(err);
			})
		},
		// async initRecaptcha(){
		// 	await this.$recaptchaLoaded()
		// },
		async submitForm(item){
			//Execute reCAPTCHA with action "submit".
			// const token = await this.$recaptcha('submit')
			// this.form.recaptcha = token
			this.submitData(item);
		},
		submitData(item){
			// let payload = item

			let payload = {
				...item,
				careerId: this.$route.params.id,
				// position_applied: this.career.career_detail.title,
			};
			this.loading = true;
			this.error = {}

			BaseClient.submitResume(payload).then((res) => {

				this.$toast.success("Successfully submitted");
				this.loading = false;
				this.form.name = '';
				this.form.position_applied = '';
				this.form.email = '';
				this.form.phone = '';
				this.form.resumeFile = '';
			}).catch((err) => {
				this.error = this.errorHandler_(err, [
					'name',
					'position_applied',
					'email',
					'phone',
					'resumeFile',
				])
			}).finally(()=>{
				this.loading = false;
			})
		},

	},
};
</script>

<style>

.back_effect:hover
{
	transform: translateX(-10%);
	transition: 0.5s;
}

.apply_effect:hover
{
	transform: translateX(10%);
	transition: 0.5s;
}

.card_effect:hover
{
	box-shadow: 0px 0px 5px 5px rgba(218,165,32,0.75);
	transition: 0.5s;
}

</style>
