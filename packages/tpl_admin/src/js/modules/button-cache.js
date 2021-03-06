"use strict";

/**
 * Clean cache button
 */
export default function buttonCache() {

    axios.get(`//${window.location.host}/templates/admin/ajax/cache.php`).then(
        (response) => {

            let result = 'Ok!',
                status = 'primary';

            if (response.data) {
                result = response.data;
                status = 'success';
            }

            UIkit.notification(result, {
                status: status
            });
        }
    ).catch((error) => {
        console.log(error);
    });

}