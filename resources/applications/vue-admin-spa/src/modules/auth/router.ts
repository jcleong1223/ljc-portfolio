const AuthProfile = () => import('./views/AuthProfile.vue')
const ForgotPassword = () => import('../auth/views/ForgotPassword.vue')
const Login = () => import( '../auth/views/Login.vue')
const ResetPassword = () => import('../auth/views/ResetPassword.vue')

export {
	AuthProfile,
	ForgotPassword,
	Login,
	ResetPassword,
}