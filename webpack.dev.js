const path = require('path');
const common = require('./webpack.common');
const { merge } = require('webpack-merge');
module.exports = merge(common, {
    mode: "development",
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'public')
    },
    module: {
        rules: [
            {
                test: /\.(s[ac]|c)ss$/i,
                use: [
                    "style-loader",
                    "css-loader",
                    "postcss-loader",
                    "sass-loader"
                ]
            },
        ]
    },
    devtool: "source-map"
});