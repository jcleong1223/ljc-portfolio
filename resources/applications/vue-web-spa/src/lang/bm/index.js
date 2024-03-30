import homePage from "./homePage.js"
import contactUsPage from "./contactUsPage.js"

export default {
	"no-data-available": "Tiada Data",
	"nav" : {
		"home" : "Laman Utama",
		"about-us" : "Tentang Kami",
		"contact-us" : "Hubungi Kami"
	},
	"footer": {
		"copyrights": "Hak Cipta",
		"powered_by": "Hak cipta terpelihara. Dikuasakan oleh {author}",
	},
	... homePage,
	... contactUsPage,
}