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
				class="font-poppins text-h3 pl-md-0 title-style"
			>
				<b>Contact with me now !!</b>
			</span>
			<input 
				class="togglesw" 
				type="checkbox"
				@click="offLight"
			>
			<!-- </v-row> -->
			<v-container
				class="justify-center px-0 mt-5"
			>
				<v-row
					class="fill-width mx-auto my-10"
					justify-md="start"
					justify="center"
				>
					<v-col
						md="7"
						cols="12"
						style="background-color:transparent"
					>
						<v-sheet color="transparent">
							<v-row class="pa-0 justify-center">
								<v-card
									eager
									class=""
									rounded="5"
									style="height:550px; width:100%; border-radius: 50px;background: rgb(22,44,52);background: linear-gradient(135deg, rgba(22,44,52,1) 0%, rgba(29,57,68,1) 100%);"
								>
									<v-card-text
										class="white--text text-center text-justify pa-8 font-family-inter font-size-text d-flex align-center"
									>
										<v-row class="pt-2 ma-0 white--text">
											<v-col class="pb-0" cols="6">
												Your Name
											</v-col>
											<v-col class="pb-0" cols="6">
												Phone Number
											</v-col>
											<v-col class="py-1" cols="6">
												<input
													type="text"
													name="name"
													class="input-style"
													placeholder="Name"
													autocomplete="off"
												>
											</v-col>
											<v-col class="py-1" cols="6">
												<input
													type="text"
													name="phone_number"
													class="input-style"
													placeholder="Phone Number"
													autocomplete="off"
												>
											</v-col>
											<v-col class="pb-0" cols="12">Email</v-col>
											<v-col class="py-1" cols="12">
												<input
													type="email"
													name="email"
													class="input-style"
													placeholder="Email"
													autocomplete="off"
												>
											</v-col>
											<v-col class="pb-0" cols="12">Message</v-col>
											<v-col class="pt-1" cols="12">
												<textarea
													name="message"
													class="input-style"
													placeholder="Leave Leong a message"
												></textarea>
											</v-col>
											<button 
												class="ml-4"
											>
												<span>Send</span>
												<div class="top"></div>
												<div class="left"></div>
												<div class="bottom"></div>
												<div class="right"></div>
											</button>
										</v-row>
									</v-card-text>
								</v-card>
							</v-row>
						</v-sheet>
					</v-col>
					<v-col
						md="5"
						cols="12"
						style="background-color:transparent"
					>
					<div class="card-effect ml-n10" id="card">
						<div class="content">
							<div class="d-block">
								<img src="/images/contactus/contactme.jpg" width="100%" class="text-center mb-10 rounded-xl"/>
								<h2 class="font-poppins font-weight-medium ">Full Stack Developer </h2>
								<span>
									I am available for freelance work. Contact with me now !!<br>Email: leongjc1223@gmail.com<br>Phone: leongjc1223@gmail.com
								</span>
							</div>
						</div>
					</div>
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

		offLight(){
			console.log('dd');
			this.$el.querySelector(".title-style").style.animation = "none";
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


.card-effect {
	width: 100%;
	height: 100%;
	background: #171717;
	display: flex;
	justify-content: center;
	align-items: center;
	box-shadow: 0px 0px 3px 1px #00000088;
	overflow: hidden;
	position: relative;
	border-radius: 25px;
}

.card-effect .content {
	border-radius: 25px;
	background: #171717;
	width: 96%;
	height: 96%;
	z-index: 1;
	padding: 20px;
	color: white;
	display: flex;
	justify-content: center;
	align-items: center;
}

.card-effect:hover{
	scale: 1.05;
  	rotate: 3deg;
	transition: 0.8s;
	box-shadow: 0px 0px 45px -5px rgba(81,255,105,0.75);
}

.content::before {
	opacity: 0;
	transition: opacity 500ms;
	content: " ";
	display: block;
	width: 100%;
	height: 100%;
	position: absolute;
	filter: blur(150px);
}

.card-effect:hover .content::before {
	opacity: 1;

}

.card-effect::before {
	opacity: 0;
	content: " ";
	position: absolute;
	display: block;
	width: 115%;
	height: 115%;
	background: linear-gradient(
		100deg,
		#064cfc,
		#00ff73,
		#4cb5ff,
		#5dff12
	);
	transition: opacity 500ms;
	animation: rotation_9018 5000ms infinite linear;
	animation-play-state: paused;
}

.card-effect:hover::before {
	opacity: 1;
	animation-play-state: running;

}

.card-effect::after {
	position: absolute;
	content: " ";
	display: block;
	width: 100%;
	height: 105%;
	background: #01010100;
	backdrop-filter: blur(50px);
}

@keyframes rotation_9018 {
	0% {
		transform: rotate(0deg);
	}

	50% {
		transform: rotate(180deg);
	}

	100% {
		transform: rotate(360deg);
	}
}
/* Information card style and effect */


/* Input styling and effect */
.input-style {
	width: 100%;
	border-radius: 5px;
	outline: none;
	border: 1px solid #303030;
	border-bottom: 2px solid #9a9a9a;
	padding-left: 10px;
	padding-right: 10px;
	background-color: #1e1e1e;
	color: white;
	transition: all 0.3s ease;
}

.input-style::placeholder {
	color: #9a9a9a;
}

.input-style:hover {
	background-color: #373737;
}

.input-style:active,
.input-style:focus {
	background-color: #19202d;
	border: 1px solid #312f2f;
	border-bottom: 2px solid #35F4AE;
}
/* Input styling and effect */


/* Submit button effect */
button {
	padding: 0px 30px;
	background-color: #121212;
	border: none;
	font-size: 13px;
	position: relative;
	border-radius: 10px;
	transition: 500ms;
}

button span {
	color: gray;
	position: relative;
	transition: 500ms;
	transition-delay: 500ms;
	font-size: 16px;
	text-transform: uppercase;
	letter-spacing: 2px;
	font-weight: 600;
}

button:before {
	content: '';
	position: absolute;
	width: 0%;
	height: 0%;
	left: 50%;
	right: 50%;
	top: 50%;
	bottom: 50%;
	transition: 500ms;
	transition-delay: 500ms;
	background-color: transparent;
	box-shadow: 0 0 10px rgb(53, 244, 174),
	0 0 30px rgb(53, 244, 174), 
	0 0 50px rgb(53, 244, 174);
}

button div {
	border-radius: 15px;
  	transition: 500ms;
  	position: absolute;
  	background-color: rgb(53, 244, 174);
  	box-shadow: 0 0 15px rgb(53, 244, 174), 0 0 30px rgb(53, 244, 174), 0 0 50px rgb(53, 244, 174);
}

button .top {
	width: 15px;
	height: 2px;
	top: 0;
	left: 0;
}

button .bottom {
	width: 15px;
	height: 2px;
	bottom: 0;
	right: 0;
}

button .left {
	width: 2px;
	height: 15px;
	top: 0;
	left: 0;
}

button .right {
	width: 2px;
	height: 15px;
	bottom: 0;
	right: 0;
}


button:hover .top, 
button:hover .bottom {
	width: 100%;
}

button:hover .left,
button:hover .right {
	height: 100%;
}
/* Submit button effect */



</style>