<template>
	<v-row class="justify-center">
		<v-col 
			cols="10"
			class="mx-auto my-auto px-0"
		>
			<v-carousel
				v-model="carousel"
				height="100%"
				continuous
				hide-delimiters
				:show-arrows="false"
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
					:style="absoluteDelimiter ? 'bottom:0px; background-image:linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,0.6));' : 'background-color:linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,0.6));' "
					@change="emitChangeEvent"
				>
					<v-row align="center" justify="center" dense>
						<v-col cols="auto" class="mx-2" dense>
							<div>
								<v-btn
									color="#DAA520"
									tile
									:height="$vuetify.breakpoint.smAndDown ? 35 : 40"
									:min-width="$vuetify.breakpoint.smAndDown ? 35 : 40"
									class="pa-0"
									elevation="0"
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
							class="mx-md-2 mx-0 my-auto"
							dense
						>
							<v-row 
								v-if="$vuetify.breakpoint.mdAndUp" 
								justify="center" 
								dense 
								class="ma-0"
							>
								<template v-for="(item,i) in length">
									<v-item :key="i" v-slot="{ active, toggle }">
										<v-col cols="auto">
											<v-btn
												:color="active ? '#FFFFFF' : 'transparent'"
												style="filter: drop-shadow(0px 2px 1px rgba(0,0,0,0.6));"
												class="bullets mx-md-2 mx-2"
												icon x-small
												:ripple="false"
												@click="toggle"
											>
												<v-icon :color="active ? '#DAA520' : '#D9D9D9'" :size="$vuetify.breakpoint.smAndDown ? '35px' : '45px'" class="px-md-0 px-1">mdi-minus </v-icon>
											</v-btn>
										</v-col>
									</v-item>
								</template>
							</v-row>
						</v-col>
						<v-col cols="auto" class="mx-md-2 mx-1" dense>
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
		</v-col>
		<v-col
			v-if="$vuetify.breakpoint.mdAndUp"
			cols="2"
			:class="images.length > 4 ? 'py-2 mx-auto my-2 thumbnail' : 'py-4 mx-auto my-2 thumbnail'"
			:style="images.length > 4 ? 'max-height: 470px; overflow-y: scroll' : 'max-height: 470px;'"
			align="center"
		>
			<v-img
				v-for="(image, i) in images" :key="i"
				class="mb-3 small-img"
				style="align-self: center; max-width: 65%;"
				height="100"
				:src="image.content.file_url"
				eager
				cover
				@click="carousel = i"
			></v-img>
		</v-col>
		<v-col
			v-if="!$vuetify.breakpoint.mdAndUp"
			cols="12"
		>
			<v-row
				class="ml-3 justify-start thumbnail"
			>
				<v-img
					v-for="(image, i) in images" :key="i"
					:class="$vuetify.breakpoint.smAndDown ? 'my-3 ml-3 small-img' : 'my-3 mx-3 small-img'"
					style="align-self: center; max-width: 100px"
					:src="image.content.file_url"
					eager
					@click="carousel = i"
				></v-img>
			</v-row>
		</v-col>
	</v-row>
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
		images: {
			type: Array,
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

.thumbnail::-webkit-scrollbar {
  width: 10px;
}

.thumbnail::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px gold; 
  border-radius: 10px;
}

.thumbnail::-webkit-scrollbar-thumb {
  background: #DAA520; 
  border-radius: 5px;
}
</style>