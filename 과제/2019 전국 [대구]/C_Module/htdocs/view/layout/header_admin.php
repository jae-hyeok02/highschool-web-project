<?php 
	if (!isset($_SESSION['user'])) {
		move("/", "관리자만 접근가능합니다.");
	}
 ?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/public/style/style.css">
	<title>부산국제영화제</title>
	<script src="/public/js/jquery.js"></script>
	<script src="/public/js/app.js"></script>
</head>
<body>

	<div class="time__modal">
		<div class="time__popup">
			<p class='time__close pointer'>X</p>
			<h2></h2>
			<form action="/showingtime" method="post" onsubmit="return confirm('정말로 시간표를 확정하시겠습니까?')">
				<input type="hidden" name="movie_idx" value="">
				<select name="cinema_idx" id="cinema_idx" required>
					<option value="">선택</option>
					<?php foreach ($cinema as $key => $v): ?>
						<option value="<?php echo $v['idx'] ?>"><?php echo $v['cinema_name'] ?></option>
					<?php endforeach ?>
				</select>
				<input type="text" name="mov_start" placeholder="영화 시작 시간">
				<button type="submit">시작표 확정</button>
			</form>
		</div>					
	</div>

	<div id="wrap">

		<header>

			<div class="rap">
				
				<div class="admin__header--link flex">
					<p class="flex fe">
						<?php if (!isset($_SESSION['user'])): ?>
							<a href="/login">로그인</a>
						<?php else: ?>
							<a href="/logout">로그아웃</a>
						<?php endif ?>
					</p>
				</div>

				<div class="admin__header--btm flex sb aic">
					
					<?php if (!isset($_SESSION['user'])): ?>
						<a href="/" id="logo">
							<img src="/public/images/logo.png" alt="logo">
						</a>
					<?php else: ?>
						<a href="/login" id="logo">
							<img src="/public/images/logo.png" alt="logo">
						</a>
					<?php endif ?>

					<nav>
						<ul class="flex sb">
							<li><a href="/login">LOGIN</a></li>
							<li><a href="/manage/sponsor">스폰서 관리</a></li>
							<li>
								<a href="#">상영작/요청작 관리</a>
								<ul class="sub">
									<li><a href="/manage/showing">공식 상영작 관리</a></li>
									<li><a href="/manage/require">요청작 관리</a></li>
									<li><a href="/showingtime">상영시간표</a></li>
								</ul>
							</li>
							<li><a href="/manage/cinema">영화관 관리</a></li>
						</ul>
					</nav>

				</div>

			</div>
			
		</header>
		
		