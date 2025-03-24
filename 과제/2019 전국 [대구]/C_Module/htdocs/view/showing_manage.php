
		<div class="content">

			<div class="sub__cont">
				<div class="rap">
					<h2>공식 상영작 관리 페이지입니다.</h2>
					<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
					<div class="sub__cont--bar"></div>
				</div>
			</div>
				
			<div class="showing__manage">
				
				<div class="rap">
					
					<form action="/manage/showing" method="post" enctype="multipart/form-data" onsubmit='return false;'>
						
						<p class="showing__manage--valueChk"></p>

						<div>
							<label for="mov_name">영화명</label>
							<input type="text" name="mov_name" id="mov_name" placeholder="영화명">
						</div>

						<div>
							<input type="hidden" id="mov_poster--val">
							<label for="mov_poster">영화 포스터</label>
							<input type="file" name="mov_poster" id="mov_poster" placeholder="영화 포스터" onchange="document.getElementById('mov_poster--val').value = this.value.split('\\')[2]">
						</div>

						<div>
							<label for="pd_name">감독명</label>
							<input type="text" name="pd_name" id="pd_name" placeholder="감독명">
						</div>

						<div>
							<label for="running_time">러닝타임</label>
							<input type="text" name="running_time" id="running_time" placeholder="러닝타임">
						</div>

						<div>
							<button type="submit" class="pointer">공식 상영작 등록</button>
						</div>

					</form>

					<table>
						
						<thead>
							<tr>
								<th>영화명</th>
								<th>감독명</th>
								<th>러닝타임</th>
								<th>등록날짜</th>
								<th>삭제</th> <!-- 버튼 -->
							</tr>
						</thead>

						<tbody>
							<?php foreach ($show_manage as $key => $v): ?>
								<tr>
									<td class="pointer" data-idx='<?php echo $v['idx'] ?>'><?php echo $v['mov_name'] ?></td>
									<td><?php echo $v['pd_name'] ?></td>
									<td><?php echo $v['running_time'] ?></td>
									<td><?php echo $v['register_date'] ?></td>
									<td><button onclick="location='/manage/showing/delete/<?php echo $v['idx'] ?>'">영화 삭제</button></td>
								</tr>
							<?php endforeach ?>
						</tbody>

					</table>

				</div>

			</div>			

		</div>

	