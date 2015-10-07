angular.module('starter.controllers', [])

    .controller('LoginCtrl',['$scope','$http','$state', 'OAuth',
        function($scope, $http, $state, OAuth){

            $scope.login = function(data) {

                OAuth.getAccessToken(data).then(function(){
                    $state.go('tabs.orders');
                }, function(data){
                    $scope.error_login = data; // "Usuario invalidos";
                });
            }

        }
    ])
    .controller('OrdersCtrl',['$scope','$http','$state',
        function($scope, $http, $state) {

            $scope.getOrders = function() {

                $http.get('http://107.170.148.228/pedido/orders')
                    .success(function(data) {
                        console.log(data);
                        $scope.orders = data._embedded.orders;
                    })
                    .error(function(error){
                        $state.go('tabs.orders');
                    });

            };

            $scope.doRefresh = function() {
                $scope.getOrders();
                $scope.$broadcast('scroll.refreshComplete');
            }

            $scope.getOrders();
        }
    ])
    .controller('PtypesCtrl',['$scope','$http','$state',
        function($scope, $http, $state) {

            $scope.getPtypes = function () {

                $http.get('http://107.170.148.228/pedido/ptypes')
                    .success(function (data) {
                        console.log(data);
                        $scope.ptypes = data._embedded.ptypes;
                    })
                    .error(function (error) {
                        $state.go('tabs.orders');
                    });
            }

            $scope.doRefresh = function() {
                $scope.getPtypes();
                $scope.$broadcast('scroll.refreshComplete');
            }

            $scope.getPtypes();

        },
     ])
    .controller('ProductsCtrl',['$scope','$http','$state',
        function($scope, $http, $state) {

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
                $state.go('tabs.edit_product/'+data.id);
            }

            $scope.getProduct = function(data) {

                $http.get('http://107.170.148.228/pedido/products/'+data.id)
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