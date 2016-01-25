appAlena.service('categoryService', function ($http) {
    this.list = function (callback) {
        $http({
            url: BASE_URL + 'admin/category',
            method: 'GET'
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    this.register = function (category, callback) {
        $http({
            url: BASE_URL + 'admin/category',
            method: 'POST',
            params: {
                email: category.description, //faltan mas parámetros
                pass: category.publish
            }
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    //falta probar
    this.update = function (category, callback) {
        $http({
            url: BASE_URL + 'admin/category/' + category.id,
            method: 'PUT',
            params: {
                email: category.description,
                pass: category.publish
            }
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };

    this.delete = function (id, callback) {
        $http({
            url: BASE_URL + 'admin/category/' + id,
            method: 'DELETE'
        }).success(function (response) {
            callback(response);
        }).error(function (response) {
            callback(errorResponse);
        });
    };
});