"use strict";

export default function replaceCheckbox(elClass) {

    const elInput = document.querySelectorAll(elClass);

    elInput.forEach(function (el) {
        el.classList.add('uk-checkbox');
    });

}