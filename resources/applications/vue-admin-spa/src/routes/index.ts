import VueRouter, { RouteConfig } from 'vue-router'
import { setPageTitle } from '@src/libs/pageTitle'

import * as AdminModule from '@src/modules/admin/router'
import * as AuthModule from '@src/modules/auth/router'
import * as BannerModule from '@src/modules/banner/router'
import * as DashboardModule from '@src/modules/dashboard/router'
import * as GeneralSettingModule from '@src/modules/generalSetting/router'
import * as UserModule from '@src/modules/user/router'
import * as _GeneralModule from '@src/modules/_general/router'
import * as ProductModule from '@src/modules/product/router'
import * as CareerModule from '@src/modules/career/router'
import * as CertificateModule from '@src/modules/certificate/router'
import * as ClientModule from '@src/modules/client/router'
import * as FabricationModule from '@src/modules/fabrication/router'
import * as ServiceModule from '@src/modules/service/router'
import * as ProductCategoryModule from '@src/modules/productCategory/router'

// Layout
const BaseLayout = () => import('@src/layouts/BaseLayout.vue')

const routes : Array<RouteConfig> = [

	// { path: '/', name: 'landing-page', component: _GeneralModule.LandingPage, meta: { auth: null, title: 'Home' } },

	{ path: '/login', name: 'login', component: AuthModule.Login, meta: { auth: null, title: 'Login' } },
	{ path: '/forgot-password', name: 'forgot-password', component: AuthModule.ForgotPassword, meta: { auth: null, title: 'Forgot Password' } },

	// base_layout
	{ path: '', component: BaseLayout, children: [
		{ path: '/', name: 'home', component: DashboardModule.Dashboard, meta: { auth: true, title: 'Dashboard' }, },

		// admin
		{ path: '/admins/list', name: 'admin.list', component: AdminModule.AdminList, meta: { auth: true, title: 'Admin List' }, },
		{ path: '/admin/info/:id', name: 'admin.info', component: AdminModule.AdminInfo, meta: { auth: true, title: 'Admin Info' } },

		// banner
		{ path: '/banners/list', name: 'banner.list', component: BannerModule.BannerList, meta: { auth: true, title: 'Banner List'}, },

		// user
		{ path: '/users/list', name: 'user.list', component: UserModule.UserList, meta: { auth: true, title: 'User List' }, },
		{ path: '/user/info/:id', name: 'user.info', component: UserModule.UserInfo, meta: { auth: true, title: 'User Info' } },

		// auth
		{ path: '/my/account', name: 'my-account', component: AuthModule.AuthProfile, meta: { auth: true, title: 'Profile' } },

		// general-setting
		{ path: '/general-settings/list', name: 'general-setting.list', component: GeneralSettingModule.listPage, meta: { auth: true, title: 'General Setting List' } },

		// product
		{ path: '/products/list', name: 'product.list', component: ProductModule.ProductList, meta: { auth: true, title: 'Product List' } },
		{ path: '/product/:id', name: 'product.info', component: ProductModule.ProductInfo, meta: { auth: true, title: 'Product Info' } },

		// certificates
		{ path: '/certificates/list', name: 'certificate.list', component: CertificateModule.CertificateList, meta: { auth: true, title: 'Certificate List' } },
		// { path: '/certificate/:id', name: 'certificate.info', component: CertificateModule.CertificateInfo, meta: { auth: true, title: 'Certificate Info' } },

		// career
		{ path: '/careers/list', name: 'career.list', component: CareerModule.CareerList, meta: { auth: true, title: 'Career List' } },
		{ path: '/careers/:id', name: 'career.info', component: CareerModule.CareerInfo, meta: { auth: true, title: 'Career Info' } },
		
		// fabrication
		{ path: '/fabrications/list', name: 'fabrication.list', component: FabricationModule.FabricationList, meta: { auth: true, title: 'Fabrication List' } },
		// { path: '/fabrications/:id', name: 'fabrication.info', component: FabricationModule.FabricationInfo, meta: { auth: true, title: 'Fabrication Info' } },

		// client
		{ path: '/clients/list', name: 'client.list', component: ClientModule.ClientList, meta: { auth: true, title: 'Client List' } },
		// { path: '/clients/:id', name: 'client.info', component: ClientModule.ClientInfo, meta: { auth: true, title: 'Client Info' } },

		// capabilities
		{ path: '/capabilities/list', name: 'capability.list', component: ServiceModule.ServiceList, meta: { auth: true, title: 'Capability List' } },
		{ path: '/capabilities/:id', name: 'capability.info', component: ServiceModule.ServiceInfo, meta: { auth: true, title: 'Capability Info' } },
		

		// product category
		{ path: '/products-categories/list', name: 'product-category.list', component: ProductCategoryModule.ProductCategoryList, meta: { auth: true, title: 'Product Category List'} },
		{ path: '/products-category/:id', name: 'product-category.info', component: ProductCategoryModule.ProductCategoryInfo, meta: { auth: true, title: 'Product Category Info'} },

	]},

	{ path: '/coming-soon', name: 'coming-soon', component: _GeneralModule.ComingSoon, meta: { auth: null, title: 'Coming Soon' } },
	{ path: '*', name: '404', component: _GeneralModule.Error404, meta: { auth: null, title: '404' } }, // must put last
]

const router = new VueRouter({
	mode: 'history',
	routes,
})

router.beforeEach((to, from, next) => {
	setPageTitle(to.meta.title)
	window.scrollTo(0, 0);
	next()
});

export default router
