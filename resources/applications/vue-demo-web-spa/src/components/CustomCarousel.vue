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
			class="transform-center-x"
			:class="{
				'position-absolute' : absoluteDelimiter,
			}"
			:style="absoluteDelimiter ? 'bottom: 8px;' : '' "
			@change="emitChangeEvent"
		>
			<v-row justify="center" dense class="ma-0">
				<template v-for="(item,i) in length">
					<v-item :key="i" v-slot="{ active, toggle }">
						<v-col cols="auto">
							<v-btn
								:color="active ? '#FFFFFF' : 'transparent'"
								:style="active ? 'border: none;' : 'border: 1.5px solid white; height: 10px; width: 10px;'"
								style="filter: drop-shadow(0px 2px 1px rgba(0,0,0,0.6));"
								icon x-small
								@click="toggle"
							>
								<v-icon :style="active ? 'font-size: 16px' : '12px'" :size="$vuetify.breakpoint.smAndDown ? '12px' : '14px'">mdi-circle</v-icon>
							</v-btn>
						</v-col>
					</v-item>
				</template>
			</v-row>
		</v-item-group>

		<template #prev="{ on }">
			<div v-if="showArrows" v-on="on">
				<v-icon
					color="white"
					class="text-h2"
					style="font-size: 40px !important;"
				>
					mdi-chevron-left
				</v-icon>
			</div>
		</template>

		<template #next="{ on }">
			<div v-if="showArrows" v-on="on">
				<v-icon
					color="white"
					class="text-h2"
					style="font-size: 40px !important;"
				>
					mdi-chevron-right
				</v-icon>
			</div>
		</template>
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
</style>