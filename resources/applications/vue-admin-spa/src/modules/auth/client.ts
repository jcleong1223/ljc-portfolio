import axios from 'axios';

const prefix = "/auth"

const AuthClient = {

	changePassword(payload){
		return axios.put( prefix + "/edit-password", payload)
	},
	checkAuthPassword(){
		return axios.get( prefix + "/check-password")
	},
	updateAuthProfile(payload){
		return axios.put( prefix + "/update", payload)
	},
	forgotPassword(payload){
		return axios.post( prefix + "/forgot-password", payload)
	},
	resetPassword(payload){
		return axios.post( prefix + "/reset-password", payload)
	},
	updateAuthAvatar(payload, progressCallback = (_percentCompleted: number)=>{})
	{
		const onUploadProgress = (progressEvent) => {
			const percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
			progressCallback(percentCompleted)
		}

		return axios.post( prefix + "/upload-avatar", payload, {
			headers: { 'Content-Type': 'multipart/form-data'},
			onUploadProgress
		})
	},
}

export default AuthClient