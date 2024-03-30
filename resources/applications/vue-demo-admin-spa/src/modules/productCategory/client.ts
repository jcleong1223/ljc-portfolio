import axios from 'axios';

const prefix = "/product-category"

const productCategoryClient = {

	getProductCategoryList(payload){
		return axios.get( prefix + "/list", {params: payload})
	},
	getProductCategoryInfo(id, payload){
		return axios.get( prefix + "/info/"+id, {params: payload})
	},
	createProductCategory(payload){
		return axios.post( prefix + "/create", payload)
	},
	updateProductCategory(payload){
		return axios.put( prefix + "/update", payload)
	},
	archiveProductCategory(payload){
		return axios.delete( prefix + "/archive", {params: payload})
	},
}

export default productCategoryClient;