<template>
	<v-carousel
		v-model="carousel"
		height="100%"
		continuous
		hide-delimiters
		:show-arrows="showArrows"
		:cycle="cycle"
		@change="emitChangeEvent"
	>
		<slot></slot>

		<v-item-group
			v-model="carousel"
			class="transform-center-x col-12"
			:class="{
				'position-absolute' : absoluteDelimiter,
			}"
			:style="absoluteDelimiter ? 'bottom: 8px;' : '' "
			@change="emitChangeEvent"
		>
			<v-row 
				align="center" 
				justify="center" 
				dense 
				class="mb-5"
			>
				<v-col cols="auto" class="mr-md-5" dense>
					<div>
						<v-btn
							color="#DAA520"
							tile
							:height="$vuetify.breakpoint.smAndDown ? 35 : 40"
							:min-width="$vuetify.breakpoint.smAndDown ? 35 : 40"
							class="pa-0"
							elevation="0"
							:rounded="false"
							@click="carousel = (carousel-1) < 0 ? length - 1 : Math.max(carousel - 1, 0)"
						>
							<v-icon
								color="white"
								:style="$vuetify.breakpoint.smAndDown ? 'font-size: 35px;' : 'font-size: 40px;'"
							>
								mdi-chevron-left
							</v-icon>
						</v-btn>
					</div>
				</v-col>
				<v-col 
					cols="auto" 
					align="center" 
					class="mx-2 my-auto" 
					dense
				>
					<v-row 
						v-if="$vuetify.breakpoint.mdAndUp" 
						justify="center" dense class="ma-0"
					>
						<template v-for="(item,i) in length">
							<v-item :key="i" v-slot="{ active, toggle }">
								<v-col cols="auto">
									<v-btn
										:color="active ? '#FFFFFF' : 'transparent'"
										class="bullets mx-md-3 mx-1"
										style="filter: drop-shadow(0px 2px 1px rgba(0,0,0,0.6));"
										icon x-small
										:ripple="false"
										@click="toggle"
									>
										<v-icon :color="active ? '#DAA520' : '#D9D9D9'" :size="$vuetify.breakpoint.smAndDown ? '35px' : '45px'">mdi-minus </v-icon>
									</v-btn>
								</v-col>
							</v-item>
						</template>
					</v-row>
				</v-col>
				<v-col cols="auto" class="ml-md-5" dense>
					<div>
						<v-btn
							color="white"
							tile
							:height="$vuetify.breakpoint.smAndDown ? 35 : 40"
							:min-width="$vuetify.breakpoint.smAndDown ? 35 : 40"
							class="pa-0"
							elevation="0"
							@click="carousel = Math.min(carousel + 1, length)"
						>
							<v-icon
								color="black"
								tile
								:style="$vuetify.breakpoint.smAndDown ? 'font-size: 35px;' : 'font-size: 40px;'"
							>
								mdi-chevron-right
							</v-icon>
						</v-btn>
					</div>
				</v-col>
			</v-row>
		</v-item-group>
	</v-carousel>
</template>

<script>
export default {
	props: {
		value:{
			type: [Number, String],
			default: null,
		},
		length: {
			type: Number,
			required: true,
		},
		showArrows: {
			type: Boolean,
			default: true,
		},
		absoluteDelimiter: {
			type: Boolean,
			default: true,
		},
		cycle: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			carousel: null,
		}
	},
	watch: {
		value: {
			handler(newVal, oldVal) {
				this.carousel = newVal;
			},
			immediate: true,
		}
	},
	methods: {
		emitChangeEvent() {
			this.$emit('input', this.carousel)
		}
	}
}
</script>

<style>
.v-window__next, .v-window__prev {
	background-color: transparent !important;
	margin: 0 5% !important;
	filter: drop-shadow(0px 0px 1px #00000040);
}

.bullets::before {
	background-color:transparent !important;
}
</style>