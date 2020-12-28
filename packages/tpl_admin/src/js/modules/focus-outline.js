"use strict";

export default function focusOutline() {
    window.addEventListener(
        'keyup',
        (e) => {
            if (e.which === 9) {
                document.documentElement.classList.remove('no-focus-outline');
            }
        }
    );
}