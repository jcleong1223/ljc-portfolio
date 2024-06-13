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
			<div
				:class="$vuetify.breakpoint.mdAndUp ? '' : 'ml-8'"
			>
				<span
					class="font-poppins text-h3 pl-md-0 customize-text-color"
					style="text-shadow: 3px 1px 12px rgba(60,228,233,0.6); font-weight: 900;"
				>
					<b>The projects that I'm proud of</b>
				</span>
			</div>
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
						md="11"
						cols="12"
						style="background-color:transparent"
					>
						<v-sheet color="transparent">
							<v-col
								md="12"
								cols="12"
								class="mx-auto"
							>
								<v-row
									class="justify-md-start justify-center"
								>
									<v-col
										v-for="(project,i) in projects"
										:key="i"
										class="my-md-8 my-4"
										cols="12"
										sm="6"
										md="4"
									>
										<v-card
											:class="$vuetify.breakpoint.smAndDown ? 'mx-2 d-flex flex-column customized_card' :'mx-4 d-flex flex-column customized_card'"
											height="100%"
											eager
											rounded="xl"
											elevation="3"
											color="black"
										>
											<div class="customized_card2">
												<v-img
													max-height="200"
													:src="project.image.file_url"
													:aspect-ratio="1.22"
													eager
													cover
													style="border-radius: 20px;"
												></v-img>
												<v-card-title
													class="white--text font-barlow pl-7 font-size-subtitle"
												>
													{{ project.title }}
												</v-card-title>
												<v-divider color="white" class="my-0" style="width:90%"></v-divider>
												<v-card-text
													color="white"
													class="white--text pl-7 mb-auto text-justify font-family-inter font-size-text"
												>
													{{ project.short_description }} <br />
													<!-- <v-chip
														v-for="(tag,j) in project.tags"
														:key="j"
														class="mr-2 font-family-primary"
														color=""
														text-color="white"
													>
														{{ tag.title }}
													</v-chip> -->
													<button 
														v-for="(tag, j) in limitedTags(project.tags)"
														:key="j"
														class="chip-tag mr-3 my-2 font-family-primary"
													>
														{{ tag.title }}
													</button>
												</v-card-text>

												<v-card-actions class="my-1">
													<v-row align="center" class="justify-end mr-5">
														<router-link
															class="text-decoration-none text-color-unset pb-5"
															:to="{ name: 'project.detail', params: { id: project.id } }"
															plain
														>
															<!-- <v-row align="center" >
																<span class="text-gold font-family-inter text-decoration-underline font-size-subtitle mr-3">Learn More</span>
															</v-row> -->



															<button class="Btn ma-0">
																<div class="sign"><span class="mdi mdi-chevron-right"></span></div>
																<div class="text">Learn more</div>
															</button>
														</router-link>
													</v-row>
												</v-card-actions>
											</div>
										</v-card>
									</v-col>
								</v-row>
							</v-col>
						</v-sheet>
					</v-col>
				</v-row>
			</v-container>
		</v-sheet>
	</v-sheet>
</template>

<script>

import BaseClient from '../client'


export default {
	components: {},

	data() {
		return {
			projects: [],
			// currencyFormat: '',
		};
	},
	computed: {

	},
	created() {
		//
		this.fetchPageData()
	},
	methods: {

		fetchPageData(){
			BaseClient.getPortfolioProjectHomePage().then((res) => {
				const result = res.data.data;
				this.projects = result.projects;
			}).catch((err) => {
				this.errorHandler_(err);
			});
		},

		limitedTags(tags) {
		// Modify this limit as per your requirement
			const limit = 3;
			return tags.slice(0, limit);
		},

	},
};
</script>

<style scoped>

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

.customize-text-color {
	background: -webkit-linear-gradient(rgb(102, 252, 209), rgb(102, 147, 252));
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}


.chip-tag {
	--border-color: linear-gradient(-45deg, #f85231, #61159f, #1dc2e8);
	--border-width: 0.125em;
	--curve-size: 12px;
	--blur: 30px;
	--bg: #171717;
	--color: #ffffff;
	color: var(--color);
	cursor: default;
	/* use position: relative; so that BG is only for .chip-tag */
	position: relative;
	isolation: isolate;
	display: inline-grid;
	place-content: center;
	padding: 0px 16px;
	font-size: 15px;
	border: 0;
	box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
	clip-path: polygon(
	
	/* Top-left */ 0% var(--curve-size),
	var(--curve-size) 0,
	/* top-right */ 100% 0,
	100% calc(100% - var(--curve-size)),
	/* bottom-right 1 */ calc(100% - var(--curve-size)) 100%,
	/* bottom-right 2 */ 0 100%

	);
	transition: color 250ms;
	width: auto;
}

.chip-tag::after,
.chip-tag::before {
	content: "";
	position: absolute;
	inset: 0;
}

.chip-tag::before {
	background: var(--border-color);
	background-size: 300% 300%;
	z-index: -2;
}

.chip-tag::after {
	background: var(--bg);
	z-index: -1;
	clip-path: polygon(
	/* Top-left */ var(--border-width)
		calc(var(--curve-size) + var(--border-width) * 0.5),
	calc(var(--curve-size) + var(--border-width) * 0.5) var(--border-width),
	/* top-right */ calc(100% - var(--border-width)) var(--border-width),
	calc(100% - var(--border-width))
		calc(100% - calc(var(--curve-size) + var(--border-width) * 0.5)),
	/* bottom-right 1 */
		calc(100% - calc(var(--curve-size) + var(--border-width) * 0.5))
		calc(100% - var(--border-width)),
	/* bottom-right 2 */ var(--border-width) calc(100% - var(--border-width))
	);
	transition: clip-path 500ms;
}


.Btn {
	--white: #ffffff;
	--af-white: #e1fbf5;
	--ch-white: #e1e1e1;
	display: flex;
	align-items: center;
	justify-content: flex-start;
	width: 45px;
	height: 45px;
	border: none;
	border-radius: 12px;
	cursor: pointer;
	position: relative;
	overflow: hidden;
	transition-duration: .3s;
	box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
	background: linear-gradient(135deg, rgba(81,38,99,1) 0%, rgba(50,81,131,1) 40%, rgba(29,126,158,1) 70%, rgba(86,170,177,1) 100%);
}

/* plus sign */
.sign {
	font-size: 35px;
	width: 100%;
	transition-duration: .3s;
	display: flex;
	align-items: center;
	justify-content: center;
	text-shadow: 0px 0px 5px rgba(158,255,235,1);
	color: #c1fbff;

}

.text {
	position: absolute;
	right: 0%;
	width: 0%;
	opacity: 0;
	color: var(--af-white);
	font-size: 15px;
	font-weight: 600;
	transition-duration: .3s;
	line-height: 15px;
	text-shadow: 0px 0px 5px rgba(158,255,235,1);
}
/* hover effect on button width */
.Btn:hover {
	width: 100px;
	border-radius: 12px;
	transition-duration: .3s;
}

.Btn:hover .sign {
	width: 30%;
	transition-duration: .3s;
	padding-left: 7px;

}
/* hover effect button's text */
.Btn:hover .text {
	opacity: 1;
	width: 70%;
	transition-duration: .3s;
	padding-right: 10px;
}
/* button click effect*/
.Btn:active {
	transform: translate(2px ,2px);
}


</style>