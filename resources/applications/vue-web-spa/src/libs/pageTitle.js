import config from '@src/config/app'
import isFunction from 'lodash/isFunction'

const appName = config.name

export function setPageTitle(pageName = null){
	let title = ""
	if(isFunction(pageName)){
		title = pageName(appName)
	}else{
		title = (pageName != undefined) ? `${pageName} – ${appName}` : appName;
	}

	document.title = title
}