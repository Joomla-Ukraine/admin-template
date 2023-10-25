"use strict";

import VanillaCalendar from '@uvarov.frontend/vanilla-calendar';
import '@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.css';
import '@uvarov.frontend/vanilla-calendar/build/themes/light.min.css';

export default function sebChoises() {
    const calendar = document.querySelectorAll(".js-calendar");

    calendar.forEach((el) => {
        let dateNow = new Date(),
            dateSeconds = dateNow.getSeconds();

        dateSeconds = dateSeconds > 9 ? dateSeconds : `0${dateSeconds}`;

        const inCalendar = new VanillaCalendar(el, {
            type: 'default',
            settings: {
                lang: 'uk',
                selection: {
                    time: 24,
                },
                selected: {
                    time: dateNow
                },
            },
            input: true,
            actions: {
                changeToInput(e, calendar, dates, time, hours, minutes, keeping) {
                    if (dates[0]) {
                        calendar.HTMLInputElement.value = `${dates[0]} ${time}:${dateSeconds}`;
                    } else {
                        calendar.HTMLInputElement.value = '';
                    }
                },
            },
        });

        inCalendar.init();
    });
}