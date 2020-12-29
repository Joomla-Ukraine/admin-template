"use strict";

import Choices from "choices.js";

import "choices.js/public/assets/styles/choices.css";

/**
 * Add UIKIT3 checkbox class
 * @param elClass
 */
export default function replaceSelect(elClass) {

    const elInput = document.querySelectorAll(elClass);

    elInput.forEach(function (el) {

        new Choices(el, {
            searchResultLimit: 6,
            placeholder: false,
            itemSelectText: '',
            callbackOnInit: null,
            callbackOnCreateTemplates: null
        });
    });

}