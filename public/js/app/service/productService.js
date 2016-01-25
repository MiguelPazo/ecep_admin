appAlena.service('productService', function ($http) {
    this.list = function (callback) {
        $http({
            url: BASE_URL + 'admin/product',
            method: 'GET'
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    this.register = function (product, callback) {
        $http({
            url: BASE_URL + 'admin/product',
            method: 'POST',
            params: {
                email: product.description, //faltan mas parámetros
                pass: product.publish
            }
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    //falta probar
    this.update = function (product, callback) {
        $http({
            url: BASE_URL + 'admin/product/' + product.id,
            method: 'PUT',
            params: {
                email: product.description,
                pass: product.publish
            }
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    this.delete = function (id, callback) {
        $http({
            url: BASE_URL + 'admin/product/' + id,
            method: 'DELETE'
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };
});