<template>
	<v-card color="transparent" class="elevation-8">
		<v-footer padless>
			<div class="pr-6 pb-4" style="bottom: 0; right: 0; z-index:1; position: fixed;">
				<v-row class="ma-0 text-end flex-column" dense>
					<v-col cols="auto">
						<a class="" href="https://api.whatsapp.com/send?phone=60122909611" target="_blank">
							<img src="/images/WhatsApp.png" width="45px">
						</a>
					</v-col>
					<v-col cols="auto">
						<!-- <v-btn
							v-show="backToTopBtn"
							v-scroll="onScroll"
							color="#AC6869"
							fab
							tile
							x-small
							dark
							class="mr-2"
							@click="toTop()"
						>
							<v-icon x-large color="white" :size="$vuetify.breakpoint.smAndDown ? '20px' : '45px'">mdi-chevron-up</v-icon>
						</v-btn> -->
						<button @click="toTop()">
							<div class="text">
								<span>Back</span>
								<span>to</span>
								<span>top</span>
							</div>
							<div class="clone">
								<span>Back</span>
								<span>to</span>
								<span>top</span>
							</div>
							<svg
								xmlns="http://www.w3.org/2000/svg" width="16" height="16"
								fill="currentColor" class="bi bi-airplane-fill" viewBox="0 0 16 16"
							>
								<path d="M6.428 1.151C6.708.591 7.213 0 8 0s1.292.592 1.572 1.151C9.861 1.73 10 2.431 10 3v3.691l5.17 2.585a1.5 1.5 0 0 1 .83 1.342V12a.5.5 0 0 1-.582.493l-5.507-.918-.375 2.253 1.318 1.318A.5.5 0 0 1 10.5 16h-5a.5.5 0 0 1-.354-.854l1.319-1.318-.376-2.253-5.507.918A.5.5 0 0 1 0 12v-1.382a1.5 1.5 0 0 1 .83-1.342L6 6.691V3c0-.568.14-1.271.428-1.849Z" />
							</svg>
						</button>
					</v-col>
				</v-row>
			</div>
		</v-footer>

		<v-card
			flat tile class="text-center fill-width"
			color="#D6EDF7"
		>
			<v-card-text class="pt-6 font-weight-bold body-1">
				<v-row class="pb-6 justify-space-between align-self-center">
					<v-row :class="$vuetify.breakpoint.smAndDown ? 'py-10' : 'py-8 justify-center'">
						<v-col cols="7" sm="4" xl="4">
							<v-img class="mx-auto" :style="$vuetify.breakpoint.smAndDown ? 'max-width:70%; margin-left: 10px;' : 'max-width:35%;'" src="/images/ljc.png"></v-img>
						</v-col>
						<v-col
							cols="4" md="8" xl="8" 
							class="align-self-center justify-center"
						>
							<v-row :class="$vuetify.breakpoint.smAndDown ? 'd-block text-left pl-6' : ''">
								<template v-for="(nav_link, i) in footerRow">
									<div :key="i" class="align-self-end">
										<router-link
											:key="i"
											:class="$vuetify.breakpoint.smAndDown ? 'font-size-text text-decoration-none font-weight-bold font-family-inter text-h6 d-block' : 'font-size-text text-decoration-none font-weight-bold font-family-inter mx-16 text-h5'"
											exact
											:to="nav_link.to"
											@click.native="goToAnchor()"
										>
											<span style="line-height: 24px;">{{ $t(nav_link.title) }}</span>
										</router-link>
									</div>
								</template>
							</v-row>
						</v-col>
					</v-row>
				</v-row>
				<v-divider style="width:90%;"></v-divider>
				<v-row
					class="text-center pt-6 pb-2"
					style="font-size:16px;"
					dense
					justify="center"
				>
					<!-- <v-col cols="12" md="auto">{{ $t('footer.copyrights') }} © {{ $dayjs().format("YYYY") }} {{ copyrightTitle }}</v-col> -->
					<v-col cols="12" md="auto">{{ $dayjs().format("YYYY") }} © {{ copyrightTitle }}</v-col>

					<v-col cols="12" md="auto">
						<div v-html="$t('footer.powered_by')"></div>
					</v-col>
				</v-row>
			</v-card-text>
		</v-card>
	</v-card>
</template>

<script>
export default {
	data(){
		return {
			poweredBy: null,
			copyrightTitle: "",
			backToTopBtn: false,
			footerCol1: [],
			footerCol2: [],
		}
	},
	computed:{
		// authorEl(){
		// 	return `<a href="${this.poweredBy.href}" class="text-decoration-none text-color-unset" target="_blank"><span style="color:#DAA520;"><b>${this.poweredBy.text}</b></span></a>`
		// },
	},
	created(){
		this.copyrightTitle = "LJC."
		// this.poweredBy = {
		// 	text: "",
		// 	href: "https://www.etctech.com.my/",
		// }
		this.footerRow = [
			{ title : "nav.home", to : { name: "home-page", "hash": "#" } },
			{ title : "nav.about-me", to : { name: "about-us" } },
			{ title : "nav.projects", to : { name: "projects"} },
			// { title : "nav.contact-me", to : { name: "contact-me"} },
		]
	},
	methods:{
		onScroll (e) {
			if (typeof window === 'undefined') return
			const top = window.pageYOffset ||   e.target.scrollTop || 0
			this.backToTopBtn = (top > 50)
		},
		toTop() {
			this.$vuetify.goTo(0);
		},
	},
}
</script>

<style scoped>
.border-top-primary{
	height: 500px;
}

button {
  width: 140px;
  height: 56px;
  overflow: hidden;
  border: none;
  color: #014D69;
  background: none;
  position: relative;
  padding-bottom: 2em;
}

button > div,button > svg {
  position: absolute;
  width: 100%;
  height: 100%;
  display: flex;
}

button:before {
  content: "";
  position: absolute;
  height: 2px;
  bottom: 0;
  left: 0;
  width: 100%;
  transform: scaleX(0);
  transform-origin: bottom right;
  background: currentColor;
  transition: transform 0.25s ease-out;
}

button:hover:before {
  transform: scaleX(1);
  transform-origin: bottom left;
}

button .clone > *,button .text > * {
  opacity: 1;
  font-size: 1.3rem;
  transition: 0.2s;
  margin-left: 4px;
}

button .clone > * {
  transform: translateY(60px);
}

button:hover .clone > * {
  opacity: 1;
  transform: translateY(0px);
  transition: all 0.2s cubic-bezier(0.215, 0.61, 0.355, 1) 0s;
}

button:hover .text > * {
  opacity: 1;
  transform: translateY(-60px);
  transition: all 0.2s cubic-bezier(0.215, 0.61, 0.355, 1) 0s;
}

button:hover .clone > :nth-child(1) {
  transition-delay: 0.15s;
}

button:hover .clone > :nth-child(2) {
  transition-delay: 0.2s;
}

button:hover .clone > :nth-child(3) {
  transition-delay: 0.25s;
}

button:hover .clone > :nth-child(4) {
  transition-delay: 0.3s;
}
/* icon style and hover */
button svg {
  width: 20px;
  right: 0;
  top: 50%;
  transform: translateY(-50%) rotate(270deg);
  transition: 0.2s ease-out;
}

button:hover svg {
  transform: translateY(-50%) rotate(0deg);
}


</style>
