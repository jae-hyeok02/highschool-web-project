<style>
	header{display: none;}
	div{
		width: 1024px;
		height: 360px;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);		
	}
	ul{
		width: 100%;
		height: 100%;
	}
	li{
		width: 100%;
		display: flex;
		align-items: center;
		height: 20%;
		margin: 10px 0;
		justify-content: space-between;
	}
	p{
		width: 6%;
		height: 100%;
	}
	.seat_1{
		border: 2px solid green;
	}
	.seat_2{
		border: 2px solid blue;
	}
	.seat_3{
		border: 2px solid red;
	}
</style>

<div>
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