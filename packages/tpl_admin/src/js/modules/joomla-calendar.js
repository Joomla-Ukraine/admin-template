"use strict";

/**
 * Add UIKIT3 classes
 */
export default function replaceJCalendar() {

    const elInput = document.querySelectorAll(`.field-calendar .input-append input`),
        elButton = document.querySelectorAll(`.field-calendar .input-append button`),
        elCalendar = document.querySelectorAll(`.js-calendar`);

    elInput.forEach(
        (el) => {
            el.classList.add('uk-width-3-4');
        }
    );

    elButton.forEach(
        (el) => {
            el.classList.add('uk-button');
            el.classList.add('uk-button-small');
            el.classList.add('uk-button-secondary');
            el.innerHTML = `<svg width="21" height="21" class="uk-visible@s" aria-hidden="true"><use xlink:href="//${window.location.host}/templates/admin/assets/icons/icons.svg#calendar"></use></svg>`;
        }
    );

    elCalendar.forEach(
        (el) => {
            let elClass = el.classList;

            document.querySelectorAll(`.${elClass} .calendar-container`)
                .forEach(
                    (el) => {
                        el.style.cssText = 'padding: 15px !important;text-align: center;';
                    }
                );

            document.querySelectorAll(`.${elClass} .table`)
                .forEach(
                    (el) => {
                        el.classList.add('uk-table');
                        el.classList.add('tm-text-steel');
                        el.classList.add('uk-margin-remove');
                        el.style.cssText = 'font-size: 1rem !important;width:100%;min-width: 100%;';
                    }
                );

            document.querySelectorAll(`.${elClass} .table th, .${elClass} .table tr, .${elClass} .table td`)
                .forEach(
                    (el) => {
                        el.style.cssText = 'font-size: .85rem !important;';
                    }
                );

            document.querySelectorAll(`.${elClass} .table .calendar-header .js-btn`)
                .forEach(
                    (el) => {
                        el.style.cssText = 'font-size: 2rem !important;text-decoration:none';
                    }
                );

            document.querySelectorAll(`.${elClass} .table select`)
                .forEach(
                    (el) => {
                        el.classList.add('uk-select');
                    }
                );

            document.querySelectorAll(`.${elClass} .buttons-wrapper .js-btn`)
                .forEach(
                    (el) => {
                        el.classList.add('uk-button');
                        el.classList.add('uk-button-small');
                        el.style.cssText = 'margin:0 5px';
                    }
                );

            document.querySelectorAll(`.${elClass} .buttons-wrapper .btn-clear`)
                .forEach(
                    (el) => {
                        el.classList.add('uk-button-default');
                    }
                );

            document.querySelectorAll(`.${elClass} .buttons-wrapper .btn-today`)
                .forEach(
                    (el) => {
                        el.classList.add('uk-button-primary');
                    }
                );

            document.querySelectorAll(`.${elClass} .buttons-wrapper .btn-exit`)
                .forEach(
                    (el) => {
                        el.classList.add('uk-button-danger');
                    }
                );
        }
    );
}