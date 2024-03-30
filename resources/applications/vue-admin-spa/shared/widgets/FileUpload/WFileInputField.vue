<template>
	<div>
		<v-row no-gutters align="center">
			<v-col>
				<div
					class="text-caption"
					:class="{
						'error--text animation-shake': errorMessages.length > 0,
					}"
				>
					<span>{{ label }}</span>
				</div>
			</v-col>
		</v-row>
		<div class="pt-1 pb-1">
			<v-row dense>
				<template v-for="(item,i ) in imageValues">
					<v-col :key="i" cols="auto">
						<v-card
							outlined
							draggable
							class="text-center pa-2"
							@dragstart="startDrag($event, i)"
							@drop="onDrop($event, i)"
							@dragover.prevent
						>
							<v-row dense align="center">
								<v-col cols="auto">
									<v-icon>{{ isInstanceOfFile(item) ? 'mdi-file' : 'mdi-file-cloud' }}</v-icon>
								</v-col>
								<v-col cols="auto" class="text-body-2">
									<div v-if="isInstanceOfFile(item)">{{ item.name }}</div>
									<div v-else>
										<a
											:href="item.file_url"
											target="_BLANK"
											class="font-weight-bold text-body-1"
										>{{ item.name }}</a>
									</div>
								</v-col>
								<v-col cols="auto">
									<v-btn
										color="error"
										class="background"
										icon
										small
										@click="removeFile(i)"
									>
										<v-icon small>mdi-close</v-icon>
									</v-btn>
								</v-col>
							</v-row>
						</v-card>
					</v-col>
				</template>
				<v-col cols="auto">
					<w-droppable-file-input
						v-if="(typeof multiple == 'boolean' && multiple == true) || (typeof multiple == 'number' && multiple > imageValues.length) || imageValues.length == 0"
						ref="fileInput"
						:accept="accept"
						:multiple="!!multiple"
						@input="onInput"
					>
						<template #activator="{ draggedOver, toggle }">
							<v-card
								:class="{
									'opacity-5' : draggedOver,
									'animation-shake' : errorMessages.length > 0,
								}"
								class="fill-height align-center justify-center py-2 px-4 radius-10"
								outlined
								flat
								:style="{
									'border-color' : errorMessages.length > 0 ? $vuetify.theme.currentTheme.error : null,
								}"
								@click="toggle"
							>
								<v-row dense align="center">
									<v-col cols="auto">
										<v-icon small>mdi-plus</v-icon>
									</v-col>
								</v-row>
							</v-card>
						</template>
					</w-droppable-file-input>
				</v-col>
			</v-row>
			<div class="v-messages error--text">
				<v-expand-transition>
					<div
						v-if="errorMessages.length > 0"
						class="v-messages__message pt-1"
					>
						{{ errorMessages[0] }}
					</div>
				</v-expand-transition>
			</div>
		</div>
	</div>
</template>

<script>
import WDroppableFileInput from './Core/WDroppableFileInput.vue'
export default {
	components: { WDroppableFileInput },
	props:{
		value:{
			type: [Object, File, Array ],
			default: null,
		},
		label: {
			type: String,
			default: null
		},
		accept: {
			type: String,
			default: "*"
		},
		errorMessages: {
			type: Array,
			default: ()=>[]
		},
		multiple: {
			type: [Boolean, Number],
			default: false
		},
	},
	data () {
		return {
			isDragOver: false,
			value__: null,
			isSorting: false,
		}
	},
	computed:{
		imageValues(){
			let newVal = []
			if(newVal){
				if(this.value__ instanceof File){
					newVal = [ this.value__ ]
				}else{
					newVal = [ ...this.value__ ]
				}
			}

			newVal.forEach((item)=>{
				item.previewImage = this.preview(item)
			})
			return newVal
		}
	},
	watch:{
		'value':{
			handler(){
				if(this.value == null){
					this.value__ = []
				}else if(this.value.file_url){
					this.value__ = [ this.value ]
				}else{
					this.value__ = this.value
				}

			},
			immediate: true,
		},
	},
	methods: {
		preview(data){
			return data.type ? URL.createObjectURL(data) : null
		},
		isInstanceOfFile(item){
			return item instanceof File
		},
		formatBytes(bytes, decimals = 2) {
			if (!+bytes) return '0 Bytes'

			const k = 1024
			const dm = decimals < 0 ? 0 : decimals
			const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

			const i = Math.floor(Math.log(bytes) / Math.log(k))

			return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
		},
		onInput(val){
			let newVal = []
			if(val instanceof File){
				val = [ val ]
			}

			if(this.value__ == null ){
				newVal = [ ...val ]
			}else{
				newVal = [ ...this.value__ , ...val ]
			}
			if(typeof this.multiple == 'number' && newVal.length > this.multiple){
				this.$emit('max-item')
				newVal = newVal.slice(0, this.multiple)
			}

			if(this.multiple == false){
				newVal = newVal[0]
			}
			this.$emit('input', newVal)
		},
		removeFile(index)
		{
			if(this.multiple){
				this.value__.splice(index, 1)
			}else{
				this.value__ = null
			}
			this.$emit("input", this.value__)
		},
		startDrag(evt, item) {
			this.isSorting = true
			evt.dataTransfer.dropEffect = 'move'
			evt.dataTransfer.effectAllowed = 'move'
			evt.dataTransfer.setData('index', item)
		},
		onDrop(evt, draggedPosition) {
			this.isSorting = false
			const sortingMode = (evt.dataTransfer.files.length == 0)
			if(sortingMode)
			{
				const selectedPosition = evt.dataTransfer.getData('index')
				if(draggedPosition == selectedPosition){
					return;
				}

				const removedItems = this.value__.splice(selectedPosition, 1)
				this.value__.splice(draggedPosition, 0, removedItems[0])

			}
		},
	}
}
</script>