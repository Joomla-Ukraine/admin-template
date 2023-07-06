"use strict";

export default function sebImage() {

    const imageLink = document.querySelector('.cck_upload_image a'),
        image = document.querySelector('.cck_upload_image img'),
        imageGroupForm = document.querySelectorAll('.collection-group-form input[type="hidden"]');

    if (imageLink) {
        imageLink.classList.remove('cboxElement');
        imageLink.removeAttribute('data-cck-modal');
        imageLink.removeAttribute('href');
        imageLink.removeAttribute('rel');
        imageLink.removeAttribute('id');
        imageLink.removeAttribute('title');
        imageLink.style.cursor = 'default';
        imageLink.onclick = null;
    }

    if (image) {
        image.removeAttribute('title');
        image.onclick = null;
    }

    if (imageGroupForm) {
        imageGroupForm.forEach((el) => {
            if (el.value) {
                document.querySelector('.collection-group-button .button-del').hidden();
            }
        });
    }
}