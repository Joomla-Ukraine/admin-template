"use strict";

import Inputmask from "inputmask";

/**
 * Input Mask for forms
 *
 * @version 1.0
 */
export default function inputMasks() {
    mask('.js-input-phone', '+38 (099) 999-99-99');
}

function mask(inputClass, inputMask, placeholder) {
    let elInput = document.querySelectorAll(inputClass);

    elInput.forEach((el) => {
        let inputID = document.getElementById(el.id),
            hint;

        if (placeholder) {
            hint = {"placeholder": placeholder};
        }

        Inputmask(inputMask, hint).mask(inputID);
    });
}