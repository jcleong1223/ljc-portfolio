<template>
	<v-sheet color="transparent">
		<v-footer padless>
			<v-card
				flat tile class="text-center fill-width border-top-primary"
			>
				<v-card-text class="pt-6 font-weight-bold body-1">
					<div>Footer</div>
					<v-row class="text-caption text-md-body-2 text-center pt-6 pb-2" dense justify="center">
						<v-col cols="12" md="auto">{{ $t('footer.copyrights') }} © {{ $dayjs().format("YYYY") }} {{ copyrightTitle }}</v-col>
						<v-col cols="12" md="auto">
							<div v-html="$t('footer.powered_by', {'author' : authorEl})"></div>
						</v-col>
					</v-row>
				</v-card-text>
			</v-card>
		</v-footer>
	</v-sheet>
</template>

<script>
export default {
	data(){
		return {
			poweredBy: null,
			copyrightTitle: "",
		}
	},
	computed:{
		authorEl(){
			return `<a href="${this.poweredBy.href}" class="text-color-unset" target="_blank">${this.poweredBy.text}</a>`
		},
	},
	created(){
		this.copyrightTitle = "Nexus"
		this.poweredBy = {
			text: "ETC Web Design",
			href: "https://www.etctech.com.my/",
		}
	},
}
</script>

<style scoped>
.border-top-primary{
	border-top: 4px solid #DE002B !important;
}
</style>
