const path = require('path');
var HtmlWebpackPlugin = require('html-webpack-plugin');
module.exports = {
    entry: {
        main: './src/index.js',
        vendor: './src/vendor.js'
    },
    // plugins: [
    //     new HtmlWebpackPlugin({
    //         template: "./src/template.html",
    //         filename: "index.html"
    //     })
    // ],
    module: {
        rules: [
            // {
            //     test: /\.html$/,
            //     use: ['html-loader']
            // },
            {
                test: /\.(svg|png|jpe?g|gif)$/i,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: "[name].[ext]",
                            outputPath: 'assets/img',
                            publicPath: 'assets/img'
                        },
                    }
                ],
            }
        ]
    }
};