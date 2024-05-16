function navbarList(){
	return [
		{
			title : null,
			routes : [
				{
					permissions : null,
					icon: "mdi-home", title : "Home",
					to: { name: "home" },
					sub: null
				},
			]
		},
		{
			title : "Admins",
			routes : [
				// {
				// 	permissions : null,
				// 	icon: "mdi-account-group", title : "Users",
				// 	to: { name: "user.list" },
				// 	sub: null
				// },
				{
					permissions : null,
					icon: "mdi-account-tie", title : "Admins",
					to: { name: "admin.list" },
					sub: null
				},
			]
		},
		{
			title : "System Entities",
			routes : [
				// {
				// 	permissions : null,
				// 	icon: "mdi-image-frame", title : "Banners",
				// 	to: '/banners/list',
				// 	sub: null
				// },
				// {
				// 	permissions : null,
				// 	icon: "mdi-google-photos", title : "Gallery",
				// 	to: '/banners/list',
				// 	sub: null
				// },
				{
					permissions : null,
					icon: "mdi-certificate", title : "Certificate",
					to: '/certificates/list',
					sub: null
				},
				{
					permissions : null,
					icon: "mdi-book", title : "Project",
					to: '/projects/list',
					sub: null
				},
				{
					permissions : null,
					icon: "mdi-tag", title : "Tags",
					to: '/tags/list',
					sub: null
				},
				// {
				// 	permissions : null,
				// 	icon: "mdi-face", title : "Career",
				// 	to: '/careers/list',
				// 	sub: null
				// },
				{
					permissions : null,
					icon: "mdi-wrench", title : "Capability",
					to: '/capabilities/list',
					sub: null
				},
				// {
				// 	permissions : null,
				// 	icon: "mdi-file", title : "Fabrication",
				// 	to: '/fabrications/list',
				// 	sub: null
				// },
				// {
				// 	permissions : null,
				// 	icon: "mdi-account-multiple", title : "Our Clients",
				// 	to: '/clients/list',
				// 	sub: null
				// },

				// {
				// 	permissions : null,
				// 	icon: "mdi-anvil", title : "Products",
				// 	sub: [
				// 		{ title: 'Product', to: { name: 'product.list'} },
				// 		{ title: 'Product Category', to: { name: 'product-category.list'} },
				// 	]
				// },
			]
		},
		// {
		// 	title : "Settings and Utilities",
		// 	routes : [
		// 		{
		// 			permissions : [ "access-backend-content" ],
		// 			icon: "mdi-cog", title : "General Settings",
		// 			to: { name: "general-setting.list" },
		// 			sub: null
		// 		},
		// 	]
		// }
	]
}

export function getNavbarList(authUser)
{
	return navbarList().filter((module)=>
	{
		module.routes = module.routes.filter((route)=>
		{
			if(route.permissions == null) return true;

			const matchAll = route.permissions.every((permission) => authUser.all_permissions.includes(permission))
			return matchAll;
		})
		return !!module.routes
	})
}
