var appEcep = angular.module('ecep', []);

appEcep.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});