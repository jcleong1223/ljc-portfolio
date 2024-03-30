import axios from 'axios';

const prefix = "/career"

const careerClient = {

	getCareerList(payload) {
		return axios.get( prefix + "/list", {params: payload})
	},
	getCareerInfo(id, payload){
		return axios.get( prefix + "/info/"+id, {params: payload})
	},
	createCareer(payload){
		return axios.post( prefix + "/create", payload)
	},
	updateCareer(payload){
		return axios.post( prefix + "/update", payload)
	},
	archiveCareer(payload) {
		return axios.delete( prefix + "/archive", {params: payload})
	},

	// syncProductImage(payload, progressCallback = (_percentCompleted: number)=>{})
	// {
	// 	const onUploadProgress = (progressEvent) => {
	// 		const percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
	// 		progressCallback(percentCompleted)
	// 	}

	// 	return axios.post( prefix + "/sync-image", payload, {
	// 		headers: { 'Content-Type': 'multipart/form-data'},
	// 		onUploadProgress
	// 	})
	// },

	syncProductFile(payload, progressCallback = (_percentCompleted: number)=>{})
	{
		const onUploadProgress = (progressEvent) => {
			const percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
			progressCallback(percentCompleted)
		}

		return axios.post( prefix + "/sync-file", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
			onUploadProgress
		})
	},

	removeFile(payload){
		return axios.delete( prefix + "/file/remove", {params: payload})
	},

	// content
	getProductContentList(payload){
		return axios.get( prefix + "/content/list", {params: payload})
	},
	createProductContent(payload){
		return axios.post( prefix + "/content/create", payload)
	},
	updateProductContent(payload){
		return axios.put( prefix + "/content/update", payload)
	},
	deleteProductContent(payload){
		return axios.put( prefix + "/content/archive", payload)
	},
	syncProductContentImage(payload, progressCallback = (_percentCompleted: number)=>{})
	{
		const onUploadProgress = (progressEvent) => {
			const percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
			progressCallback(percentCompleted)
		}

		return axios.post( prefix + "/content/sync-image", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
			onUploadProgress
		})
	},
}


export default careerClient