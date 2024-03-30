<template>
	<v-sheet class="fill-height" dark>
		<v-container fluid fill-height class="justify-center black">
			<v-container>
				<v-row dense>
					<v-col cols="12" class="text-center pb-4">
						<div @dblclick="toLogin()">
							<img
								src="/images/kploo_logo.png"
								:style="$vuetify.breakpoint.mdAndUp ? 'width: 35vmin;' : 'width: 45vmin;' "
								style="max-width: 400px;"
							>
						</div>
					</v-col>
					<v-col
						cols="12" md="12"
						class="white--text text-center px-3"
						align-self="center"
					>
						<div class="pt-0">
							<!-- <a :href="appStoreUrl" target="_BLANK">
								<img alt="Get it on App Store" src="/images/app-store/apple-black.png" style="width:130px; height: 38px;">
							</a>
							<a :href="googlePlayUrl" target="_BLANK">
								<img alt="Get it on Google Play" src="/images/app-store/google-play-black.png" style="width:130px; height: 38px;">
							</a> -->
							<!-- <a :href="huaweiStoreUrl">
								<img alt="Explore it on AppGalley" src="/images/app-store/huawei-black.png" style="width:130px; height: 38px;">
							</a> -->
						</div>
					</v-col>
				</v-row>
			</v-container>
		</v-container>
	</v-sheet>
</template>

<script>
export default {
	data() {
		return {
			appStoreUrl : null,
			googlePlayUrl : null,
			huaweiStoreUrl : null,
		}
	},
	created(){
		let appStoreId = ""
		let googlePlayId = ""
		let huaweiStoreId = ""

		this.appStoreUrl = "https://apps.apple.com/my/app/"+appStoreId
		this.googlePlayUrl = "https://play.google.com/store/apps/details?id="+googlePlayId
		this.huaweiStoreUrl = "https://appgallery.huawei.com/app/"+huaweiStoreId
	},
	methods:{
		toLogin(){
			this.$router.push("/login")
		}
	}
}
</script>
