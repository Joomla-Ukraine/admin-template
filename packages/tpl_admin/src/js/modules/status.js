"use strict";

export default function status() {
    let timeout = null,
        status = document.querySelector('#status');

    if (status.length) {
        if (status.data('enabled') === true) {

            checkStatus(timeout, status);

            document.addEventListener('mousemove', () => {
                checkStatus(timeout, status);
            });

        } else {
            status.style.display = 'none';
        }
    }
}

function checkStatus(timeout, status) {
    clearTimeout(timeout, status);

    status.text(status.data('online-text'));
    status.removeClass('uk-label-warning');
    status.addClass('uk-label-success');

    setTimeout(
        () => {
            status.text(status.data('away-text'));
            status.removeClass('uk-label-success');
            status.addClass('uk-label-warning');
        },
        status.data('interval')
    );
}