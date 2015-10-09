// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
angular.module('starter', ['ionic','starter.controllers','angular-oauth2'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if(window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
  });
})

.config(function ($stateProvider, $urlRouterProvider, OAuthProvider) {

	OAuthProvider.configure({
		baseUrl: 'http://107.170.148.228/pedido',
		clientId: 'testclient',
		clientSecret: 'testpass',
		grantPath: '/oauth',
		revokePath: '/oauth'
	})

	$stateProvider
		.state('tabs',{
			url: '/t',
			abstract: true,
			templateUrl: 'templates/tabs.html'
		})
		.state('tabs.orders', {
			url: '/orders',
			views: {
				'orders-tab': {
					templateUrl: 'templates/orders.html',
					controller: 'OrdersCtrl'
				}
			}
		})
		.state('tabs.create', {
			url: '/create',
			views: {
				'create-tab': {
					templateUrl: 'templates/create.html'
				}
			}
		})
		.state('tabs.show', {
			url: '/orders/:id',
			views: {
				'orders-tab': {
					templateUrl: 'templates/order-show.html',
					controller: 'OrderShowCtrl'
				}
			}
		})
		.state('tabs.product', {
			url: '/product',
			views: {
				'product-tab': {
					templateUrl: 'templates/product.html',
					controller: 'ProductsCtrl'
				}
			}
		})
		.state('tabs.add_product', {
			url: '/product',
			views: {
				'product-tab': {
					templateUrl: 'templates/create_product.html',
					controller: 'ProductsCtrl'
				}
			}
		})
		.state('tabs.edit_product', {
			url: '/product/:index',
			views: {
				'product-tab': {
					templateUrl: 'templates/edit_product.html',
					controller: 'ProductsCtrl'
				}
			}
		})
		.state('tabs.ptype', {
			url: '/ptype',
			views: {
				'ptype-tab': {
					templateUrl: 'templates/ptype.html',
					controller: 'PtypesCtrl'
				}
			}
		})
		.state('login', {
			url: '/login',
			templateUrl: 'templates/login.html',
			controller: 'LoginCtrl'
		})		
		
	$urlRouterProvider.otherwise('/login');
	
		
})
