const publicPath = "../../../public"
const applicationPath = "/applications/vue-admin-spa"

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */
let path = require('path');
const mix = require('laravel-mix');
const ESLintPlugin = require('eslint-webpack-plugin');
require('vuetifyjs-mix-extension')

let sassConfig = {};
let outputConfig = {};
let isRunHot = process.argv.includes('--hot');
if (isRunHot) {
	mix.disableSuccessNotifications()
	const fs = require('fs-extra')
	fs.ensureDirSync(`${publicPath}${applicationPath}`)
	outputConfig = {
		chunkFilename: 'js/chunks/[name].js?id=[hash]',
	}
} else {
	sassConfig.additionalData = `$mdi-font-path: '${applicationPath}/fonts/vendor/@mdi';`
	mix.version()
		.copyDirectory('node_modules/@mdi/font/fonts', `${publicPath}${applicationPath}/fonts/vendor/@mdi`);
	outputConfig = {
		publicPath: `${applicationPath}/`,
		chunkFilename: 'js/chunks/[name].js?id=[hash]',
	}
}

mix.setPublicPath(`${publicPath}${applicationPath}`)
	.sourceMaps(false)
	.webpackConfig({
		resolve: {
			extensions: ['.js', '.vue', '.ts'],
			alias: {
				"@src": path.resolve(__dirname, 'src'),
				"@shared": path.resolve(__dirname, "shared"),
			}
		},
		output: outputConfig,
		plugins: [
			// eslint
			new ESLintPlugin({
				extensions: ['js', 'vue', 'ts'],
			}),
		],
	})
	.options({
		hmrOptions: {
			host: "localhost",
			port: 8081,
		}
	})
	.sass('src/styles/sass/index.scss', 'css/app.css', sassConfig)
	.ts('src/main.js', 'js')
	.vuetify('vuetify-loader', 'src/styles/vuetify-loader/index.scss')
	.vue();
