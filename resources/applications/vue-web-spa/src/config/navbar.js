function navbarList(){
	return [
		{
			title : "",
			routes : [
				{
					permissions : null,
					title : "PORTFOLIO",
					to: '/',
					sub: null,
				},
				{
					permissions : null,
					title : "ABOUT",
					to: '/contact-me',
					sub: null,
				},
				{
					permissions : null,
					title : "CONTACT",
					to: '/contact-me',
					sub: null
				},
			]
		},
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
