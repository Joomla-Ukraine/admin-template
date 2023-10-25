"use strict";

//  SCSS
import '../scss/style.scss';

// JS
import focusOutline from '@denysdesign/js-focus-outline';
import Inputmask from "inputmask";
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';

Alpine.plugin(mask)

window.Alpine = Alpine;
Alpine.start();

window.Inputmask = Inputmask;

(() => {
    document.addEventListener('DOMContentLoaded', () => {

        // Focus outline
        focusOutline();

        const userStatus = document.getElementById('status');
        if (typeof userStatus !== 'undefined' && userStatus !== null) {
            import(
                /* webpackChunkName: "m-user-status" */
                /* webpackPreload: true */
                /* webpackPrefetch: true */
                './modules/status').then(module => {
                module.default();
            });
        }

        const jSystem = document.getElementById('system');
        if (typeof jSystem !== 'undefined' && jSystem !== null) {
            if (document.querySelector('#system.cck_page_list')) {
                import(
                    /* webpackChunkName: "m-seb-list" */
                    './modules/seb_list').then(module => {
                    module.default();
                })
            }
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

        if (document.querySelector('.js-select') || document.querySelector('.js-select-multi')) {
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

        // Inputmask
        if (document.querySelector('.js-input')) {
            import(/* webpackChunkName: "m-js-input", webpackPrefetch: true */ './modules/input').then(module => {
                module.default();
            });
        }

        const cacheRemove = document.getElementById('remove_cache');
        if (typeof cacheRemove !== 'undefined' && cacheRemove !== null) {
            cacheRemove.addEventListener('click', () => {
                import(
                    /* webpackChunkName: "m-cache" */
                    /* webpackPreload: true */
                    /* webpackPrefetch: true */
                    './modules/cache').then(module => {
                    module.default();
                });
            });
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