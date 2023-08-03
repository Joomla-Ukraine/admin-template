"use strict";

module.exports = {
    plugins: [
        require("@fullhuman/postcss-purgecss")({
            content: [
                './index.php',
                './html/**/*.php',
                './inc/!**!/!*.php',
                './src/!**!/!*.js',
                './app/js/!*.js',
            ],
            safelist: {
                standard: [/data-calendar-.*/],
                deep: [
                    /@/, /\\@/,
                    /uk-drop/,
                    /uk-alert/,
                    /uk-tab/,
                    /uk-table/,
                    /uk-offcanvas/,
                    /uk-label/,
                    /uk-button/,
                    /uk-text/,
                    /uk-padding/,
                    /uk-margin/,
                    /uk-form-horizontal/,
                    /uk-radio/,
                    /uk-notification/,
                    /uk-badge/,
                    /uk-align/,
                    /uk-width/,
                    /uk-background/,
                    /uk-switcher/,

                    /tm-/,

                    /cck/,
                    /collection-/,
                    /icon-/,
                    /horizontal_/,

                    /vanilla-calendar/,
                    /vanilla-calendar-/,
                    /choices/,
                    /is-/,
                    /ts-/,

                    /icon-eye/,
                    /form-control-feedback/,
                    /invalid/,
                    /form-control-danger/,
                ]
            }
        }),

        require('cssnano')({
            preset: [
                'advanced', {
                    discardComments: {
                        removeAll: true
                    },
                    autoprefixer: false,
                    calc: false,
                    cssDeclarationSorter: true,
                    colormin: true,
                    convertValues: true,
                    discardDuplicates: true,
                    discardOverridden: true,
                    discardUnused: true,
                    discardEmpty: true,
                    mergeIdents: true,
                    mergeLonghand: true,
                    mergeRules: true,
                    minifyFontValues: true,
                    minifyGradients: true,
                    minifyParams: true,
                    minifySelectors: true,
                    normalizeCharset: true,
                    normalizeDisplayValues: true,
                    normalizePositions: true,
                    normalizeRepeatStyle: true,
                    normalizeString: true,
                    normalizeTimingFunctions: true,
                    normalizeUnicode: true,
                    normalizeUrl: true,
                    normalizeWhitespace: true,
                    orderedValues: true,
                    reduceIdents: true,
                    reduceInitial: true,
                    reduceTransforms: true,
                    svgo: true,
                    uniqueSelectors: true,
                    zindex: false
                }
            ]
        }),
    ]
};