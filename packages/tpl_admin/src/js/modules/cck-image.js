"use strict";

/**
 * Image manipulations
 * @param elClass
 */
export default function replaceCCKImage(elClass) {

    const elInput = document.querySelectorAll(elClass);

    elInput.forEach(
        (el) => {
            let elClass = el.classList[1];

            document.querySelectorAll(`.${elClass} a`)
                .forEach(
                    (el) => {
                        let img = el.firstElementChild;
                        el.remove();
                        document.querySelectorAll(`.${elClass}`)[0].innerHTML = img.outerHTML;
                    }
                );

        }
    );

}