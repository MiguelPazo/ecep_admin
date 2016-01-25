appAlena.controller('categoryController', function ($scope, categoryService) {
    $scope.titleDelete;
    $scope.idDelete;

    $scope.deleteCategory = function (idCategory, category) {
        $scope.idDelete = idCategory;
        $scope.titleDelete = messages.titleDeleteCategory(category);
        $('#modal_delete').openModal();
    }

    $scope.delete = function (idCategory) {
        categoryService.delete(idCategory, function (response) {
            alert(response);
        });
    }
});

