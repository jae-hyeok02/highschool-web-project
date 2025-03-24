<?php 
	
	$GLOBALS['route'] = [
		"GET" => [],
		"POST" => []
	];

	session_start();

	date_default_timezone_set("Asia/Seoul");

	define("ROOT", $_SERVER['DOCUMENT_ROOT']);

	function addAdmin() {
		$id_chk = member::find("id = ?", "admin");

		if (!$id_chk) {
			member::insert([
				"id" => "admin",
				"pw" => "1234",
				"name" => "관리자"
			]);
		}
	}

	function move($url, $msg = false) {
		if (is_array($msg)) {
			$msg = implode('\n', $msg);
		}

		if ($msg) {
			echo "<script>alert('$msg')</script>";
		}

		$url = $url == "back" ? "history.back()" : "location='$url'";

		echo "<script>$url</script>";

		exit;
	}

	function err($err, $url, $msg) {
		if ($err) {
			move($url, $msg);
		}
	}

	function view($url, $data = [], $layout = true) {
		extract($data);

		require ROOT."/view/layout/header.php";
		require ROOT."/view/$url.php";
		require ROOT."/view/layout/footer.php";
	}

	function viewAdmin($url, $data = [], $layout = true) {
		extract($data);

		require ROOT."/view/layout/header_admin.php";
		require ROOT."/view/$url.php";
		// require ROOT."/view/layout/footer_admin.php";
	}

	function dd(...$val) {
		echo "<pre>";
			array_map("var_dump", $val);
		echo "</pre>";
	}

	function uri() {
		return unslash(urldecode($_SERVER['REQUEST_URI']));
	}

	function uriArr($key) {
		return explode("/", uri())[$key];
	}

	function unslash($uri) {
		return preg_replace('/^\//', '', $uri);
	}

	function arr($data) {
		return is_array($data) ? $data : [$data];
	}

	function iv($str) {
		return trim(iconv('EUC-KR', 'UTF-8', $str));
	}

	function encode($data) {
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}