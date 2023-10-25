"use strict";

const webpack = require('webpack'),
    path = require('path'),
    argv = require('yargs').argv;

const chalk = require("chalk"),
    ProgressBarPlugin = require("progress-bar-webpack-plugin"),
    MiniCssExtractPlugin = require('mini-css-extract-plugin'),
    ImageMinimizerPlugin = require("image-minimizer-webpack-plugin"),
    TerserPlugin = require('terser-webpack-plugin'),
    CopyWebpackPlugin = require('copy-webpack-plugin'),
    ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin'),
    {CleanWebpackPlugin} = require('clean-webpack-plugin');

const {version} = require('./package.json'),
    isDevelopment = argv.mode === 'development',
    isProduction = !isDevelopment,
    distPath = path.join(__dirname, './app');

const entry = {
        main: path.resolve(__dirname, './src/js/index.js'),
        uk: path.resolve(__dirname, './src/js/uikit.js')
    },
    output = {
        filename: `./js/app.[name].${version}.js`,
        path: distPath,
        chunkFilename: `./js/app.[name].${version}.js`,
        pathinfo: false
    },
    resolveAlias = {
        alias: {
            'uikit-util': path.resolve(__dirname, 'node_modules/uikit/src/js/util')
        }
    };

const cleanDirs = [
        '**/app/js/*',
        '**/app/css/*',
        '**/app/fonts/*',
        '**/app/img/*'
    ],
    copyFiles = {
        patterns: [
            {
                from: './src/img',
                to: './img'
            },
            {
                from: './src/flags',
                to: './flags'
            }
        ]
    };

const rulesJS = {
        test: /\.js$/,
        exclude: /(node_modules)/,
        include: path.resolve(__dirname, 'src/js'),
        use: [
            'thread-loader',
            'babel-loader'
        ]
    },
    rulesStyle = {
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
                options: {sourceMap: false}
            },
            {
                loader: 'sass-loader',
                options: {
                    sourceMap: false,
                    sassOptions: {
                        quietDeps: true
                    }
                }
            }
        ]
    },
    rulesStyleDev = {
        test: /\.(sa|sc|c)ss$/,
        use: [
            'style-loader',
            {
                loader: 'css-loader'
            },
            {
                loader: 'sass-loader',
                options: {
                    sassOptions: {
                        quietDeps: true
                    }
                }
            }
        ],
    },
    rulesFonts = {
        test: /\.(woff|woff2)$/,
        type: 'asset/resource',
        generator: {
            filename: 'fonts/[name][ext][query]'
        }
    },
    rulesImg = {
        test: /\.(jpe?g|png|gif|svg|webp|avif)$/,
        type: 'asset/resource',
        generator: {
            filename: 'img/[name][ext][query]'
        }
    };

