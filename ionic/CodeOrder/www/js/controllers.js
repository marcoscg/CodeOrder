angular.module('starter.controllers', [])

    .controller('LoginCtrl',['$scope','$http',
        function($scope, $http){

            $scope.login = function(data) {

                var dataPost = {
                    grant_type: 'password',
                    client_id: 'testclient',
                    client_secret: 'testpass',
                    username: data.username,
                    password: data.password
                };

                $http.post('http://127.0.0.1:8080/oauth',dataPost)
                    .success(function(data) {
                        console.log(data);
                        alert(data.access_token)
                    });

            }

        }
    ])