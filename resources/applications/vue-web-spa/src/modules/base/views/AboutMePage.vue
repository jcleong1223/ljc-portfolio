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
			<v-container
				class="justify-center px-0 mt-5"
			>
				<v-row
					class="fill-width mx-auto"
					justify-md="start"
					justify="center"
				>
					<v-col
						md="5"
						cols="12"
						style="background-color:transparent"
					>
					<div class="card-effect" id="card">
						<div class="content">
							<div class="d-block">
								<img src="/images/profileimg_placeholder.png" width="100%" class="text-center mb-10 rounded-md"/>
								<h2 class="font-poppins font-weight-medium black--text">Full Stack Developer </h2>
							</div>
						</div>
					</div>
					</v-col>
					<v-col
						md="7"
						cols="12"
						style="background-color:transparent"
					>
						
					</v-col>
				</v-row>
			</v-container>

			<div class="container">
				<div class="card">
					<div class="face back">
						<div class="content">
							<span class="stars"></span>
							<b class="desc">Hello</b>
							<p class="desc">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							</p>
						</div>
					</div>
					<div class="face front">
						<b>Hover</b>
					</div>
				</div>
			</div>


			<div class="myCard">
				<div class="innerCard">
					<div class="frontSide">
						<p class="title">FRONT SIDE</p>
						<p>Hover Me</p>
					</div>
					<div class="backSide">
						<p class="title">BACK SIDE</p>
						<p>Leave Me</p>
					</div>
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


.card-effect {
	width: 75%;
	height: 100%;
	background: #ffffff;
	display: flex;
	justify-content: center;
	align-items: center;
	box-shadow: 0px 0px 3px 1px #00000088;
	overflow: hidden;
	position: relative;
	border-radius: 8px;
	rotate: -3deg;
}

.card-effect .content {
	border-radius: 15px;
	background: #ffffff;
	width: 96%;
	height: 96%;
	z-index: 1;
	padding: 20px 15px;
	color: white;
	display: flex;
	justify-content: center;
	align-items: center;
}
/* Information card style and effect */



.container {
  margin: 0 auto;
}

.card {
  position: relative;
  width: 200px;
  height: 300px;
  margin: 0 auto;
  background: #000;
  border-radius: 15px;
  box-shadow: 0 15px 60px rgba(0, 0, 0, 0.5);
}

.face {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.face.back {
  box-sizing: border-box;
  padding: 20px;
}

.face.back b {
  margin: 0;
  padding: 0;
}

.face.back .desc {
  background-color: #eee;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.face.front {
  transition: 0.5s;
}

.face.front b {
  margin: 0;
  padding: 0;
  font-size: 5.1em;
  color: #fff;
  transition: 0.5s;
  text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  z-index: 10;
}

.card:hover .face.front {
  height: 60px;
}

.card:hover .face.front b {
  font-size: 2em;
}

.face.front {
  background-color: #0cbaba;
  border-radius: 15px;
}





.myCard {
  background-color: transparent;
  width: 190px;
  height: 254px;
  perspective: 1000px;
}

.title {
  font-size: 1.5em;
  font-weight: 900;
  text-align: center;
  margin: 0;
}

.innerCard {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.8s;
  transform-style: preserve-3d;
  cursor: pointer;
}

.myCard:hover .innerCard {
  transform: rotateY(180deg);
}

.frontSide,
.backSide {
  position: absolute;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-evenly;
  width: 100%;
  height: 100%;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  border: 1px solid rgba(255, 255, 255, 0.8);
  border-radius: 1rem;
  color: white;
  box-shadow: 0 0 0.3em rgba(255, 255, 255, 0.5);
  font-weight: 700;
}

.frontSide,
.frontSide::before {
  background: linear-gradient(43deg, rgb(65, 88, 208) 0%, rgb(200, 80, 192) 46%, rgb(255, 204, 112) 100%);
}

.backSide,
.backSide::before {
  background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);
}

.backSide {
  transform: rotateY(180deg);
}

.frontSide::before,
.backSide::before {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  content: '';
  width: 110%;
  height: 110%;
  position: absolute;
  z-index: -1;
  border-radius: 1em;
  filter: blur(20px);
  animation: animate 5s linear infinite;
}

@keyframes animate {
  0% {
    opacity: 0.3;
  }

  80% {
    opacity: 1;
  }

  100% {
    opacity: 0.3;
  }
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


</style>