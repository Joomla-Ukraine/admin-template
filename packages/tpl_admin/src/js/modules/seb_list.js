"use strict";

export default function sebList() {

    const total = document.querySelector('#system.cck_page_list .total'),
        totalCount = document.querySelector('#system.cck_page_list .total span'),
        tableCheckbox = document.querySelectorAll('table input[type=checkbox]');

    if (total) {
        total.classList.add('uk-text-small');
        totalCount.classList.add('uk-badge');
    }

    if (tableCheckbox) {
        tableCheckbox.forEach((el) => {
            el.classList.add('uk-checkbox');
        });
    }
}