<style>
	header {
		display: none;
	}
</style>

<div class="cinema__seats">
	<ul>
	<?php foreach ($arr as $row): ?>
		<li>
			<?php foreach (str_split($row) as $grade): ?>
				<?php if($grade === "0"): ?>
					<p></p>
				<?php else: ?>
					<p class="seat_<?=$grade?>"></p>
				<?php endif ?>
			<?php endforeach ?>
		</li>
	<?php endforeach ?>
	</ul>
</div>

