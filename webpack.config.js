const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
	entry: {
		app: path.resolve(__dirname, 'client', 'app.js')
	},
	output: {
		path: path.resolve(__dirname, 'public'),
		filename: 'js/[name].min.js'
	},
	resolve: { extensions: ['.jsx', '.js', '.css'] },
	module: {
		rules: [
			{
				test: /\.(js)$/,
				exclude: path.resolve(__dirname, 'node_modules'),
				loader: 'babel-loader'
			},
			{
				test: /\.(woff|woff2|eot|ttf|svg)$/,
				use: {
					loader: 'url-loader',
					options: {
						limit: 100000
					}
				}
			},
			{
				test: /\.css$/,
				use: ExtractTextPlugin.extract({
					fallback: "style-loader",
					use: {
						loader: "css-loader",
						options: {
							minimize: true
						} 
					}
				})
			},
			{
				test: /\.html$/,
				use: [
					{
						loader: "file-loader",
						options: {
							name: "views/[name]/[name].[ext]",
						},
					},
					{
						loader: "extract-loader",
					},
					{
						loader: "html-loader",
						options: {
							attrs: ["img:src", "link:href"],
							interpolate: true,
						},
					},
				],
			}
		]
	},
	devServer: {
		hot: true,
		stats: "errors-only",
		contentBase: path.join(__dirname, 'dist'),
		inline: true
	},
	plugins: [
		new ExtractTextPlugin({
			filename: 'css/[name].min.css',
			allChunks: true
		}),
		new webpack.HotModuleReplacementPlugin(),
		new webpack.optimize.UglifyJsPlugin(),
		new webpack.optimize.CommonsChunkPlugin({
			name: "vendor",
			minChunks: module => /node_modules/.test(module.resource)
		}),
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
			Popper: ['popper.js', 'default']
		})
	]
}
