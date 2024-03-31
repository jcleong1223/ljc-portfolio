<template>
	<v-sheet
		color="transparent"
		class="fill-height"
	>
		<v-sheet
			:height="$vuetify.breakpoint.mdAndUp ? '500' : '650'"
			color="transparent"
			class="ml-md-10 mt-15"
		>
			<span
				class="font-poppins text-h3 pl-md-0"
				style="color: #66FCD1; text-shadow: 3px 1px 15px rgba(60,228,233,0.6); font-weight: 900;"
			>
				<b>Contact with me now !!</b>
			</span>
			<!-- </v-row> -->
			
			<v-container
				class="justify-center px-0 mt-5"
			>
				<v-row
					class="fill-width mx-auto"
					justify-md="start"
					justify="center"
				>
					<v-col
						md="12"
						cols="12"
						style="background-color:transparent"
					>
						<v-sheet color="transparent">
							<v-row class="mx-auto pa-0 justify-center">
								<v-card
									eager
									class=""
									rounded="5"
									style="height:550px; width:50%; border-radius: 50px;background: #EDF2F7;"
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

													class="pa-2 input_special_inner_bow_shadow"
													solo
													placeholder="Name"
													dense
												>
											</v-col>
											<v-col class="py-1" cols="6">
												<input

													class="pa-2 input_special_inner_bow_shadow"
													solo
													placeholder="Phone Number"
													dense
												>
											</v-col>
											<v-col class="pb-0" cols="12">Email</v-col>
											<v-col class="py-1" cols="12">
												<input

													solo
													class="pa-2 input_special_inner_bow_shadow"
													placeholder="you@company.com"
													dense
												>
											</v-col>
											<v-col class="pb-0" cols="12">Message</v-col>
											<v-col class="pt-1" cols="12">
												<textarea

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
									style="height:550px; width:30%; border-radius: 50px;background: #EDF2F7;"
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
					</v-col>
				</v-row>
			</v-container>
		</v-sheet>
	</v-sheet>
</template>

<script>

export default {
	components: {},

	data() {
		return {

			// currencyFormat: '',
		};
	},
	computed: {

	},
	created() {
		//
	},
	methods: {
		async submitForm(item){

			// const token = await this.$recaptcha('submit')
			// this.form.recaptcha = token

			this.submitContactInfo(item);
		},
	},
};
</script>

<style>

.customized_card {
	width: 100%;
	height: 100%;
	background-image: linear-gradient(123deg, #3cf5e9 0%, #0d30f8 100%);
	border-radius: 20px;
	transition: all .3s;
}

.customized_card2 {
 	width: 100%;
	height: 100%;
 	background-color: #000000;
 	border-radius:20px;
 	transition: all .2s;
}

.customized_card2:hover {
 	transform: scale(0.96);
 	border-radius: 20px;
}

.customized_card:hover {
	box-shadow: 0px 0px 50px 0px rgba(57,213,207,0.5) !important;
}

</style>