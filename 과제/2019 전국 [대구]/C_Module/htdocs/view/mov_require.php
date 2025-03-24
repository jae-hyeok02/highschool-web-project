
		<div class="content">

			<div class="sub__cont">
				<div class="rap">
					<h2>상영요청 페이지입니다.</h2>
					<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
					<div class="sub__cont--bar"></div>
				</div>
			</div>
				
			<div class="mov__require">
				
				<div class="rap">
					
					<form action="/requestmov" method="post" enctype="multipart/form-data" onsubmit='return false;'>

						<p class="mov__require--valuechk">
							
						</p>

						<div>
							<label for="company_name">영화사명</label>
							<input type="text" name="company_name" id="company_name" placeholder="영화사명">
						</div>

						<div>
							<label for="busniess_num">사업자등록번호</label>
							<input type="text" name="busniess_num" id="busniess_num" placeholder="사업자등록번호">
						</div>

						<div>
							<label for="company_email">영화사 대표 이메일</label>
							<input type="email" name="company_email" id="company_email" placeholder="영화사 대표 이메일">
						</div>

						<div>
							<label for="company_num">영화사 대표 전화번호</label>
							<input type="text" name="company_num" id="company_num" placeholder="영화사 대표 전화번호">
						</div>

						<div>
							<label for="mov_name">영화명</label>
							<input type="text" name="mov_name" id="mov_name" placeholder="영화명">
						</div>

						<div>
							<label for="pd_name">감독명</label>
							<input type="text" name="pd_name" id="pd_name" placeholder="감독명">
						</div>

						<div>
							<label for="running_time">러닝 타임</label>
							<input type="text" name="running_time" id="running_time" placeholder="러닝 타임">
						</div>

						<div>
							<input type="hidden" id="mov_poster--val">
							<label for="mov_poster">영화 포스터</label>
							<input type="file" name="mov_poster" id="mov_poster" placeholder="영화 포스터" onchange="document.getElementById('mov_poster--val').value = this.value.split('\\')[2]">
						</div>

						<div>
							<button type="submit" class="pointer">상영 요청하기</button>
						</div>

					</form>

				</div>

			</div>			

		</div>

	