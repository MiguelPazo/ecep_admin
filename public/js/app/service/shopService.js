appAlena.service('shopService', function ($http) {
    this.list = function (callback) {
        $http({
            url: BASE_URL + 'admin/shop',
            method: 'GET'
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    this.register = function (shop, callback) {
        $http({
            url: BASE_URL + 'admin/shop',
            method: 'POST',
            params: {
                email: shop.description, //faltan mas parámetros
                pass: shop.publish
            }
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    //falta probar
    this.update = function (shop, callback) {
        $http({
            url: BASE_URL + 'admin/shop/' + shop.id,
            method: 'PUT',
            params: {
                email: shop.description,
                pass: shop.publish
            }
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    this.delete = function (id, callback) {
        $http({
            url: BASE_URL + 'admin/shop/' + id,
            method: 'DELETE'
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };
});