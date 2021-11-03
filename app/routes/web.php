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

	$controller = '/LeagueController';

	$routes['league'] = [
		'index' => $controller .'/index',
		'show'  => $controller .'/show'
	];

	$controller = '/LeagueBalancerController';

	$routes['leagueBalancer'] = [
		'index' => $controller .'/index',
		'show' => $controller .'/show',
	];
	
	return $routes;
?>