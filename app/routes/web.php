<?php
	
	$routes = [];

	$controller = '/TopTenController';

	$routes['topTen'] = [
		'index' => $controller.'/index'
	];

	$controller = '/AvatarController';

	$routes['avatar'] = [
		'index' => $controller.'/index',
		'show' => $controller.'/show'
	];

	$controller = '/BalancerController';

	$routes['balancer'] = [
		'index' => $controller.'/index',
		'show'  => $controller.'/show'
	];
	return $routes;
?>