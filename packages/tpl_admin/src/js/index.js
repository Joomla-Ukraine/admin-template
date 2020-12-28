"use strict";

//  SCSS
import "../scss/style.scss";

// JS
//import { listen } from "quicklink";
import axios from "axios";
import focusOutline from "./modules/focus-outline";

window.axios = axios;

(
    () => {
        // Prefetch links
        /*
        listen({
            origins: true,
            ignores: [
                /\/edit?/,
                /(.+)view=login(.+)/,
                /(.+)to=(.+)/,
                /(.+).change(.+)/,
            ]
        });
        */

        // focus outline
        focusOutline();
    }
)();