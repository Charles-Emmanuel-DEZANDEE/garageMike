'use strict'

let linkAjax = $('.link-ajax');

linkAjax.on('click', (e) => {
    e.preventDefault();
    $.ajax({
        data: 'myvar=myvalue&myvar2=myvalue2',
        dataType: 'json',
        url: '/fr/ajax',
        method: 'post',
        success: onAjaxSuccess
    });
});

function onAjaxSuccess(response) {
    window.alert(response.data.myvarResult);

}