const pluginProgressBar = new ProgressBarPlugin({
        format: `  :msg [:bar] ${chalk.green.bold(":percent")} (:elapsed s)`,
    }),
    pluginClean = new CleanWebpackPlugin({
        default: cleanDirs
    }),
    pluginMiniCss = new MiniCssExtractPlugin({
        filename: `./css/app.[name].${version}.css`,
        chunkFilename: `./css/app.[name].${version}.css`
    }),
    pluginMCP = new webpack.optimize.ModuleConcatenationPlugin(),
    pluginCopy = new CopyWebpackPlugin(copyFiles),
    pluginReplace = new ReplaceInFileWebpackPlugin([
        {
            dir: path.join(__dirname, '/../../'),
            files: ['build.xml'],
            rules: [
                {
                    search: /<property name="VERSION" value="(.*?)" \/>/ig,
                    replace: '<property name="VERSION" value="' + version + '" />'
                }
            ]
        }, {
            dir: path.join(__dirname, '/inc'),
            files: ['head.php'],
            rules: [
                {
                    search: /\$v = '(.*?)';/ig,
                    replace: '$v = \'' + version + '\';'
                }
            ]
        }, {
            dir: path.join(__dirname, '/html/layouts/tpl'),
            files: ['icon.php'],
            rules: [
                {
                    search: /\$v = '(.*?)';/ig,
                    replace: '$v = \'' + version + '\';'
                }
            ]
        }
    ]),
    pluginImageMin = new ImageMinimizerPlugin({
        minimizer: {
            implementation: ImageMinimizerPlugin.imageminMinify,
            options: {
                plugins: [
                    ["gifsicle", {interlaced: true}],
                    ["jpegtran", {progressive: true}],
                    ["optipng", {optimizationLevel: 5}],
                    ["svgo", {
                        plugins: [{
                            name: "preset-default",
                            params: {
                                overrides: {
                                    removeViewBox: false,
                                    addAttributesToSVGElement: {
                                        params: {
                                            attributes: [
                                                {xmlns: "https://www.w3.org/2000/svg"}
                                            ]
                                        }
                                    }
                                }
                            }
                        }]
                    }]
                ]
            }
        }
    }),
    pluginTerser = new TerserPlugin({
        terserOptions: {
            parse: {
                ecma: 8
            },
            compress: {
                ecma: 5,
                //warnings: false,
                comparisons: false,
                inline: 2,
                //drop_console: true,
                module: false,
                ie8: false,
                keep_classnames: undefined,
                keep_fnames: true,
                arrows: false,
                collapse_vars: false,
                computed_props: false,
                hoist_funs: false,
                hoist_props: false,
                hoist_vars: false,
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
            mangle: {
                safari10: true
            },
            output: {
                ecma: 5,
                comments: false
            }
        },
        parallel: 4,
        extractComments: false
    });

const chunks = {
    cacheGroups: {
        vendors: {
            test(mod) {
                if (mod.context) {
                    let node_modules = mod.context.includes('node_modules'),
                        uikit = ['uikit'].some(str => mod.context.includes(str)),
                        alpinejs = ['alpinejs'].some(str => mod.context.includes(str)),
                        axios = ['axios'].some(str => mod.context.includes(str));

                    return !(!node_modules || uikit || alpinejs || axios);
                }
            },
            name: 'vendors',
            chunks: "all",
            priority: 10,
            enforce: true
        }
    }
};

const configProd = {
    mode: 'production',
    entry: entry,
    output: output,
    cache: {
        type: "filesystem"
    },
    devtool: false,
    performance: {
        hints: false,
        maxEntrypointSize: 512000,
        maxAssetSize: 512000,
    },
    module: {
        rules: [
            rulesJS,
            rulesStyle,
            rulesFonts,
            rulesImg
        ]
    },
    resolve: resolveAlias,
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: JSON.stringify('production')
            }
        }),
        pluginProgressBar,
        pluginClean,
        pluginMiniCss,
        pluginMCP,
        pluginCopy,
        pluginReplace
    ],
    optimization: {
        moduleIds: "deterministic",
        nodeEnv: 'production',
        removeAvailableModules: true,
        usedExports: true,
        minimize: true,
        minimizer: [
            pluginTerser,
            pluginImageMin
        ],
        splitChunks: chunks
    },
    stats: 'errors-only'
};

const configDev = {
    mode: 'development',
    entry: entry,
    output: output,
    cache: {
        type: "filesystem"
    },
    devtool: 'eval-cheap-module-source-map',
    module: {
        rules: [
            rulesJS,
            rulesStyleDev,
            rulesFonts,
            rulesImg
        ]
    },
    resolve: resolveAlias,
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: JSON.stringify('development')
            }
        }),
        pluginProgressBar,
        pluginMiniCss,
        pluginCopy,
        pluginReplace,
        pluginMCP
    ],
    optimization: {
        moduleIds: "deterministic",
        nodeEnv: 'development',
        removeAvailableModules: true,
        usedExports: false,
        minimize: false,
        splitChunks: chunks
    }
};

if (isProduction) {
    module.exports = configProd;
} else {
    module.exports = configDev;
}