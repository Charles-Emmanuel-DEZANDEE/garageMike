'use strict'

var FormAction = function()
{

    //$('#appbundle_user_car_model').html('<option value="" selected="selected">Selectionner</option>');
    // appel ajax
    $('#appbundle_user_car_brand').on('change', function() {
            let idBrand = 'data=' + this.value;

        $.ajax({
            data: idBrand,
            dataType: 'json',
            method: 'post',
            url: '/fr/form-brand-model',
            success: onChangeFormBrandModel
        })
    })
    let onChangeFormBrandModel = function (response) {

        //on vide la liste du select model
        $('#appbundle_user_car_model').empty();
        let html = '<option value="" selected="selected">Selectionner</option>';

        // on parcourt le tableau des models
        response.map( (el) => {
            html += '<option value="'+el.id+'">'+ el.name +'</option>';
        });
        //on ajoute la liste d'option au select
        $('#appbundle_user_car_model').html(html);

    };
/*
    $('#autocomplete').on('change',function () {
        $('.address_view').show();
    })
*/

}