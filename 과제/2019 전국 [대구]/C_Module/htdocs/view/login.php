		
		<?php if (isset($_SESSION['user'])): ?>
			<script>location='/manage/sponsor'</script>
		<?php endif ?>

		<div class="content">

			<div class="sub__cont">
				<div class="rap">
					<h2>로그인 페이지입니다.</h2>
					<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
					<div class="sub__cont--bar"></div>
				</div>
			</div>
				
			<div class="login">
				
				<div class="rap">
					
					<form action="/login" method="post" onsubmit="return false;">

						<div>
							<input type="checkbox" name="check" id="check" value="<?php echo $id ?>" checked> <label for="check">아이디 저장</label>
						</div>

						<div>
							<label for="id">아이디</label>

							<?php if (isset($_COOKIE['id'])): ?>
								<input type="text" name="id" id="id" placeholder="아이디" value="<?php echo $_COOKIE['id'] ?>">
							<?php else: ?>
								<input type="text" name="id" id="id" placeholder="아이디">
							<?php endif ?>
						</div>

						<div>
							<label for="pw">비밀번호</label>
							<input type="password" name="pw" id="pw" placeholder="비밀번호">
						</div>

						<div>
							<button type="submit" class="pointer">로그인</button>
						</div>

					</form>

				</div>

			</div>			

		</div>

		