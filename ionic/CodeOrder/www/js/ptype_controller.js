angular.module('starter.controllers')
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
