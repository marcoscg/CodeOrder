angular.module('starter.controllers')
    .controller('ProductsCtrl',['$scope','$http','$state', '$stateParams',
        function($scope, $http, $state, $stateParams) {

            $scope.getProducts = function(data) {

                $http.get('http://107.170.148.228/pedido/products')
                    .success(function(data) {
                        console.log(data);
                        $scope.products = data._embedded.products;
                    })
                    .error(function(error){
                        $state.go('tabs.orders');
                    })
                    .finally(function() {
                        $scope.$broadcast('scroll.refreshComplete')
                    });

            }

            $scope.get = function(data) {
                $state.go('tabs.edit_product', {id: data.id});
            }

            $scope.getProduct = function() {

                $http.get('http://107.170.148.228/pedido/products/'+$stateParams.id)
                    .success(function(data) {
                        $scope.product = data;
                    })
                    .error(function(error){
                        $state.go('tabs.orders');
                    });

            }

            $scope.salveAddProduct = function(data) {

                $http.post('http://107.170.148.228/pedido/products',data)
                    .success(function(data) {
                        $scope.doRefresh();
                    })
                    .error(function(error){
                        $state.go('tabs.product');
                    });

                $state.go('tabs.product');

            }

            $scope.salveUpdateProduct = function(data) {

                $http.put('http://107.170.148.228/pedido/products/'+data.id,data)
                    .success(function(data) {
                        $scope.doRefresh();
                    })
                    .error(function(error){
                        $state.go('tabs.product');
                    });

                $state.go('tabs.product');

            }

            $scope.onProductDelete = function(data) {

                if(confirm('Deseja realmente excluir esse produto?')) {
                    $http.delete('http://107.170.148.228/pedido/products/' + data.id)
                        .success(function (data) {
                            $scope.doRefresh();
                        })
                        .error(function (error) {
                            $state.go('tabs.product');
                        });
                }

                $state.go('tabs.product');

            }

            $scope.tabProduct = function() {
                $state.go('tabs.product');
            }

            $scope.addProduto = function() {
                $state.go('tabs.add_product');
            }

            $scope.doRefresh = function() {
                $scope.getProducts();
                $scope.$broadcast('scroll.refreshComplete');
            }

        }
    ])