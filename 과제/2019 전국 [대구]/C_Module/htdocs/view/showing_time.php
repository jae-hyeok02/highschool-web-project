	
	<div class="content">
		
		<div class="sub__cont">
			<div class="rap">
				<h2>상영시간표 페이지입니다.</h2>
				<p>아시아 최대 규모의 영화제, 부산국제영화제</p>
				<div class="sub__cont--bar"></div>
			</div>
		</div>

		<div class="showing__timetable">

			<div class="rap">

				<h1>공식 상영작</h1>

				<table>
			
					<thead>
						<tr>
							<th>영화명</th>
							<th>감독명</th>
							<th>러닝타임</th>
							<th>등록 날짜</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($official_data_filter as $key => $v): ?>
							<tr>
								<td class="pointer"><?php echo $v['mov_name'] ?></td>
								<td><?php echo $v['pd_name'] ?></td>
								<td><?php echo $v['running_time'] ?></td>
								<td><?php echo $v['register_date'] ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>

				</table>

				<h1>상영 요청작</h1>

				<table>
					
					<thead>
						<tr>
							<th>영화명</th>
							<th>감독명</th>
							<th>러닝타임</th>
							<th>승인여부</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($request_data_filter as $key => $v): ?>
							<tr>
								<td class="pointer"><?php echo $v['mov_name'] ?></td>
								<td><?php echo $v['pd_name'] ?></td>
								<td><?php echo $v['running_time'] ?></td>
								<td><?php echo $v['mov_case'] ?></td>
							</tr>				
						<?php endforeach ?>
					</tbody>

				</table>

				<div class="timetable_bar"></div>

				<div class="timetable">
					
					<div>
						
						<?php foreach ($cinema as $key => $v): ?>

							<div class="timetable__info">
								<h3><?php echo $v['cinema_name'] ?></h3>
								<div class="timetable__gauge">
									<?php foreach (range(8, 26) as $key => $val): ?>
										<p><?php echo $val ?></p>
									<?php endforeach ?>
								</div>
									
								<div class="timetable__bar" data-idx='<?php echo $v['idx'] ?>'>

									<?php foreach ($movtime as $key => $val): ?>
										<?php if ($val['cinema_idx'] == $v['idx']): ?>

											<?php 
												$t = officialmov::find("idx = ?", $val['movie_idx']);
												$t2 = requestmov::find("idx = ?", $val['movie_idx']);
											 ?>

											<?php if ($val['movie_type'] === "official"): ?>
												<p class='timetable__bar--val' data-name='<?php echo $t['mov_name'] ?>' data-time='<?php echo $t['running_time'] ?>' data-start='<?php echo $val['mov_start'] ?>' data-end='<?php echo $val['mov_end'] ?>'><?php echo $t['mov_name'] ?></p>
											<?php endif ?>

											<?php if ($val['movie_type'] === "request"): ?>
												<p class='timetable__bar--val' data-name='<?php echo $t2['mov_name'] ?>' data-time='<?php echo $t2['running_time'] ?>' data-start='<?php echo $val['mov_start'] ?>' data-end='<?php echo $val['mov_end'] ?>'><?php echo $t2['mov_name'] ?></p>
											<?php endif ?>

										<?php endif ?>
									<?php endforeach ?>

								</div>
							</div>

						<?php endforeach ?>

					</div>

				</div>

			</div>

		</div>

	</div>

	<script>
			
		cinema = `<?php echo json_encode($cinema, JSON_UNESCAPED_UNICODE) ?>`;

		movtime = `<?php echo json_encode($movtime, JSON_UNESCAPED_UNICODE) ?>`;

		offimovie = `<?php echo json_encode($official_data_filter2) ?>`;
		reqmovie = `<?php echo json_encode($request_data_filter2) ?>`;

	</script>


	<?php 

		/*<div class="timetable_bar"></div>

					<div>
						
						<?php foreach ($request_data as $key => $value): ?>
							
							<div class="timetable__info">
								<h3><?php echo $value['mov_name'] ?></h3>
								<div class="timetable__gauge">
									<?php foreach (range(8, 26) as $key => $value): ?>
										<p><?php echo $value ?></p>
									<?php endforeach ?>
								</div>
								<div class="timetable__bar">
									
								</div>
							</div>

						<?php endforeach ?>

					</div>*/

		/*
			<th>영화사명</th>
							<th>사업자등록번호</th>
							<th>영화사 대표 이메일</th>
							<th>영화사 대표 전화번호</th>
								<td class="pointer"><?php echo $v['company_name'] ?></td>
								<td><?php echo $v['busniess_num'] ?></td>
								<td><?php echo $v['company_email'] ?></td>
								<td><?php echo $v['company_num'] ?></td>

		*/

	 ?>
