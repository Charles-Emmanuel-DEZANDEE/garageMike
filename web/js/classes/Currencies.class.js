'use strict'

var Currencies = function()
{
    let linkCurrencies = $('.link-currency');
    linkCurrencies.on('click', (e) => {
/*
        e.preventDefault();
*/
        let dataCurrency = $(e.target).data('currency');
        let data = 'currency=' + dataCurrency;
        console.log('click');

        $.ajax({
            data: data,
            dataType: 'json',
            method: 'post',
            url: '/fr/change-currency',
            success: onChangeCurrencySuccess
        })
    })
    let onChangeCurrencySuccess = function (response) {
        console.log(response);

    }

    // cookies disclaimer

    let closeCookieDisclaimer = $('.close-cookie-disclaimer');
    closeCookieDisclaimer.on('click', (e) => {
        console.log('click');

        $.ajax({
            method: 'post',
            url: '/fr/cookie-disclaimer'
        });
    })
}