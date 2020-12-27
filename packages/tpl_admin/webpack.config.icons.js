"use strict";

const webpack = require('webpack');
const path = require('path');
const argv = require('yargs').argv;
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');

const distPath = path.join(__dirname, 'assets');

const config = {
    entry: {
        sprite: './src/js/sprite.js'
    },
    output: {
        filename: `./sprite/[name].js`,
        path: distPath,
    },
    module: {
        rules: [
            {
                test: /\.svg$/,
                use: [
                    {
                        loader: 'svg-sprite-loader',
                        options: {
                            extract: true,
                            spriteFilename: "icons.svg",
                            runtimeCompat: true,
                            outputPath: 'icons/',
                            publicPath: '/assets/'
                        }
                    },
                    {
                        loader: 'svgo-loader'
                    }
                ]
            }
        ]
    },
    plugins: [
        new SpriteLoaderPlugin()
    ]
};

module.exports = config;