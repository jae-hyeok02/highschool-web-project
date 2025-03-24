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
	
	<div id="wrap">
		
		<div class="banner">
			
			<div class="banner__op"></div>

			<div class="rap">
				<header>
				
					<div class="header__link flex">
						<p class="flex fe">
							<?php if (!isset($_SESSION['user'])): ?>
								<a href="/login">로그인</a>
							<?php else: ?>
								<a href="/logout">로그아웃</a>
							<?php endif ?>
						</p>
					</div>

					<div class="header__btm flex sb aic">
						
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
								<!-- <li class="pointer"><a href="/">HOME</a></li> -->
								<li><a href="/intro">영화제 소개</a></li>
								<li><a href="/requestmov">상영 요청</a></li>
								<li><a href="/showingbuy">상영작 예매</a></li>
							</ul>
						</nav>

					</div>

				</header>
		
				<div class="banner__cont">
					<p>아시아 최대 규모의 영화제</p>
					<h1>2019 부산국제영화제</h1>
					<p class="banner__cont--p">
						부산국제영화제는 매년 가을 대한민국 부산광역시<br>
						영화의전당 일원에서 개최되는 국제영화제다.
					</p>
					<button class="pointer">LEARN MORE</button>
				</div>

			</div>
		</div>