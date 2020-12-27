jQuery(document).ready(function() {

    // cache
    jQuery("#remove_cache").click(function(e) {
        e.preventDefault();

        jQuery.ajax({
            url: "//" + window.location.host + "/templates/admin/ajax/cache.php",
            success: function(result) {
                UIkit.notification(result, {status: 'success'});
            }
        });

    });

    // css
    jQuery('table input[type=checkbox], .hasTooltip input[type=checkbox]').addClass('uk-checkbox');

    // upload image
    jQuery('.cck_upload_image a').removeAttr('data-cck-modal').removeAttr('href').removeAttr('title').unbind("click").css('cursor', 'default');

    jQuery('.cck_upload_image img').removeAttr('title').unbind("click");

    jQuery('.collection-group-form input[type="hidden"]').each(function() {
        if(this.value) {
            jQuery('.collection-group-button .button-del').hide();
        }
    });

    // calendar
    uikit_jcalendar();

    // status
    status();
});

/*
* Status
*/
function status() {
    var timeout = null;

    function checkStatus() {
        clearTimeout(timeout);

        var status = jQuery('#status');

        status.text(status.data('online-text'));
        status.removeClass('uk-label-warning');
        status.addClass('uk-label-success');
        timeout = setTimeout(function() {
                status.text(status.data('away-text'));
                status.removeClass('uk-label-success');
                status.addClass('uk-label-warning');
            },
            status.data('interval'));
    }

    var status = jQuery('#status');

    if(status.length) {
        if(status.data('enabled') === true) {
            checkStatus();
            jQuery(document).on('mousemove', function() {
                checkStatus();
            });
        } else {
            status.css({'display': 'none'});
        }
    }
}

/*
 * tm_form
 */
function uikit_jcalendar_btn(trigger, tm_button, tm_icon) {
    jQuery(trigger).addClass('uk-width-3-4');
    jQuery(trigger + '_btn').addClass('uk-button uk-button-small ' + tm_button);
    jQuery(trigger + '_btn span').append('<i uk-icon="icon: ' + tm_icon + '"></i>');
}

function uikit_jcalendar() {
    jQuery('.js-calendar .calendar-container').addClass('uk-padding-small');
    jQuery('.js-calendar .table').removeClass('table').addClass('uk-table').css("min-width", "100%");
    jQuery('.js-calendar .daysrow, .js-calendar .day').addClass('uk-text-large');
    jQuery('.js-calendar select.time').addClass('uk-select');
    jQuery('.js-calendar .btn-group .js-btn').addClass('uk-button uk-button-default uk-padding-remove-top uk-padding-remove-bottom uk-padding-small');
    jQuery('.js-calendar .btn-group').removeClass('btn-group').addClass('uk-button-group');
}