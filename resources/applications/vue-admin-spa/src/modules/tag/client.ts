import axios from 'axios';
const prefix = "/tag"

const projectClient = {

	getList(payload) {
		return axios.get( prefix + "/list", {params: payload})
	},
	create(payload){
		return axios.post( prefix + "/create", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
		})
	},
	update(payload){
		return axios.post( prefix + "/update", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
		})
	},
	archive(payload) {
		return axios.delete( prefix + "/archive", {params: payload})
	},
}


export default projectClient
