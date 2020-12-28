"use strict";

const webpack = require('webpack');
const path = require('path');
const argv = require('yargs').argv;
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const Optimizer = require("webpack-bundle-optimizer");
const TerserPlugin = require('terser-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');

const isDevelopment = argv.mode === 'development';
const isProduction = !isDevelopment;
const distPath = path.join(__dirname, 'assets');

const buildVersion = '3.6.5.4';

const entry = {
        main: path.resolve(__dirname, './src/js/index.js'),
        uk: path.resolve(__dirname, './src/js/uikit.js')
    },
    output = {
        filename: `./js/app.[name].${buildVersion}.js`,
        path: distPath,
        publicPath: '../templates/admin/assets/',
        chunkFilename: `./js/app.[name].${buildVersion}.js`,
    };

const cleanDirs = ['**/assets/js/*', '**/assets/css/*', '**/assets/fonts/*'];

const modules = {
    rules: [
        {
            test: /\.js$/,
            exclude: /(node_modules)/,
            include: path.resolve(__dirname, 'src/js'),
            use: [{
                loader: 'babel-loader'
            }]
        },
        {
            test: /\.(sa|sc|c)ss$/,
            use: [
                'style-loader',
                MiniCssExtractPlugin.loader,
                {
                    loader: 'css-loader',
                    options: {sourceMap: false}
                },
                {
                    loader: 'postcss-loader',
                    options: {sourceMap: false, config: {path: 'postcss.config.js'}}
                },
                {
                    loader: 'sass-loader',
                    options: {sourceMap: false}
                }
            ],
        },
        {
            test: /\.(woff|woff2)$/,
            use: [
                {
                    loader: "file-loader",
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'fonts/',
                        publicPath: "../fonts/"
                    }
                }
            ]
        }
    ]
};

const pluginClean = new CleanWebpackPlugin({
        default: cleanDirs
    }),
    pluginOptimizer = new Optimizer(),
    pluginMiniCss = new MiniCssExtractPlugin({
        filename: `./css/app.[name].${buildVersion}.css`,
        chunkFilename: `./css/app.[name].${buildVersion}.css`,
    }),
    pluginMCP = new webpack.optimize.ModuleConcatenationPlugin(),
    pluginReplace = new ReplaceInFileWebpackPlugin([
        {
            dir: path.join(__dirname, 'inc'),
            files: ['head.php'],
            rules: [
                {
                    search: /\$v = '(.*?)';/ig,
                    replace: '$v = \'' + buildVersion + '\';'
                }
            ]
        }
    ]),
    pluginTerser = new TerserPlugin({
        terserOptions: {
            compress: {
                warnings: false,
                module: false,
                ie8: false,
                keep_classnames: undefined,
                keep_fnames: true,
                arrows: false,
                collapse_vars: false,
                comparisons: false,
                computed_props: false,
                hoist_funs: false,
                hoist_props: false,
                hoist_vars: false,
                inline: false,
                loops: false,
                negate_iife: false,
                properties: false,
                reduce_funcs: false,
                reduce_vars: false,
                switches: false,
                toplevel: false,
                typeofs: false,
                booleans: true,
                if_return: true,
                sequences: true,
                unused: true,
                conditionals: true,
                dead_code: true,
                evaluate: true
            },
            mangle: true
        },
        sourceMap: false,
        cache: true,
        parallel: true,
        extractComments: false
    });

const watchOptions = {
        aggregateTimeout: 100,
        ignored: [
            './src/fonts/*',
            'node_modules'
        ]
    },
    stats = {
        warnings: false,
        entrypoints: false,
        children: false
    };

const chunks = {
    cacheGroups: {
        vendor: {
            test(mod) {
                let node_modules = mod.context.includes('node_modules'),
                    uikit = ['uikit'].some(str => mod.context.includes(str));

                return !(!node_modules || uikit);
            },
            name: 'vendors',
            chunks: 'all',
            enforce: true
        }
    }
};

const configProd = {
    mode: 'production',
    entry: entry,
    output: output,
    devtool: false,
    node: {
        console: false,
        process: false,
        Buffer: false,
        setImmediate: false
    },
    watchOptions: watchOptions,
    module: modules,
    plugins: [
        pluginClean,
        pluginMiniCss,
        pluginMCP,
        pluginReplace,
        pluginOptimizer
    ],
    optimization: {
        nodeEnv: 'production',
        removeAvailableModules: true,
        usedExports: false,
        minimize: true,
        minimizer: [
            pluginTerser
        ],
        splitChunks: chunks
    },
    stats: stats
};

const configDev = {
    mode: 'development',
    entry: entry,
    output: output,
    devtool: 'source-map',
    watchOptions: watchOptions,
    module: modules,
    plugins: [
        pluginMiniCss,
        pluginReplace,
        pluginMCP
    ],
    optimization: {
        nodeEnv: 'development',
        splitChunks: chunks
    },
    stats: stats
};

if (isProduction) {
    module.exports = configProd;
} else {
    module.exports = configDev;
}