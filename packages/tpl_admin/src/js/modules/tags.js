"use strict";

import TomSelect from 'tom-select';
import '../../scss/modules/seb_tom-select.scss';

export default function sebTags() {
    const calendar = document.querySelectorAll(".js-tags");

    calendar.forEach((el) => {
        new TomSelect(el, {
            plugins: [
                'virtual_scroll',
                'remove_button',
                'restore_on_backspace',
                'no_active_items',
            ],
            persist: false,

            hideSelected: true,
            closeAfterSelect: true,
            placeholder: '+ Додати тег...',
            createOnBlur: true,
            create: true,
            valueField: 'tag',
            labelField: 'tag',
            searchField: ['tag'],
            maxOptions: 20,
            firstUrl: function (query) {
                return `//${window.location.host}/templates/admin/ajax/tags.php?term=` + encodeURIComponent(query);
            },
            load: function (query, callback) {
                const url = this.getUrl(query);
                fetch(url)
                    .then(response => response.json())
                    .then(json => {
                        let data = json.data;
                        callback(data);
                    }).catch((e) => {
                    callback();
                });
            },
            render: {
                option_create: function (data, escape) {
                    return '<div class="create">+ Додати <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                },
                no_results: function () {
                    return '<div class="no-results">Нічого не знайдено</div>';
                }
            }
        });
    });
}