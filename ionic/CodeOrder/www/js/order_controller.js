angular.module('starter.controllers')
    .controller('OrdersCtrl',['$scope','$http','$state',
        function($scope, $http, $state) {

            $scope.getOrders = function() {

                //$http.get('http://107.170.148.228/pedido/orders')
                $http.get('http://127.0.0.1:8080/orders')
                    .success(function(data) {
                        console.log(data);
                        $scope.orders = data._embedded.orders;
                    })
                    .error(function(error){
                        $state.go('tabs.orders');
                    });

            };

            $scope.show = function(order) {
                $state.go('tabs.show', {id: order.id});
            }

            $scope.doRefresh = function() {
                $scope.getOrders();
                $scope.$broadcast('scroll.refreshComplete');
            }

            $scope.getOrders();
        }
    ])
    .controller('OrderShowCtrl',['$scope','$http','$state', '$stateParams',
        function($scope, $http, $state, $stateParams) {

            $scope.getOrder = function() {

                //$http.get('http://107.170.148.228/pedido/orders/'+$stateParams.id)
                $http.get('http://127.0.0.1:8080/orders/'+$stateParams.id)
                    .success(function (data) {
                        console.log(data);
                        $scope.order = data;
                    })
                    .error(function (data) {
                        $scope.erro = data;
                    });

            }

            $scope.getOrder();
        }
    ])
    .controller('OrdersNewCtrl',['$scope','$http','$state',
        function($scope, $http, $state) {

            $scope.clients = [];
            $scope.ptypes = [];
            $scope.products = [];
            $scope.statusList = ["Pedente","Processando","Entregue"];

            $scope.resetOrder = function() {
                $scope.order = {
                    client_id: '',
                    ptype_id: '',
                    item: []
                }
            }

            $scope.getClients = function() {
                $http.get('http://127.0.0.1:8080/clients')
                    .success(function (data) {
                        $scope.clients = data._embedded.clients;
                    })
                    .error(function (data) {
                        $scope.erro = data;
                    });
            }

            $scope.getPtypes = function() {
                $http.get('http://127.0.0.1:8080/ptypes')
                    .success(function (data) {
                        $scope.ptypes = data._embedded.ptypes;
                    })
                    .error(function (data) {
                        $scope.erro = data;
                    });
            }

            $scope.getProducts = function() {
                $http.get('http://127.0.0.1:8080/products')
                    .success(function (data) {
                        $scope.products = data._embedded.products;
                    })
                    .error(function (data) {
                        $scope.erro = data;
                    });
            }

            $scope.setPrice = function(index) {
                var product_id = $scope.order.item[index].product_id;
                for(var i in $scope.products) {
                    if($scope.products.hasOwnProperty(i) && $scope.products[i].id == product_id) {
                        $scope.order.item[index].price = $scope.products[i].price;
                        break;
                    }
                }
                $scope.calculateTotalRow(index);
            }

            $scope.calculateTotalRow = function(index) {
                $scope.order.item[index].total = $scope.order.item[index].quantity * $scope.order.item[index].price;

                $scope.calculateTotal();
            }

            $scope.calculateTotal = function() {
                $scope.order.total = 0;

                for(var i in $scope.order.item) {
                    if($scope.order.item.hasOwnProperty(i)) {
                        $scope.order.total += $scope.order.item[i].total;
                    }
                }

                console.log($scope.order.total);
            }

            $scope.addItem = function() {
                $scope.order.item.push({
                    product_id: '',
                    quantity: 1,
                    price: 0,
                    total: 0
                })
            }

            $scope.save = function() {
                $http.post('http://127.0.0.1:8080/orders', $scope.order)
                    .success(function (data) {
                        console.log(data);
                        $scope.resetOrder();
                        $state.go('tabs.orders');
                    })
                    .error(function (data) {
                        $scope.erro = data;
                    });
            }

            $scope.resetOrder();
            $scope.getClients();
            $scope.getPtypes();
            $scope.getProducts();

        }
    ]);
