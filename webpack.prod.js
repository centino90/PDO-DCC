const path = require('path');
const common = require('./webpack.common');
const { merge } = require('webpack-merge');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = merge(common, {
    mode: "production",
    output: {
        filename: 'js/[name].bundle.js',
        path: path.resolve(__dirname, 'public')
    },
    plugins: [
        new MiniCssExtractPlugin({ filename: "css/[name].css" }),
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: [
                '**/*',
                '!static-files*',
                '!directoryToExclude/**',
                '!index.php',
                '!.htaccess',
                '!img/**',                
            ],
        })
    ],
    module: {
        rules: [
            {
                test: /\.(s[ac]|c)ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "postcss-loader",
                    "sass-loader"
                ]
            }
        ]
    }
    // add source map to css and js files (enabled by default in dev mode only)
    // devtool: "source-map"
});