<template>
	<v-sheet :width="width" class="fill-height">
		<input
			v-show="false"
			ref="fileInput"
			type="file"
			:multiple="multiple"
			:accept="accept"
			@change="onSelectFile($event)"
		/>

		<v-sheet
			id="dropzone"
			tabindex="0"
			class="d-inline"
			color="transparent"
			@dragover.prevent="isDragOver = true"
			@dragenter.prevent="isDragOver = true"
			@dragleave.prevent="isDragOver = false"
			@drop.prevent="onDrop($event)"
		>
			<slot
				name="activator"
				:draggedOver="isDragOver"
				:toggle="()=> {
					openInput()
				}"
			>
				<v-card class="pa-12 text-center" outlined>
					<div>
						<v-icon size="30">mdi-file-plus</v-icon>
					</div>
				</v-card>
			</slot>
		</v-sheet>
	</v-sheet>
</template>

<script>
export default {
	props:{
		accept: {
			type: String,
			default: null
		},
		multiple: {
			type: Boolean,
			default: false,
		},
		width: {
			type: [ Number, String ],
			default: null
		},
	},
	data () {
		return {
			isDragOver: false,
		}
	},
	methods: {
		onDrop(e){
			this.isDragOver = false;
			if(e.dataTransfer) {
				this.filesSelected(e.dataTransfer.files)
			}
		},
		onSelectFile(e){
			const target = (e.target)
			if(target.files) {
				this.filesSelected(target.files)
			}
		},
		openInput(){
			this.$refs.fileInput.click()
		},
		filesSelected(fileList) {
			this.isDragOver = false

			let result = fileList
			result = [...result].filter((item)=>{
				return this.verifyAccept(item.type)
			})
			if(!this.multiple) {
				result = fileList[0]
			}
			this.$emit("input", result)
		},
		verifyAccept( fileType ) {
			var typeRegex = new RegExp( this.accept.replace( /\*/g, '.*' ).replace( /,/g, '|' ) );
			return typeRegex.test( fileType );
		}
	}
}
</script>