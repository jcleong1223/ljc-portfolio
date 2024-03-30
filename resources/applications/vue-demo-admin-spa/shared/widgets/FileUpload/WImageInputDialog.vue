<template>
	<div>
		<slot name="activator" :on="()=>{ dialog = true }">
			<v-btn rounded @click="dialog = true">Upload File</v-btn>
		</slot>

		<v-dialog
			v-model="dialog"
			max-width="600px"
			scrollable
			persistent
			eager
		>
			<v-card ref="dialogCard">
				<v-card-title class="pa-2">
					<v-row dense class="ma-0">
						<v-col cols="1"></v-col>
						<v-col>
							<div class="text-center font-weight-bold">Upload Image</div>
						</v-col>
						<v-col cols="1">
							<v-btn
								icon
								@click="closeDialog"
							>
								<v-icon>mdi-close</v-icon>
							</v-btn>
						</v-col>
					</v-row>
				</v-card-title>
				<v-divider class="ma-0"></v-divider>
				<v-card-text class="pa-0 position-relative">
					<w-droppable-file-input
						:accept="accept"
						multiple
						@input="onInput($event)"
					>
						<template #activator="{ toggle }">
							<div class="position-relative">
								<v-row dense class="ma-0 pa-3">
									<template v-for="(file,i) in files">
										<v-col
											:key="i"
											cols="6" sm="4" md="3"
										>
											<v-hover v-slot="{ hover }">
												<v-card
													outlined
													draggable
													@dragstart="startDragSorting($event, i)"
													@drop="onDropSorting($event, i)"
													@dragover.prevent
												>
													<v-img
														:src="file.image"
														:aspect-ratio="1"
														:contain="contain"
													>
														<v-btn
															v-show="hover"
															color="error"
															class="background position-absolute"
															style="top: 2px; right: 2px;"
															icon
															small
															@click="removeFile()"
														>
															<v-icon small>mdi-close</v-icon>
														</v-btn>
													</v-img>
												</v-card>
											</v-hover>
										</v-col>
									</template>
									<v-col
										v-if="(maxItem > files.length) || maxItem == null"
										cols="6" sm="4" md="3"
									>
										<v-responsive aspect-ratio="1">
											<v-card
												class="fill-height d-flex align-center justify-center"
												outlined
												@click="toggle"
												@keyup.enter="toggle"
											>
												<div>
													<v-icon size="40">mdi-plus</v-icon>
												</div>
											</v-card>
										</v-responsive>
									</v-col>
								</v-row>
							</div>
							<div
								v-show="(isDragOver)"
								class="position-absolute fill-height fill-width"
								style="z-index:1; top: 0; left: 0;"
							>
								<div
									class="d-flex justify-center align-center fill-height fill-width position-absolute"
									style="z-index:1; top: 0; left: 0;"
								>
									<div class="text-h6">Drop Files</div>
								</div>
								<div class="fill-height fill-width background-x opacity-5"></div>
							</div>
						</template>
					</w-droppable-file-input>
				</v-card-text>
				<v-divider class="ma-0"></v-divider>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn
						color="primary"
						@click="emitSave"
					>
						Upload
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
import WDroppableFileInput from './Core/WDroppableFileInput.vue'
export default{
	components: { WDroppableFileInput },
	props:{
		maxItem:{
			type: [Number, null],
			default: null,
		},
		accept: {
			type: String,
			default: "image/*"
		},
		contain: {
			type: Boolean,
			default: false
		},
	},
	data(){
		return {
			dialog : false,
			files: [],
			isDragOver: false,
		}
	},
	watch:{
		"dialog" : {
			handler(newVal){
				if(newVal == false){
					this.files = []
					this.isDragOver = false
				}else{
					this.$nextTick(()=>{
						this.setOverlayElDropEvent()
					})
				}
			}
		}
	},
	mounted(){
		this.setCardElDropEvent()
	},
	methods:{
		setOverlayElDropEvent(){
			let overlayEl = this.$root.$el.firstElementChild
			overlayEl.addEventListener('dragover', (e)=>{
				e.preventDefault()
				if(e.dataTransfer.types.includes("Files")){
					this.isDragOver = true
				}
			})
			overlayEl.addEventListener('dragenter', (e)=>{
				e.preventDefault()
				if(e.dataTransfer.types.includes("Files")){
					this.isDragOver = true
				}
			})
			overlayEl.addEventListener('dragleave', (e)=>{
				e.preventDefault()
				this.isDragOver = false
			})
			overlayEl.addEventListener('drop', (e)=>{
				e.preventDefault()
				this.isDragOver = false
			})
		},
		setCardElDropEvent(){
			let cardEl = this.$refs.dialogCard.$el
			cardEl.addEventListener('dragover', (e)=>{
				e.preventDefault()
				if(e.dataTransfer.types.includes("Files")){
					this.isDragOver = true
				}
			})
			cardEl.addEventListener('dragenter', (e)=>{
				e.preventDefault()
				if(e.dataTransfer.types.includes("Files")){
					this.isDragOver = true
				}
			})
			cardEl.addEventListener('drop', (e)=>{
				e.preventDefault()
				this.isDragOver = false
			})
		},
		preview(data){
			return data.type ? URL.createObjectURL(data) : null
		},
		removeFile(index)
		{
			this.files.splice(index, 1)
		},
		onInput(val){
			let newVal = [ ...this.files, ...val ]
			if(this.maxItem && newVal.length > this.maxItem){
				this.$emit('max-item')
				newVal = newVal.slice(0, this.maxItem)
			}

			newVal.forEach((item)=>{
				item.image = this.preview(item)
			})
			this.files = newVal
		},
		emitSave(){
			this.$emit('input', this.files)
			this.closeDialog()
		},
		closeDialog(){
			this.dialog = false
		},
		handleDrop(dataTransfer, event){
			this.files.push(dataTransfer.item);
			this.files.splice( dataTransfer.index, 1);
		},
		startDragSorting(evt, item) {
			evt.dataTransfer.dropEffect = 'move'
			evt.dataTransfer.effectAllowed = 'move'
			evt.dataTransfer.setData('index', item)
		},
		onDropSorting(evt, draggedPosition) {
			const sortingMode = (evt.dataTransfer.files.length == 0)
			if(sortingMode)
			{
				const selectedPosition = evt.dataTransfer.getData('index')
				if(draggedPosition == selectedPosition){
					return;
				}

				const removedItems = this.files.splice(selectedPosition, 1)
				this.files.splice(draggedPosition, 0, removedItems[0])

			}
		},
	}
}
</script>
