import axios from 'axios';

const prefix = "/ref"

const RefClient = {

	getStateList(payload = null){
		return axios.get( prefix + "/state", {params: payload})
	},

}

export default RefClient;