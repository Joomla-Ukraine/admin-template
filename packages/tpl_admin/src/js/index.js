"use strict";

//  SCSS
import "../scss/style.scss";

// JS
import axios from "axios";

window.axios = axios;

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
            import(/* webpackChunkName: "module-uk-checkbox" */ './modules/checkbox').then(module => {
                module.default('input[type=checkbox]');
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