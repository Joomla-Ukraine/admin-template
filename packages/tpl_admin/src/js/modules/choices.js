"use strict";

import Choices from 'choices.js';
import '../../scss/modules/seb_select.scss';

export default function sebChoises() {
    const selectSingle = document.querySelectorAll(".js-select");

    selectSingle.forEach((el) => {
        new Choices(el, {
            loadingText: 'Завантаження...',
            noResultsText: 'Результатів не знайдено',
            noChoicesText: 'Немає з чого обирати',
            itemSelectText: '',
            uniqueItemText: 'Можна додавати лише унікальні значення',
            customAddItemText: 'Можна додавати лише ті значення, які відповідають певним умовам',
            classNames: {
                containerOuter: 'choices',
                containerInner: 'uk-input',
                input: 'uk-input',
                button: 'uk-button uk-button-primary'
            },
        });
    });

    const selectMulti = document.querySelectorAll(".js-select-multi");

    selectMulti.forEach((el) => {
        new Choices(el, {
            allowHTML: true,
            removeItemButton: true,
            classNames: {
                containerInner: 'uk-textarea',
            },
        });
    });
}