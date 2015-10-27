angular.module('starter.controllers')
    .controller('LoginCtrl',['$scope','$http','$state', 'OAuth',
        function($scope, $http, $state, OAuth){

            $scope.login = function(data) {

                OAuth.getAccessToken(data).then(function(){
                    $state.go('tabs.orders');
                }, function(data){
                    $scope.error_login = "Usuario invalidos";
                });
            }

        }
    ])