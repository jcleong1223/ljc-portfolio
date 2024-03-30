import homePage from "./homePage.js"
import contactUsPage from "./contactUsPage.js"
import aboutUsPage from "./aboutUsPage.js"
import capabilityPage from "./capabilityPage.js"
import capabilityDetailPage from "./capabilityDetailPage.js"
import careerDetailPage from "./careerDetailPage.js"
import careerPage from "./careerPage.js"
import fabricationPage from "./fabricationPage.js"
import privacyPolicy from "./privacyPolicy.js"
import termAndCondition from "./termAndCondition.js"

export default {
	"no-data-available": "No Data Available",
	"nav" : {
		"home" : "Home",
		"about-me" : "About Me",
		"contact-me" : "Contact Me",
		"projects" : "Projects",
		"capabilities": "Capabilities",
		"fabrications" : "Fabrications",
		"careers" : "Careers",
		"privacyPolicy" : "Privacy Policy",
		"term&Condition" : "Terms & Conditions",

	},
	"footer": {
		"copyrights": "Copyrights",
		"powered_by": "All rights reserved.",
	},
	... homePage,
	... contactUsPage,
	... aboutUsPage,
	... capabilityPage,
	... capabilityDetailPage,
	... careerDetailPage,
	... careerPage,
	... fabricationPage,
	... privacyPolicy,
	... termAndCondition,
}