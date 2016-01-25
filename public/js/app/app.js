var messages = {
    titleDeleteCategory: function (category) {
        return '¿Esta seguro que desea eliminar la categoría ' + category + '?';
    },
    titleDeleteProduct: function (category) {
        return '¿Esta seguro que desea eliminar el producto ' + category + '?';
    }
};
var appAlena = angular.module('alena', []);

appAlena.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

$(document).ready(function () {
    $('select').material_select();
});