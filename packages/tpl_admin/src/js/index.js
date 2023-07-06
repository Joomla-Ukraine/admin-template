"use strict";

//  SCSS
import '../scss/style.scss';

// JS
import focusOutline from '@denysdesign/js-focus-outline';
import status from './modules/status';

(() => {
    document.addEventListener('DOMContentLoaded', () => {

        // Focus outline
        focusOutline();
        status();

        if (document.querySelector('#system.cck_page_list')) {
            import(
                /* webpackChunkName: "m-seb-list" */
                './modules/seb_list').then(module => {
                module.default();
            })
        }

        if (document.querySelector('.js-calendar')) {
            import(
                /* webpackMode: "lazy" */
                /* webpackPrefetch: true */
                /* webpackPreload: true */
                /* webpackChunkName: "m-js-calendar" */
                './modules/calendar').then(module => {
                module.default();
            })
        }

        if (document.querySelector('.js-select')) {
            import(
                /* webpackMode: "lazy" */
                /* webpackPrefetch: true */
                /* webpackPreload: true */
                /* webpackChunkName: "m-js-select" */
                './modules/choices').then(module => {
                module.default();
            })
        }

        if (document.querySelector('.js-tags')) {
            import(
                /* webpackMode: "lazy" */
                /* webpackPrefetch: true */
                /* webpackPreload: true */
                /* webpackChunkName: "m-js-tags" */
                './modules/tags').then(module => {
                module.default();
            })
        }

        if (document.querySelector('.cck_upload_image')) {
            import(
                /* webpackMode: "lazy" */
                /* webpackPrefetch: true */
                /* webpackPreload: true */
                /* webpackChunkName: "m-js-image" */
                './modules/seb_image').then(module => {
                module.default();
            })
        }

    });
})();