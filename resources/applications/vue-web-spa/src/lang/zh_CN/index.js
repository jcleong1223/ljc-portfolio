import homePage from "./homePage.js"
import contactUsPage from "./contactUsPage.js"

export default {
	"no-data-available": "暂无数据",
	"nav" : {
		"home" : "首页",
		"about-us" : "关于我们",
		"contact-us" : "联系我们"
	},
	"footer": {
		"copyrights": "版权所有",
		"powered_by": "保留所有权利。由 {author} 提供支持",
	},
	... homePage,
	... contactUsPage,
}