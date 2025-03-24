<?php 
	
	require "helper/lib.php";
	require "helper/router.php";

	require "http/web.php";

	require "model/base.php";

	$url = explode("/", urldecode($_SERVER['REQUEST_URI']));

	$method = $_SERVER['REQUEST_METHOD'];

	if ($method == "POST") {
		
		foreach ($_POST as $key => $v) {
			err(!$v, "back", "모든 값을 입력해주세요.");
		}
	}

	$err = 1;

	foreach ($route[$method] as $route => $fn) {
		$route = explode("/", $route);
		$params = [];

		if (count($route) != count($url)) {
			continue;
		}

		foreach ($route as $key => $t) {

			if ($t == '$') {
				$params[] = $url[$key];
				continue;
			}

			if ($t != $url[$key]) {
				continue 2;
			}

		}

		$err = 0;
		$fn(...$params);
		return;

	}



