import axios from 'axios';
const prefix = "/client"

const clientClient = {

	getClientList(payload) {
		return axios.get( prefix + "/list", {params: payload})
	},
	createClient(payload){
		return axios.post( prefix + "/create", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
		})
	},
	updateClient(payload){
		return axios.post( prefix + "/update", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
		})
	},
	archiveClient(payload) {
		return axios.delete( prefix + "/archive", {params: payload})
	},
}


export default clientClient