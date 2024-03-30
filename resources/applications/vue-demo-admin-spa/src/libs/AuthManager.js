import Vue from 'vue'
import userConst from '../config/userConst'

function checkRole_(roles){
	if(!(roles instanceof Array)){
		roles = [ roles ]
	}
	let authUser = Vue.prototype.$auth.user()
	return [...roles].includes(authUser.role_id)
}

/*
### CUSTOMER FUNCTION HERE ###
*/
function isSuperAdmin()
{
	return checkRole_([
		userConst.ROLE_SUPER_ADMIN,
		userConst.ROLE_CLIENT_ADMIN,
	]);
}

export{
	isSuperAdmin,
}