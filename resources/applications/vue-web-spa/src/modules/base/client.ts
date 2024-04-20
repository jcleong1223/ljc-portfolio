import axios from 'axios';

const prefix = "/base"

const BaseClient = {

	getHomePage(payload){
		return axios.get( prefix + "/home", { params:payload })
	},
	submitContactUs(payload){
		return axios.post( prefix + "/contact-us", payload)
	},
	getCapabilitiesPage(payload){
		return axios.get( prefix + "/capabilities", { params:payload })
	},
	getCapabilityInfo(id, payload){
		return axios.get( prefix + "/capabilities/"+id, { params:payload })
	},
	getCareersPage(payload){
		return axios.get(prefix + "/careers",{ params:payload })
	},
	getCareerDetails(id,payload){
		return axios.get(prefix + "/career-detail/"+id, { params:payload })
	},
	submitResume(payload)
	{
		console.log(payload);
		return axios.post(prefix + "/career-application", payload, {
			headers: {
				"Content-Type": "multipart/form-data"
			},
		})
	},
	getFabricationsPage(payload){
		return axios.get( prefix + "/fabrications", { params:payload })
	},
	getPaginatedData(page, payload){
		return axios.get( prefix + "/fabrications/"+page, { params:payload })
	},
	getCertificatesPage(payload){
		return axios.get( prefix + "/certificates", { params:payload })
	},

}

export default BaseClient;