

		<div class="content">

			<div class="sub__cont">
				<div class="rap">
					<h2>스폰서 관리 페이지입니다.</h2>
					<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
					<div class="sub__cont--bar"></div>
				</div>
			</div>
				
			<div class="sponsor__manage">
				
				<div class="rap">
					
					<form action="/manage/sponsor" method="post" enctype="multipart/form-data" onsubmit='return false;'>

						<p class="sponsor__manage--valueChk"></p>

						<div>
							<label for="sponsor_name">스폰서 이름</label>
							<input type="text" name="sponsor_name" id="sponsor_name" placeholder="스폰서 이름">
						</div>

						<div>
							<label for="support_price">후원한 금액</label>
							<input type="text" name="support_price" id="support_price" placeholder="후원한 금액">
						</div>

						<div>
							<input type="hidden" id="sponsor_logo--val">
							<label for="sponsor_logo">스폰서 로고</label>
							<input type="file" name="sponsor_logo" id="sponsor_logo" placeholder="스폰서 로고" onchange="document.getElementById('sponsor_logo--val').value = this.value.split('\\')[2]">
						</div>

						<div>
							<button type="submit" class="pointer">스폰서 등록</button>
						</div>

					</form>

					<table>
						
						<thead>
							<tr>
								<th>스폰서 이름</th>
								<th>후원한 금액</th>
								<th>스폰서 등록날짜</th>
								<th>삭제 버튼</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($sponsor_data as $key => $v): ?>
								<tr>
									<td class="pointer" data-idx="<?php echo $v['idx'] ?>"><?php echo $v['sponsor_name'] ?></td>
									<td><?php echo $v['support_price'] ?></td>
									<td><?php echo $v['register_date'] ?></td>
									<td><button onclick="location='/manage/sponsor/delete/<?php echo $v['idx'] ?>'">스폰서 삭제</button></td>
								</tr>
							<?php endforeach ?>
						</tbody>

					</table>

				</div>

			</div>			

		</div>

		