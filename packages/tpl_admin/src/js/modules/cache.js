"use strict";

import axios from 'axios';

export default function cache() {
    axios
        .get(`//${window.location.host}/templates/admin/ajax/cache.php`)
        .then(() => {
            UIkit.notification({message: 'Кеш видалено!', status: 'success'});
        });
}