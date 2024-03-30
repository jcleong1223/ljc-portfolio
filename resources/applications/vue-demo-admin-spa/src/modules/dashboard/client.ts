import axios from 'axios';

const prefix = "/dashboard"

const DashboardClient = {

	getDashboard(payload){
		return axios.get( prefix, {params: payload})
	},

}

export default DashboardClient;