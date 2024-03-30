/** @type {import('vls').VeturConfig} */

// ref: https://vuejs.github.io/vetur/guide/setup.html#advanced
module.exports = {
	// override vscode settings
	// Notice: It only affects the settings used by Vetur.
	settings: {
	  "vetur.useWorkspaceDependencies": true,
	  "vetur.experimental.templateInterpolationService": true
	},
	// support for monorepos
	projects: [
	  './resources/applications/vue-demo-web-spa',
	  './resources/applications/vue-demo-admin-spa',
	]
}

