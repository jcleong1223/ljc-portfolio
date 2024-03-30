<template>
	<v-sheet color="transparent" class="fill-height">
		<v-sheet height="300" color="red">
			<v-container fill-height class="justify-center">
				<div class="font-weight-bold text-h4">{{ $t("contact-us-page.title") }}</div>
			</v-container>
		</v-sheet>
	</v-sheet>
</template>


<script>
import { errorHandlerMixin } from "@src/mixins/ErrorHandlerMixin";
export default {
	components: {
	},
	mixins: [
		errorHandlerMixin,
	],
	data() {
		return {
		};
	},
	created(){
		//
	},
	methods: {
	},
};
</script>