'use strict';
/* *********** FONCTION *************************************** */

function runPanier()
{
    var panier = new PanierSession();
    panier.refreshPanier();
}

function runCommande() {
    var orderForm = new OrderForm();
    orderForm.run();
}

function runFormAction() {
    var formAction = new FormAction();

}


/* *********** CODE PRINCIPAL *************************************** */
// js natif
// document.addEventListener("DOMContentLoaded", function(){});
// syntaxe jquery
// $(document).ready(function(){});

// on charge la page avant l'execution du script
$(function(){
    runPanier();
    runCommande();
    runFormAction();

});
