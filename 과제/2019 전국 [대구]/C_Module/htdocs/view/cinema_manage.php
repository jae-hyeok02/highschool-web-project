
		<div class="content">

			<div class="sub__cont">
				<div class="rap">
					<h2>영화관 관리 페이지입니다.</h2>
					<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
					<div class="sub__cont--bar"></div>
				</div>
			</div>
				
			<div class="cinema__manage">
				
				<div class="rap">
					
					<form action="/manage/cinema" method="post" enctype="multipart/form-data">

						<div>
							<label for="cinema_name">영화관 이름</label>
							<input type="text" name="cinema_name" id="cinema_name" placeholder="영화관 이름">
						</div>

						<div>
							<label for="cinema_file">영화관 좌석 파일</label>
							<input type="file" accept=".txt" name="cinema_file" id="cinema_file" placeholder="영화관 좌석 파일">
						</div>

						<div>
							<button type="submit" class="pointer">영화관 등록</button>
						</div>

					</form>

					<table>
						
						<thead>
							<tr>
								<th>영화관 이름</th>
								<th>영화관 좌석 보기</th> <!-- 버튼 -->
								<th>영화관 삭제</th> <!-- 버튼 -->
							</tr>
						</thead>

						<tbody>
							<?php foreach ($cinema_data as $key => $v): ?>
								<tr>
									<td><?php echo $v['cinema_name'] ?></td>
									<td><button class="cinema__popup--open pointer" onclick="location='/manage/cinema/<?php echo $v['idx'] ?>/seats'">영화관 좌석 보기</button></td>
									<td><button class="cinema__popup--close pointer" onclick="location='/manage/cinema/delete/<?php echo $v['idx'] ?>'">영화관 삭제하기</button></td>
								</tr>
							<?php endforeach ?>
						</tbody>

					</table>

				</div>

			</div>			

		</div>

		<?php 
			/*<td><button class="cinema__popup--open pointer" value="<?php echo $v['cinema_file'] ?>">영화관 좌석 보기</button></td>*/
		 ?>