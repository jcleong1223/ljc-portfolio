import axios from 'axios';
const prefix = "/fabrication"

const fabricationClient = {

	getFabricationList(payload) {
		return axios.get( prefix + "/list", {params: payload})
	},
	createFabrication(payload){
		return axios.post( prefix + "/create", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
		})
	},
	updateFabrication(payload){
		return axios.post( prefix + "/update", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
		})
	},
	archiveFabrication(payload) {
		return axios.delete( prefix + "/archive", {params: payload})
	},
}


export default fabricationClient
