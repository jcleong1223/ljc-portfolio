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
		<v-card class="ckeditor-input-card">
			<ckeditor
				v-model="editorData"
				:editor="editor"
				:config="editorConfig"
				@input="emitInputEvent"
			></ckeditor>
		</v-card>
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
</template>

<script>
// https://ckeditor.com/docs/ckeditor5/latest/api/module_core_editor_editorconfig-EditorConfig.html
import CKEditor from '@ckeditor/ckeditor5-vue2';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CustomUploadAdapter from "@src/plugins/ckeditor/CustomUploadAdapter"
export default {
	components: {
		ckeditor: CKEditor.component
	},
	props:{
		value:{
			type: String,
			default: "",
		},
		label: {
			type: String,
			default: null
		},
		errorMessages: {
			type: Array,
			default: ()=>[]
		},
	},
	data() {
		return {
			editorData: "",
			editor: ClassicEditor,
			editorConfig: {
				placeholder: "",
				extraPlugins:[
					this.setupExtraPlugins()
				],
				toolbar: {
					shouldNotGroupWhenFull: true,
				}
			},
		};
	},
	watch:{
		'value': {
			handler(newVal){
				this.editorData = newVal
			},
			immediate: true,
		}
	},
	created(){
		//
	},
	methods: {
		setupExtraPlugins(){
			return (editor) => {
				const notifications = editor.plugins.get('Notification');
				notifications.on('show:warning', (evt, _data) =>
				{
					this.$toast.warning(_data.message)
					evt.stop();
				});

				editor.plugins.get('FileRepository').createUploadAdapter = ( loader ) =>
				{
				// Create an instance of the UploadAdapter class
					const adapter = new CustomUploadAdapter(loader);

					// Return an object with the `upload()` and `abort()` methods
					return {
						upload: () => adapter.upload(),
						abort: () => adapter.abort()
					};
				};
			}
		},
		emitInputEvent()
		{
			this.$emit('input', this.editorData);
		}
	},
}
</script>

<style scoped>
.ck.ck-content.ck-editor__editable >>>{
	background: red !important;
}
</style>