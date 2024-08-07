import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'

// Auth base configuration some of this options
// can be override in method calls
const config = {
	auth: bearer,
	http: axios,
	router: router,
	tokenDefaultKey : 'config-X',
	stores: ['storage'],
	rolesVar: 'role_id',
	registerData: {url: 'auth/register', method: 'POST', redirect: '/login'},
	loginData: {url: 'auth/login', method: 'POST', redirect: '', fetchUser: true},
	logoutData: {url: 'auth/logout', method: 'DELETE', redirect: '/', makeRequest: true},
	fetchData: {url: 'auth/user', method: 'GET', enabled: true},
	refreshData: {url: 'auth/refresh', method: 'GET', enabled: false, interval: 30},
	parseUserData: function (res)
	{
		if(res.data && res.data.user){
			return res.data.user;
		}

		localStorage.clear()
		return null;
	},
}

export default config
