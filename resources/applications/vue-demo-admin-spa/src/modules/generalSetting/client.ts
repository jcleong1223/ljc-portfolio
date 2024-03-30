import axios from 'axios';

const prefix = "/general-setting"

const GeneralSettingClient = {

	getList(payload = null){
		return axios.get( prefix + "/index", {params: payload})
	},
	update(payload){
		return axios.put( prefix + "/update", payload)
	},

}

export default GeneralSettingClient