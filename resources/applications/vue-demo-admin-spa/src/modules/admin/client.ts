import axios from 'axios';

const prefix = "/admin"

const AdminClient = {

	getInfo(id, payload){
		return axios.get( prefix + "/info/"+id, {params: payload})
	},
	getList(payload){
		return axios.get( prefix + "/list", {params: payload})
	},
	create(payload){
		return axios.post( prefix + "/create", payload)
	},
	update(payload){
		return axios.put( prefix + "/update", payload)
	},
	archive(payload){
		return axios.delete( prefix + "/archive", {params: payload})
	},

	updatePassword(payload){
		return axios.put( prefix + "/update-password", payload)
	},
	checkHasPassword(payload){
		return axios.get( prefix + "/check-password", {params: payload})
	},
	emailResetPassword(payload){
		return axios.post( prefix + "/email-reset-password", payload)
	},
	resendVerificationEmail(payload){
		return axios.post( prefix + "/verification/send", payload)
	},
	toggleVerificationStatus(payload){
		return axios.post( prefix + "/verification/toggle", payload)
	},

	revokeSessionToken(payload){
		return axios.delete( prefix + "/revoke-token", {params: payload})
	},

}

export default AdminClient