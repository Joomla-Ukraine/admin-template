"use strict";

/**
 * User online
 * @param {string} el - Status selector
 */
export default function userStatus(el) {
    const elStatus = document.getElementById(el),
        timeOut = null;

    checkStatus(elStatus, timeOut);
    document.addEventListener('mouseup', () => {
        checkStatus(elStatus, timeOut);
    });
}

/**
 * Check Status User online
 * @param timeOut
 * @param elStatus
 */
function checkStatus(elStatus, timeOut) {
    clearTimeout(timeOut);
    elStatus.classList.remove('uk-label-warning');
    elStatus.classList.add('uk-label-success');

    return setTimeout(
        () => {
            elStatus.classList.remove('uk-label-success');
            elStatus.classList.add('uk-label-warning');
        },
        300000
    );
}