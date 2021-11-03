<?php build('content')?>
	
	<a href="<?php echo _route('balancer:index' , null, [
	'module' => GAMES_LOL
	])?>">LOL</a>
	

	<div class="container">
		<div class="table-responsive">
			<?php $counter = 1?>
			<table class="table table-bordered">
				<thead>
					<th>#</th>
					<th>Hero</th>
					<th>Pick Rate</th>
					<th>Win Rate</th>
					<th>Lose Rate</th>
					<th>Balance</th>
				</thead>

				<tbody>
					<?php foreach($topfive as $row) :?>
						<tr>
							<td><?php echo $counter++?></td>
							<td><?php echo $row['avatarName']?></td>
							<td><?php echo $row['pickRate'] .'%'?></td>
							<td><?php echo $row['winRate'] .'%'?></td>
							<td><?php echo $row['loseRate'] .'%'?></td>
							<td>NERF/BUFF</td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>