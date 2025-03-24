
		<div class="content">

			<div class="sub__cont">
				<div class="rap">
					<h2>상영작 예매 페이지입니다.</h2>
					<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
					<div class="sub__cont--bar"></div>
				</div>
			</div>
				
			<div class="showing__buy">
				
				<div class="rap">
					
					<form action="/showingbuy" method="post" onsubmit='return false;'>

						<p class="showing__buy--valueChk"></p>

						<div>
							<label for="name">이름</label>
							<input type="text" name="name" id="name" placeholder="이름">
						</div>

						<div>
							<label for="phone_number">휴대폰번호</label>
							<input type="text" name="phone_number" id="phone_number" placeholder="휴대폰번호">
						</div>

						<div>
							<label for="pw">비밀번호</label>
							<input type="password" name="pw" id="pw" placeholder="비밀번호">
						</div>

						<div>
							<label for="pw_chk">비밀번호 확인</label>
							<input type="password" name="pw_chk" id="pw_chk" placeholder="비밀번호 확인">
						</div>

						<div>
							<label for="cinema_idx">영화관</label>
							<select name="cinema_idx" id="cinema_idx" required>
								<option value="">선택</option>
								<?php foreach ($cinema_data as $key => $v): ?>
									<option value="<?php echo $v['idx'] ?>"><?php echo $v['cinema_name'] ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div>
							<label for="movie_idx">영화</label>
							<select name="movie_idx" id="movie_idx" required disabled="">
								<option value="">선택</option>
								<?php foreach ($movie_data as $key => $v): ?>
									<option value="<?php echo $v['idx'] ?>"><?php echo $v['mov_name'] ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div>
							<label for="">좌석</label>
							<input type="text" name="mov_seat" id="mov_seat" value="" readonly>
						</div>

						<!-- 1~13 -->
						<!-- A~E -->
						<div class="seat">
							
							<ul>
							</ul>

						</div>

						<div>
							<button type="submit" class="pointer">상영작 예매하기</button>
						</div>

					</form>

				</div>

			</div>			

		</div>

	