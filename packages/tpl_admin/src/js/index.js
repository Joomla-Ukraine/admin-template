"use strict";

//  SCSS
import "../scss/style.scss";

// JS
import axios from "axios";

window.axios = axios;
window.uikit_jcalendar_btn = ()=> {};

(
    () => {

        // Add Button Cache
        document.getElementById('remove_cache')
            .addEventListener('click', function (e) {
                e.preventDefault();

                import(/* webpackChunkName: "module-button-cache" */ './modules/button-cache').then(module => {
                    module.default();
                })
            });

        // Add uikit checkbox
        if (document.querySelector('input[type=checkbox]')) {
            import(/* webpackChunkName: "module-checkbox" */ './modules/checkbox').then(module => {
                module.default('input[type=checkbox]');
            })
        }

        // Add uikit for Joomla calendar
        if (document.querySelector('.field-calendar')) {
            import(/* webpackChunkName: "module-joomla-calendar" */ './modules/joomla-calendar').then(module => {
                module.default();
            })
        }

        // Add user status
        if (document.querySelector('#status')) {
            import(/* webpackChunkName: "module-uk-status" */ './modules/status').then(module => {
                module.default('status');
            })
        }

    }
)();