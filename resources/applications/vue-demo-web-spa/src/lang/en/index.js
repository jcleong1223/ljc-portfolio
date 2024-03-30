import homePage from "./homePage.js"
import contactUsPage from "./contactUsPage.js"

export default {
	"no-data-available": "No Data Available",
	"nav" : {
		"home" : "Home",
		"about-us" : "About Us",
		"contact-us" : "Contact Us"
	},
	"footer": {
		"copyrights": "Copyrights",
		"powered_by": "All rights reserved.",
	},
	... homePage,
	... contactUsPage,
}