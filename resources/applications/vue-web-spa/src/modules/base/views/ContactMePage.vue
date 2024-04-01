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
				style="color: #66FCD1; text-shadow: 3px 1px 12px rgba(60,228,233,0.6); font-weight: 900;"
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
									style="height:550px; width:30%; border-radius: 50px;"
								>
									<div class="custom-card">
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
									</div>
								</v-card>
							</v-row>
						</v-sheet>
					</v-col>
				</v-row>
			</v-container>

			<div class="card"></div>

			<div class="card1">
				<div class="card-info">
					<p class="title">Magic Card</p>
				</div>
			</div>


			<div class="card2" id="card">
			<div class="content">
				<span>HOVER ME</span>
			</div>
			</div>
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

.card {
  position: relative;
  width: 190px;
  height: 254px;
  background: rgb(255, 0, 179);
  background: linear-gradient(137deg, rgb(255, 0, 179) 0%, rgba(0,212,255,1) 100%);
  transition: 0.3s ease;
  border-radius: 30px;
}

.card::after {
  content: '';
  background-color: #181818;
  position: absolute;
  z-index: 1;
  transition: 0.3s ease;
  height: 98%;
  width: 98%;
  top: 1%;
  left: 1%;
  border-radius: 28px;
}


.card:hover {
  filter: drop-shadow(0px 0px 30px rgba(209, 38, 197, 1));
}





.card1 {
 --background: linear-gradient(to left, #f7ba2b 0%, #ea5358 100%);
 width: 190px;
 height: 254px;
 padding: 5px;
 border-radius: 1rem;
 overflow: visible;
 background: #f7ba2b;
 background: var(--background);
 position: relative;
 z-index: 1;
}

.card1::after {
 position: absolute;
 content: "";
 top: 30px;
 left: 0;
 right: 0;
 z-index: -1;
 height: 100%;
 width: 100%;
 transform: scale(0.8);
 filter: blur(25px);
 background: #f7ba2b;
 background: var(--background);
 transition: opacity .5s;
}

.card1-info {
 --color: #181818;
 background: var(--color);
 color: var(--color);
 display: flex;
 justify-content: center;
 align-items: center;
 width: 100%;
 height: 100%;
 overflow: visible;
 border-radius: .7rem;
}

.card1 .title {
 font-weight: bold;
 letter-spacing: .1em;
}

/*Hover*/
.card1:hover::after {
 opacity: 0;
}

.card1:hover .card-info {
 color: #f7ba2b;
 transition: color 1s;
}









.card2 {
  width: 190px;
  height: 254px;
  background: #171717;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0px 0px 3px 1px #00000088;
  cursor: pointer;
  overflow: hidden;
  position: relative;
}

.card2 .content {
  border-radius: 5px;
  background: #171717;
  width: 186px;
  height: 250px;
  z-index: 1;
  padding: 20px;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
}

.content::before {
  opacity: 0;
  transition: opacity 300ms;
  content: " ";
  display: block;
  background: white;
  width: 50px;
  height: 50px;
  position: absolute;
  filter: blur(50px);
}

.card2:hover .content::before {
  opacity: 1;
}

.card2::before {
  opacity: 0;
  content: " ";
  position: absolute;
  display: block;
  width: 120px;
  height: 360px;
  background: linear-gradient(
    90deg,
    transparent,
    #ff2288,
    #387ef0,
    transparent
  );
  transition: opacity 300ms;
  animation: rotation_9018 3000ms infinite linear;
  animation-play-state: paused;
}

.card2:hover::before {
  opacity: 1;
  animation-play-state: running;
}

.card2::after {
  position: absolute;
  content: " ";
  display: block;
  width: 190px;
  height: 254px;
  background: #17171733;
  backdrop-filter: blur(50px);
}

@keyframes rotation_9018 {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}



</style>