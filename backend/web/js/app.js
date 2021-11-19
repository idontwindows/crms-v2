var app = angular.module('myApp',['ui.bootstrap']);
app.config(appconfig);
appconfig.$inject = ['$httpProvider'];
function appconfig($httpProvider){
    $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    $httpProvider.defaults.headers.common['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr('content');
};
