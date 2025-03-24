<?php 

	get("/", function() {

		$sponsor_data = sponsor::all("ORDER BY support_price DESC");

		addAdmin();

		view("index", get_defined_vars());
	});


	/*
	 *	영화제 소개
	 */
	get("/intro", function() {

		view("movintro");
	});


	/*
	 *	상영 요청
	 */
	get("/requestmov", function() {

		view("mov_require");
	});

	post("/requestmov", function() {

		extract($_POST);

		$file = $_FILES['mov_poster'];

		$filename = time().$file['name'];

		move_uploaded_file($file['tmp_name'], ROOT."/public/upload/".$filename);

		requestmov::insert([
			"company_name" => $company_name,
			"busniess_num" => $busniess_num,
			"company_email" => $company_email,
			"company_num" => $company_num,
			"mov_name" => $mov_name,
			"pd_name" => $pd_name,
			"running_time" => $running_time,
			"mov_poster" => $filename,
			"mov_case" => "대기",
			"confirm_case" => "false",
			"movie_type" => "request"
		]);

		move("/", "요청이 완료되었습니다.");
	});


	/*
	 *	상영작 예매
	 */
	get("/showingbuy", function() {

		$cinema_data = cinema::all();
		$movie_data = officialmov::all();

		$test = officialmov::all();
		$test2 = requestmov::all();

		// $test = "<script>document.getElementById('cinema').value</script>";

		view("showing_buy", get_defined_vars());
	});

	// 영화관 선택했을때
	post("/ajax/cinema", function() {

		$arr = [];

		extract($_POST);

		$official = movtime::findAll("movie_type = ? && cinema_idx = ?", ["official", $idx]);
		$request = movtime::findAll("movie_type = ? && cinema_idx = ?", ["request", $idx]);

		foreach ($official as $key => $v) {

			$offi_data = officialmov::findAll("idx = ?", [$v['movie_idx']]);

			foreach ($offi_data as $key => $val) {
				array_push($arr, $val);
			}
		}

		foreach ($request as $key => $v) {

			$req_data = requestmov::findAll("idx = ?", [$v['movie_idx']]);

			foreach ($req_data as $key => $val) {
				array_push($arr, $val);
			}
		}

		echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	});

	// 영화 선택했을때
	post("/ajax/movie", function() {

		extract($_POST);

		$data = cinema::find("idx = ?", $idx);

		extract($data);

		$arr = [];
		$movArr = [];

		$open = fopen(ROOT."/public/upload/".$cinema_file, "r");

		for ($i=0; !feof($open); $i++) {
			$arr[] = trim(fgets($open));
		}

		fclose($open);

		echo json_encode($arr);
	});

	// 좌석 disabled
	post("/ajax/seatchk", function() {

		extract($_POST);

		$info = [];

		$find = moviebuy::findAll("cinema_idx = ? && movie_idx = ?", [ $idx, $movie_idx ]);

		foreach ($find as $key => $v) {
			array_push($info, $v['mov_seat']);
		}

		echo json_encode($info);
	});


	post("/showingbuy", function() {

		extract($_POST);

		$user_data = moviebuy::all();

		err($pw != $pw_chk, "back", "비밀번호와 확인란이 불일치합니다.");

		foreach ($user_data as $key => $v) {
			if ($v['cinema_idx'] == $cinema_idx && $v['movie_idx'] == $movie_idx) {
				if ($v['mov_seat'] == $mov_seat) {
					move("back", "이미 등록된 좌석입니다.");
				}
			}
		}

		moviebuy::insert([
			"phone_number" => $phone_number,
			"name" => $name,
			"pw" => $pw,
			"cinema_idx" => $cinema_idx,
			"movie_idx" => $movie_idx,
			"mov_seat" => $mov_seat
		]);

		move("/", "상영작 예매가 완료되었습니다.");
	});


	/*
	 *	관리자 로그인
	 */
	get("/login", function() {

		view("login");
	});

	post("/login", function() {

		extract($_POST);

		$login = member::find("id = ? && pw = ?", [ $id, $pw ]);

		err(!$login, "back", "아이디 또는 비밀번호가 틀렸습니다.");

		if (!isset($check))
			setcookie("id");
		else
			setcookie("id", $id);

		$_SESSION['user'] = $login;

		move("/manage/sponsor", "로그인이 완료되었습니다.");
	});

	get("/logout", function() {
		session_destroy();

		move("/", "로그아웃이 완료되었습니다.");
	});


	/*
	 *	스폰서 관리
	 */
	get("/manage/sponsor", function() {

		$sponsor_data = sponsor::all("ORDER BY support_price DESC");

		viewAdmin("sponsor_manage", get_defined_vars());
	});

	post("/manage/sponsor", function() {

		extract($_POST);

		$file = $_FILES['sponsor_logo'];

		$filename = time().$file['name'];

		move_uploaded_file($file['tmp_name'], ROOT."/public/upload/".$filename);

		sponsor::insert([
			"sponsor_name" => $sponsor_name,
			"support_price" => $support_price,
			"sponsor_logo" => $filename
		]);

		move("/manage/sponsor", "스폰서 등록이 완료되었습니다");
	});

	get("/manage/sponsor/delete/$", function($sponid) {

		extract($_POST);

		sponsor::delete($sponid);

		move("/manage/sponsor", "스폰서 삭제가 완료되었습니다.");
	});

	post("/ajax/sponsor", function() {

		extract($_POST);

		$sponsor = sponsor::find("idx = ?", [$idx]);

		echo json_encode($sponsor['sponsor_logo'], JSON_UNESCAPED_UNICODE);
	});


	/*
	 *	공식 상영작 관리
	 */
	get("/manage/showing", function() {

		$show_manage = officialmov::all();

		viewAdmin("showing_manage", get_defined_vars());
	});

	post("/manage/showing", function() {

		extract($_POST);	

		$file = $_FILES['mov_poster'];

		$filename = time().$file['name'];

		move_uploaded_file($file['tmp_name'], ROOT."/public/upload/".$filename);

		officialmov::insert([
			"mov_name" => $mov_name,
			"mov_poster" => $filename,
			"pd_name" => $pd_name,
			"running_time" => $running_time,
			"confirm_case" => "false",
			"movie_type" => "official"
		]);

		move("/manage/showing", "공식 상영작 등록이 완료되었습니다");
	});

	get("/manage/showing/delete/$", function($movid) {

		extract($_POST);

		officialmov::delete($movid);

		move("/manage/showing", "공식 상영작 삭제가 완료되었습니다.");
	});

	post("/ajax/showmanage", function() {

		extract($_POST);

		$info = officialmov::find("idx = ?", [$idx]);

		echo json_encode($info['mov_poster'], JSON_UNESCAPED_UNICODE);
	});


	/*
	 *	요청작 관리
	 */ 
	get("/manage/require", function() {

		$require_data = requestmov::all();

		viewAdmin("require_manage", get_defined_vars());
	});

	get("/manage/require/change/ok/$", function($movid) {

		requestmov::update($movid, ["mov_case" => "승인"]);
		move("back", "상태가 업데이트 되었습니다.");
	});

	get("/manage/require/change/no/$", function($movid) {
		
		requestmov::update($movid, ["mov_case" => "반려"]);
		move("back", "상태가 업데이트 되었습니다.");
	});

	post("/ajax/require", function() {

		extract($_POST);

		$req_data = requestmov::find("idx = ?", [$idx]);

		echo json_encode($req_data);
	});


	/*
	 *	상영시간표
	 */
	function startTime($el) {
		return decodeTime($el) - 480;
	}
	
	function decodeTime($time) {

		$timeArr = explode(":", $time);

		return $timeArr[0] * 60 + $timeArr[1];
	}

	function times($minute) {

		// $minute += 20;

		$hour = $minute / 60;
		$min = $minute % 60;

		$hour = floor($hour)+8;

		if (floor($hour) < 10) $hour = "0".floor($hour);
		if ($min <= 9) $min = "0".$min;

		return $hour.":".$min;
	}

	get("/showingtime", function() {

		$cinema = cinema::all();
		$movtime = movtime::all();
		$official_data = officialmov::all();
		$request_data = requestmov::findAll("mov_case = ?", [ "승인" ]);

		$official_data_filter = officialmov::findAll("confirm_case = ?", "false");
		$request_data_filter = requestmov::findAll("mov_case = ? && confirm_case = ?", ["승인", "false"]);

	 	$official_data_filter2 = officialmov::findAll("confirm_case = ?", "true");
		$request_data_filter2 = requestmov::findAll("mov_case = ? && confirm_case = ?", ["승인", "true"]);

		viewAdmin("showing_time", get_defined_vars());
	});

	post("/showingtime", function() {

		extract($_POST);

		err(startTime($mov_start) < 0, "back", "영화관 운영시간은 08:00 부터입니다.");
		err(startTime($mov_start) > 1080, "back", "영화관 운영시간은 26:00 까지입니다.");

		$movtime = movtime::all();

		$movie_data_official = officialmov::find("mov_name = ?", $movie_idx);
		$movie_data_request = requestmov::find("mov_name = ? && mov_case = ?", [ $movie_idx, "승인" ]);

		if (!$movie_data_official['idx']) {

			foreach ($movtime as $key => $v) {
				if ($v['cinema_idx'] == $cinema_idx) {

					// 현재영화의 러닝타임가져오기
					$cur_time = $movie_data_official['running_time'] + 20;

					// 기존 movend 불러와서 기존 movend가 새로운 starttime보다 크면 시간겹침
					err(startTime($v['mov_end']) > startTime($mov_start), "back", "시간이 겹칩니다. 다른 시간대를 입력해주세요.");
					err(($cur_time + startTime($mov_start)) > 1080, "back", "시간이 초과되어 배정할 수 없습니다.");
				}
			}

			requestmov::update($movie_data_request['idx'], [ "confirm_case" => "true" ]);

		} else {

			foreach ($movtime as $key => $v) {
				if ($v['cinema_idx'] == $cinema_idx) {
					
					$cur_time = $movie_data_official['running_time'] + 20;

					err(startTime($v['mov_end']) > startTime($mov_start), "back", "시간이 겹칩니다. 다른 시간대를 입력해주세요.");
					err(($cur_time + startTime($mov_start)) > 1080, "back", "시간이 초과되어 배정할 수 없습니다.");
				}
			}

			officialmov::update($movie_data_official['idx'], [ "confirm_case" => "true" ]);
		}

		$end_time = startTime($mov_start) + $cur_time;

		movtime::insert([
			"movie_type" => !$movie_data_official['idx'] ? "request" : "official",
			"movie_idx" => !$movie_data_official['idx'] ? $movie_data_request['idx'] : $movie_data_official['idx'],
			"cinema_idx" => $cinema_idx,
			"mov_start" => $mov_start,
			"mov_end" => times($end_time)
		]);

		move("back", "시간표 확정이 완료되었습니다.");
	});


	/*
	 *	영화관 관리
	 */
	get("/manage/cinema", function() {

		$cinema_data = cinema::all();

		viewAdmin("cinema_manage", get_defined_vars());
	});

	post("/manage/cinema", function() {

		extract($_POST);

		$file = $_FILES['cinema_file'];

		$filename = time().$file['name'];

		move_uploaded_file($file['tmp_name'], ROOT."/public/upload/".$filename);

		$data_arr = [];

		$handle = @fopen(ROOT."/public/upload/".$filename, "r");

		for ($i=0; !feof($handle); $i++) { 
			$data_arr[] = fgets($handle);
		}

		fclose($handle);

		// 배열의 첫번째 값(배열의 길이)을 가져와서
		$data = strlen(trim($data_arr[0]));

		foreach ($data_arr as $key => $v) {

			// 첫번째 값이랑 비교한 후 다르면 break
			if ($data != strlen(trim($v))) {
				move("/manage/cinema", "잘못된 영화관 좌석 파일입니다.");
				break;
			}
		}

		cinema::insert([
			"cinema_name" => $cinema_name,
			"cinema_file" => $filename
		]);

		move("back", "영화관이 등록되었습니다.");
	});

	get("/manage/cinema/delete/$", function($idx) {

		extract($_POST);

		cinema::delete($idx);

		move("/manage/cinema", "영화관 삭제가 완료되었습니다.");
	});

	get("/manage/cinema/$/seats", function($idx) {

		$data = cinema::find("idx = ?", $idx);

		extract($data);

		$arr = [];

		$open = fopen(ROOT."/public/upload/".$cinema_file, "r");

		for ($i=0; !feof($open); $i++) { 
			$arr[] = trim(fgets($open));
		}

		fclose($open);

		viewAdmin("cinema_seats", get_defined_vars());

	});

 ?>