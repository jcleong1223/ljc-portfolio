import axios from 'axios';

const prefix = "/service"

const serviceClient = {

	getServiceList(payload) {
		return axios.get( prefix + "/list", {params: payload})
	},
	getServiceInfo(id, payload){
		return axios.get( prefix + "/info/"+id, {params: payload})
	},
	createService(payload){
		return axios.post( prefix + "/create", payload)
	},
	updateService(payload){
		return axios.post( prefix + "/update", payload)
	},
	archiveService(payload) {
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

	removeFile(payload){
		return axios.delete( prefix + "/file/remove", {params: payload})
	},
}


export default serviceClient