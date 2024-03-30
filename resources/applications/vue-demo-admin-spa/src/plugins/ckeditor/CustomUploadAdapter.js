import axios from 'axios';
const uploadUrl = "/public-file/upload/ckeditor";

export default class CustomUploadAdapter {
	constructor(loader) {
		// The file loader instance to use during the upload.
		this.loader = loader;
	}

	// Starts the upload process.
	upload() {
		return this.loader.file
			.then(file => {
				const data = new FormData();
				data.append('upload', file);
				return axios.post(uploadUrl, data, {
					onUploadProgress: progressEvent => {
						this.loader.uploadTotal = progressEvent.total;
						this.loader.uploaded = progressEvent.loaded;
					}
				}).then(response => {
					// If the upload is successful, resolve the upload promise with an object containing
					// at least the "default" URL, pointing to the image on the server.
					// This URL will be used to display the image in the content. Learn more in the
					// UploadAdapter#upload documentation.
					return Promise.resolve(response.data.data);
				}).catch(error => {
					return Promise.reject(error.data ? error.data.message : `Couldn't upload file: ${file.name}.`);
				});
			});
	}

	// Aborts the upload process.
	abort() {
		// Reject the promise returned by upload() to abort the upload process.
		this.loader.file.catch(() => {});
	}
}