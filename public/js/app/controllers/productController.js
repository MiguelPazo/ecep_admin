appAlena.controller('productController', function ($scope, productService) {
    $scope.titleDelete;
    $scope.idDelete;

    $scope.deleteProduct = function (idProduct, product) {
        $scope.idDelete = idProduct;
        $scope.titleDelete = messages.titleDeleteProduct(product);
        $('#modal_delete').openModal();
    }

    $scope.delete = function (idProduct) {
        productService.delete(idProduct, function (response) {
            alert(response);
        });
    }
});

