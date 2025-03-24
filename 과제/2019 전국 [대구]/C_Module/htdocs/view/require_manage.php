

		<div class="content">

			<div class="sub__cont">
				<div class="rap">
					<h2>요청작 관리 페이지입니다.</h2>
					<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
					<div class="sub__cont--bar"></div>
				</div>
			</div>
				
			<div class="require__manage">
				
				<div class="rap">

					<table>
						
						<thead>
							<tr>
								<th>영화명</th>
								<th>감독명</th>
								<th>러닝타임</th>
								<th>현재 상태</th>
								<th>승인/반려 버튼</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($require_data as $key => $v): ?>
								<tr>
									<td class="pointer" data-idx='<?php echo $v['idx'] ?>'><?php echo $v['mov_name'] ?></td>
									<td class="pd__name"><?php echo $v['pd_name'] ?></td>
									<td><?php echo $v['running_time'] ?></td>
									<td><?php echo $v['mov_case'] ?></td>
									
									<td>
										<?php if ($v['mov_case'] === "대기"): ?>
											<button class="pointer"><a href="/manage/require/change/ok/<?php echo $v['idx'] ?>">승인</a></button>
											<button class="pointer"><a href="/manage/require/change/no/<?php echo $v['idx'] ?>">반려</a></button>
										<?php endif ?>

										<?php if ($v['mov_case'] === "반려"): ?>
											<button class="pointer"><a href="/manage/require/change/ok/<?php echo $v['idx'] ?>">승인으로 변경</a></button>
										<?php endif ?>

										<?php if ($v['mov_case'] === "승인" && $v['confirm_case'] === "false"): ?>
											<button class="pointer"><a href="/manage/require/change/no/<?php echo $v['idx'] ?>">반려로 변경</a></button>
										<?php endif ?>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>

					</table>

				</div>

			</div>			

		</div>

